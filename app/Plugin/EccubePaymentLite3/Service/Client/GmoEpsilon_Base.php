<?php

namespace Plugin\EccubePaymentLite3\Service\Client;

use Eccube\Entity\Order;
use Eccube\Common\Constant;
use Guzzle\Service\Client;
use Guzzle\Http\Exception\BadResponseException;
use Plugin\EccubePaymentLite3\Entity\CreditAccessBlock;
use Plugin\EccubePaymentLite3\Entity\CreditAccessLogs;
use Plugin\EccubePaymentLite3\Entity\EpsilonMember;
use Plugin\EccubePaymentLite3\Entity\Extension\OrderExtension;
use Plugin\EccubePaymentLite3\Entity\Extension\PaymentExtension;
use Plugin\EccubePaymentLite3\Util\PaymentUtil;
use Plugin\EccubePaymentLite3\Util\PluginUtil;
use Eccube\Entity\MailHistory;
use Guzzle\Http\Exception\RequestException;
use Guzzle\Http\Exception\CurlException;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Plugin\Point\Event\WorkPlace\AdminOrder;

/**
 * 決済モジュール 決済処理 基底クラス
 */
class GmoEpsilon_Base
{

    protected $app;
    protected $const;
    protected $pluginRepository;

    /**
     * コンストラクタ
     *
     * @return void
     */
    function __construct(\Eccube\Application $app)
    {
        $this->app = $app;
        $this->const = $app['config']['EccubePaymentLite3']['const'];
        $this->pluginRepository = $app['eccube.repository.plugin'];
    }

    /**
     * 決済処理
     *
     * @param Order $Order
     * @param PaymentExtension $PaymentExtension
     * @return RedirectResponse
     */
    function payProcess($Order, $PaymentExtension)
    {
        // リクエストパラメータをセット
        $arrParameter = $this->setParameter($Order, $PaymentExtension);

        // データ送信(POST)
        $objPlugin =& PluginUtil::getInstance($this->app);
        $destination_url = $objPlugin->getSubData('destination_url');
        $arrXML = $this->sendData($destination_url, $arrParameter);

        // エラーチェック
        $err_code = $this->getXMLValue($arrXML, 'RESULT', 'ERR_CODE');
        if (!empty($err_code)) {
            $this->app['monolog.gmoepsilon']->addInfo('request error. error_code = ' . $err_code);
            $error_title = 'システムエラーが発生しました。';
            $error_message = $this->getXMLValue($arrXML, 'RESULT', 'ERR_DETAIL');
            return $this->app['view']->render('error.twig', compact('error_title', 'error_message'));
        }

        // 受注番号をセット
        $this->app['session']->set('eccube.plugin.epsilon.orderId', $Order->getId());

        $this->app['monolog.gmoepsilon']->addInfo('=== Data receive response GmoEpsilon_Base === '. print_r($arrXML,true));
        // Epsilonに遷移
        return $this->transitionEpsilon($arrXML);
    }

    /**
     * 決済完了処理
     *
     * @param Order $Order
     * @param array $response
     * @return RedirectResponse
     */
    function compProcess($Order, $response)
    {
        $cartService = $this->app['eccube.service.cart'];

        // チェックパラメータを取得
        $arrCheckParameter = $this->getCheckParameter();

        // パラメータをチェック
        if (!$this->checkParameter($response, $arrCheckParameter)) {
            $this->app['monolog.gmoepsilon']->addInfo('response error. get fraud GET.');
            $error_title = 'システムエラーが発生しました。';
            $error_message = '不正なGETリクエストを受信しました。';
            return $this->app['view']->render('error.twig', compact('error_title', 'error_message'));
        }

        // 受注情報が更新されていない場合 ※決済完了通知との競合を避けるため
        $OrderExtension = $this->app['eccube.plugin.epsilon.repository.order_extension']->find($Order->getId());
        if (empty($OrderExtension)) {
            // トランザクション制御
            $em = $this->app['orm.em'];
            $em->getConnection()->beginTransaction();
            try {
                // 受注情報を更新
                $this->updateOrder($Order, $response);

                $em->getConnection()->commit();
                $em->flush();

                // メール送信
                $this->sendOrderMail($Order);
            } catch (\Exception $e) {
                $em->getConnection()->rollback();
                $em->close();

                $this->app->log($e);

                $this->app->addError('front.shopping.system.error');
                return $this->app->redirect($this->app->url('shopping_error'));
            }

        }

        // カート削除
        $cartService->clear()->save();

        // 受注IDを完了画面に引き継ぐ
        $this->app['session']->set('eccube.front.shopping.order.id', $Order->getId());

        $helper = new AdminOrder();
        $helper->savefromCreidtPay($Order);

        // 注文完了画面に遷移
        return $this->app->redirect($this->app->url('shopping_complete'));
    }

    /**
     * 取得レスポンスパラメータの項目チェック
     *
     * @param array $response
     * @param array $arrCheckParameter
     * @return boolean
     */
    function checkParameter($response, $arrCheckParameter)
    {
        foreach ($arrCheckParameter as $key) {
            if (!isset($response[$key])) {
                return false;
            }
        }

        return true;
    }

    /**
     * 受注情報を更新
     *
     * @param Order $Order
     * @param array $response
     */
    function updateOrder($Order, $response)
    {
        // 受注情報更新
		$OrderStatus = $this->app['eccube.repository.order_status']->find($this->app['config']['order_pre_end']);
        $this->app['eccube.repository.order']->changeStatus($Order->getId(), $OrderStatus);

        // 在庫情報更新
        $this->app['eccube.service.order']->setStockUpdate($this->app['orm.em'], $Order);

        if ($this->app->isGranted('ROLE_USER')) {
            // 会員の場合、購入金額を更新
            $this->app['eccube.service.order']->setCustomerUpdate($this->app['orm.em'], $Order, $this->app->user());

            // 登録済みクレジットカードで決済の場合、定期決済の場合
            if ($Order->getPaymentMethod() === $this->app['config']['EccubePaymentLite3']['const']['PAY_NAME_REG_CREDIT'] ||
                $Order->getPaymentMethod() === $this->app['config']['EccubePaymentLite3']['const']['PAY_NAME_EVERY_MONTH'] ||
                $Order->getPaymentMethod() === $this->app['config']['EccubePaymentLite3']['const']['PAY_NAME_EVERY_OTHER_MONTH'] ||
                $Order->getPaymentMethod() === $this->app['config']['EccubePaymentLite3']['const']['PAY_NAME_EVERY_THREE_MONTH'] ||
                $Order->getPaymentMethod() === $this->app['config']['EccubePaymentLite3']['const']['PAY_NAME_EVERY_SIX_MONTH'] ||
                $Order->getPaymentMethod() === $this->app['config']['EccubePaymentLite3']['const']['PAY_NAME_EVERY_YEAR']) {
                $requestGetUserInfoService = $this->app['eccube.plugin.epsilon.getinfo.services'];
                $results = $requestGetUserInfoService->handle();
                if ($results['status'] === 'OK') {
                    try {
                        $EpsilonMember = $this->app['eccube.plugin.epsilon.repository.epsilon_member']->getEpsilonMemberByCustomerId($Order->getCustomer()->getId());
                        if(is_null($EpsilonMember)){
                            $EpsilonMember = new EpsilonMember();
                        }
                        $cardExpire = $this->app['eccube.plugin.epsilon.service.get_card_expire_date']->getCardExpire($results['cardExpire']);
                        $EpsilonMember->setGmoEpsilonCreditCardExpirationDate($cardExpire);
                        $EpsilonMember->setCardChangeRequestMailSendDate(null);
                        $EpsilonMember->setCustomer($Order->getCustomer());
                        $this->app['orm.em']->persist($EpsilonMember);

                    } catch (\Exception $e) {
                        log_error('Create or update Epsilon Member errors ', array($e->getMessage()));
                        $this->app['monolog.gmoepsilon']->error($e);
                        return false;
                    }
                }
                // Check exist Epsilon Member
                $EpsilonMember = $this->app['eccube.plugin.epsilon.repository.epsilon_member']->getEpsilonMemberByCustomerId($Order->getCustomer()->getId());
                if(is_null($EpsilonMember)){
                    $EpsilonMember = new EpsilonMember();
                }
                // Get card expire of customer from Epsilon
                $cardExpire = $this->app['eccube.plugin.epsilon.service.get_card_expire_date']->getCardExpire($results['cardExpire']);
                $EpsilonMember->setGmoEpsilonCreditCardExpirationDate($cardExpire);
                $EpsilonMember->setCardChangeRequestMailSendDate(null);
            }
        }

        $OrderExtension = new OrderExtension();
        $OrderExtension->setId($Order->getId());
        $OrderExtension->setTransCode($response['trans_code']);
        $OrderExtension->setGmoEpsilonOrderNo($response['order_number']);
        // if(isset($response['state'])){
        //     // Get payment status
        //     $PaymentStatus = $this->app['eccube.plugin.epsilon.repository.payment_status']->find($response['state']);
        //     // Set payment status
        //     $OrderExtension->setPaymentStatus($PaymentStatus);
        // }

        if(isset($response['result'])){
            // Get payment status
            $PaymentStatus = $this->app['eccube.plugin.epsilon.repository.payment_status']->find(1);//仮売上
            // Set payment status
            $OrderExtension->setPaymentStatus($PaymentStatus);
        }

        // Set payment date
        $Order->setPaymentDate(new \DateTime());
        $this->app['orm.em']->persist($Order);
        $this->app['orm.em']->persist($OrderExtension);
    }

    /**
     * 受注メールを送信
     *
     * @param Order $Order
     */
    function sendOrderMail($Order)
    {
        $this->app['eccube.service.mail']->sendOrderMail($Order);

        // 送信履歴を保存.
        $MailTemplate = $this->app['eccube.repository.mail_template']->find(1);

        // 3.0.7ではMailService::sendOrderMailの戻り値がないため再度作成する
        $body = $this->app->renderView($MailTemplate->getFileName(), array(
            'header' => $MailTemplate->getHeader(),
            'footer' => $MailTemplate->getFooter(),
            'Order' => $Order,
        ));

        $MailHistory = new MailHistory();
        $MailHistory
            ->setSubject('[' . $this->app['eccube.repository.base_info']->get()->getShopName() . '] ' . $MailTemplate->getSubject())
            ->setMailBody($body)
            ->setMailTemplate($MailTemplate)
            ->setSendDate(new \DateTime())
            ->setOrder($Order);
        $this->app['orm.em']->persist($MailHistory);
        $this->app['orm.em']->flush($MailHistory);
    }

    /**
     * リクエストパラメータを設定
     *
     * @param Order $Order
     * @param PaymentExtension
     * @return array
     */
    function setParameter($Order, $PaymentExtension)
    {
        $cartItems = array();
        $cartItems = $this->app['eccube.service.cart']->getCart()->getCartItems();

        $objPlugin =& PluginUtil::getInstance($this->app);
        $Customer = $Order->getCustomer();
        $user_id = is_null($Customer) ? 'non_customer' : $Customer->getId();

        $itemInfo = $this->getItemInfo();

        $pluginVersion = $this->pluginRepository->findOneBy(array('code' => 'EccubePaymentLite3'))->getVersion();

        $mission_code = $PaymentExtension->getMissionCode();
        if (is_null($mission_code)) {
            $mission_code = 1;
        } else {
            // 定期購入・非会員の場合、空文字に置き換え
            $user_id = $user_id == 'non_customer' ? '' : $user_id;
        }

        // 送信データを作成
        $arrResult = array(
            'contract_code' => $objPlugin->getSubData('contract_code'),
            'user_id' => $user_id,                                              // ユーザID
            'user_name' => $Order->getName01().$Order->getName02(),             // ユーザ名
            'user_mail_add' => $Order->getEmail(),                              // メールアドレス
            'order_number' => $Order->getId(),                                  // オーダー番号
            'item_code' => $itemInfo['item_code'],                              // 商品コード(代表)
            'item_name' => $itemInfo['item_name'],                              // 商品名(代表)
            'item_price' => $Order->getPaymentTotal(),                          // 商品価格(税込み総額)
            'st_code' => $PaymentExtension->getStCode(),                        // 決済区分
            'mission_code' => $mission_code,                                    // 課金区分(固定)
            'process_code' => '1',                                              // 処理区分(固定)
            'xml' => '1',                                                       // 応答形式(固定)
            'memo1' => "",                                                      // 予備01
            'memo2' => 'EC-CUBE_' . Constant::VERSION . '_' . $pluginVersion . "_" . date('YmdHis'), // 予備02
            'delivery_id' => '99',
            'version' => '1',
            );

        return $arrResult;
    }

    /**
     * リクエストを送信
     *
     * @param string $url
     * @param array $arrParameter
     * @return array or boolean
     */
    function sendData($url, $arrParameter,  $version = null)
    {
        //パラメータの文字コードをUTF8⇒EUCJPに変換
        // mb_convert_variables("EUC-JP", "UTF-8", $arrParameter);
        //CGIバージョンが1の場合は、パラメータの文字コードをUTF8⇒EUCJPに変換
        if (isset($arrParameter['version']) && $arrParameter['version'] === '1') {
            mb_convert_variables('SJIS-win', 'UTF-8', $arrParameter);
        }

        $arrVal = array();

        // POSTデータを送信し、応答情報を取得する
        $client = new Client();

        try {
            $request = $client->post($url, array(), $arrParameter);
            $response = $request->send();
        } catch (CurlException $e) {
            $this->app['monolog.gmoepsilon']->addInfo('CurlException. url='.$url.' parameter='.print_r($arrParameter,true));
            return $e->getErrorNo();
        } catch (BadResponseException $e) {
            $this->app['monolog.gmoepsilon']->addInfo('BadResponseException. url='.$url.' parameter='.print_r($arrParameter,true));
            return false;
        } catch (\Exception $e) {
            $this->app['monolog.gmoepsilon']->addInfo('Exception. url='.$url.' parameter='.print_r($arrParameter,true));
            return false;
        }

        $response = $response->getBody(true);

        if (is_null($response)) {
            // $msg = 'レスポンスデータエラー: レスポンスがありません。';
            return false;
        }

        // Shift-JISをUNICODEに変換する
        $response = str_replace("x-sjis-cp932", "UTF-8", $response);

        // XMLパーサを生成する。
        $parser = xml_parser_create('utf-8');

        // 空白文字は読み飛ばしてXMLを読み取る
        xml_parser_set_option($parser,XML_OPTION_TARGET_ENCODING,"UTF-8");
        xml_parser_set_option($parser,XML_OPTION_SKIP_WHITE,1);

        // 配列にXMLのデータを格納する
        $err = xml_parse_into_struct($parser,$response,$arrVal,$idx);

        // 開放する
        xml_parser_free($parser);

        return $arrVal;

    }

    /**
     * Epsilon決済画面に遷移
     *
     * @param array $arrXML
     * @return RedirectResponse
     */
    function transitionEpsilon($arrXML)
    {
        // Epsilon決済画面に遷移
        $url = $this->getXMLValue($arrXML,'RESULT','REDIRECT');
        return $this->app->redirect($url);
    }

    /**
     * カートから代表商品情報を取得
     *
     * @return array
     */
    function getItemInfo()
    {
        $CartItems = $this->app['eccube.service.cart']->getCart()->getCartItems();
        foreach ($CartItems as $value) {
            $CartItem = $value;
            break;
        }
        $ProductClass = $CartItem->getObject();
        $Product = $ProductClass->getProduct();

        $itemInfo = array();
        $itemInfo['item_code'] = $ProductClass->getCode();
        $itemInfo['item_name'] = $Product->getName().'×'.$CartItem->getQuantity().'個（代表）';

        return $itemInfo;
    }

    /**
     * XMLのタグを指定し、要素を取得
     *
     * @param array $arrVal
     * @param string $tag
     * @param string $att
     * @return string
     */
    function getXMLValue($arrVal, $tag, $att)
    {
        $ret = "";
        foreach((array)$arrVal as $array) {
            if($tag == $array['tag']) {
                if(!is_array($array['attributes'])) {
                    continue;
                }
                foreach($array['attributes'] as $key => $val) {
                    if($key == $att) {
                        $ret = mb_convert_encoding(urldecode($val), 'UTF-8', 'SJIS');
                        break;
                    }
                }
            }
        }

        return $ret;
    }

    /**
     * 注文完了画面、受注メール用の決済情報を設定 (same as the EC-CUBE2)
     *
     * @param array $arrPayInfo
     * @param string $key
     * @param string $name
     * @param string $value
     */
    function setPayInfo(&$arrPayInfo, $key, $name, $value)
    {
        $arrPayInfo[$key]['name'] = $name;
        $arrPayInfo[$key]['value'] = $value;
    }

    /**
     * 不正アクセスブロック処理
     *
     * @return boolean
     */
    function accessBlockProcess()
    {
        $objPlugin =& PluginUtil::getInstance($this->app);
        $block_mode = $objPlugin->getSubData('block_mode');

        $error_page_flg = false;

        if ($block_mode === 1) {
            $block_flg = false;

            // アクセス頻度時間を過ぎたIPアドレスを削除
            $this->app['eccube.plugin.epsilon.repository.credit_access_logs']->deleteAllIpAddressForPassedAccessFrequencyTime($objPlugin->getSubData('access_frequency_time'));
            // ブロック時間を過ぎたIPアドレスを削除
            $this->app['eccube.plugin.epsilon.repository.credit_access_block']->deleteAllIpAddressForPassedBlockTime($objPlugin->getSubData('block_time'));

            $arrWhiteList = explode(",", $objPlugin->getSubData('white_list'));
            $is_registed_whiteList = in_array($_SERVER["REMOTE_ADDR"], $arrWhiteList);
            if (!$is_registed_whiteList) {
                $this->registCreditAccessLog();
            }

            if ($this->isAlreadyBlockedCreditAccess()) {
                $block_flg = true;
            } else if (!$is_registed_whiteList) {
                $block_flg = $this->judgeAccessBlocking();
            }

            if ($block_flg && !$is_registed_whiteList) {
                $error_page_flg = true;
            }
        }

        return $error_page_flg;
    }

    /**
     * 既に不正アクセスとしてブロックされていないか確認する
     */
    public function isAlreadyBlockedCreditAccess()
    {
        $creditBlock = $this->app['eccube.plugin.epsilon.repository.credit_access_block']->findBy(['ip_address' => $_SERVER["REMOTE_ADDR"]]);

        return $creditBlock ? true : false;
    }

    /**
     * クレジットアクセスログを記録する
     */
    public function registCreditAccessLog()
    {
        $date = new \DateTime();
        $this->app['monolog.gmoepsilon']->addInfo("regist access log IPADDRESS:$_SERVER[REMOTE_ADDR] DATE:{$date->format("Y-m-d H:i:s")}");
        $creditAccessLogs = new CreditAccessLogs();

        $creditAccessLogs
            ->setIpAddress($_SERVER["REMOTE_ADDR"])
            ->setAccessDate($date);
        $this->app['orm.em']->persist($creditAccessLogs);
        $this->app['orm.em']->flush($creditAccessLogs);
    }

    /**
     * 不正アクセスをブロックする
     *
     * @return boolean
     */
    public function judgeAccessBlocking()
    {
        $access_block_flg = false;

        $creditAccessLog = $this->app['eccube.plugin.epsilon.repository.credit_access_logs']->findBy(array('ip_address' => $_SERVER["REMOTE_ADDR"]));

        $objPlugin =& PluginUtil::getInstance($this->app);
        if (count($creditAccessLog) >= $objPlugin->getSubData('access_frequency')) {
            // 不正アクセスと判断
            $date = new \DateTime();
            $this->app['monolog.gmoepsilon']->addInfo("access block IPADDRESS:$_SERVER[REMOTE_ADDR] DATE:{$date->format("Y-m-d H:i:s")}");

            $creditAccessBlock = new CreditAccessBlock();

            $creditAccessBlock
                ->setIpAddress($_SERVER["REMOTE_ADDR"])
                ->setBlockDate(new \DateTime());
            $this->app['orm.em']->persist($creditAccessBlock);
            $this->app['orm.em']->flush($creditAccessBlock);

            $access_block_flg = true;
        }

        return $access_block_flg;
    }

}
