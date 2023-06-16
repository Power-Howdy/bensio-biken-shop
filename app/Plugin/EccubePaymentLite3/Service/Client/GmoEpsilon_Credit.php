<?php

namespace Plugin\EccubePaymentLite3\Service\Client;

use DateTime;
use Eccube\Common\Constant;
use Eccube\Entity\Order;
use Plugin\EccubePaymentLite3\Entity\EpsilonMember;
use Plugin\EccubePaymentLite3\Entity\Extension\OrderExtension;
use Plugin\EccubePaymentLite3\Entity\Extension\PaymentExtension;
use Plugin\EccubePaymentLite3\Util\PluginUtil;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * 決済モジュール 決済処理: クレジットカード
 */
class GmoEpsilon_Credit extends GmoEpsilon_Base
{

    /**
     * コンストラクタ
     *
     * @return void
     */
    function __construct(\Eccube\Application $app)
    {
        parent::__construct($app);
        $this->app = $app;
        $this->const = $app['config']['EccubePaymentLite3']['const'];
        $this->gmoEpsilonService = $this->app['eccube.plugin.epsilon.services'];
        $this->gmoEpsilonRequestService = $this->app['eccube.plugin.epsilon.request.services'];
        $this->pluginRepository = $app['eccube.repository.plugin'];
    }

    /**
     * Check Ip Black List
     *
     * @return bool
     */
    function checkIpBlackList() {
        return $this->app['eccube.plugin.epsilon.service.ip_black_list']->handle();
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
        // 不正アクセスブロック処理を行う
        $error_page_flg = $this->accessBlockProcess();

        // ブロック対象の場合エラーを表示し、処理を中断
        if($error_page_flg){
            $error_title = '購入エラー';
            $error_message = '購入処理でエラーが発生しました。';
            return $this->app['view']->render('error.twig', compact('error_title', 'error_message'));
        }

        if ($this->checkIpBlackList()) {
            $error_title = '購入エラー';
            $error_message = '購入処理でエラーが発生しました。';
            return $this->app['view']->render('error.twig', compact('error_title', 'error_message'));
        }
        return parent::payProcess($Order, $PaymentExtension);
    }

    /**
     * トークン決済処理
     * @param $Order
     * @param $PaymentExtension
     * @return mixed
     */
    function payCreditTokenProcess($Order, $PaymentExtension)
    {
        // 不正アクセスブロック処理を行う
        $error_page_flg = $this->accessBlockProcess();
        // ブロック対象の場合エラーを表示し、処理を中断
        if($error_page_flg){
            $error_title = '購入エラー';
            $error_message = '購入処理でエラーが発生しました。';
            return $this->app['view']->render('error.twig', compact('error_title', 'error_message'));
        }
        $token = $this->app['request']->get('token');
        // リクエストパラメータをセット
        $arrParameter = $this->setTokenParameter($Order, $PaymentExtension, $token);
        // データ送信(POST)
        $xmlResponse = $this->gmoEpsilonRequestService->sendData($this->gmoEpsilonService->getUrl('direct_card_payment'),$arrParameter);
        $this->app['monolog.gmoepsilon']->addInfo(' Receive Data = ' . print_r($xmlResponse, true));
        // エラーチェック
        $errCode = $this->gmoEpsilonRequestService->getXMLValue($xmlResponse, 'RESULT', 'ERR_CODE');

        if (!empty($errCode)) {
            $this->app['monolog.gmoepsilon']->addInfo('request error. error_code = ' . $errCode);
            $error_title = 'システムエラーが発生しました。';
            $error_message = $this->gmoEpsilonRequestService->getXMLValue($xmlResponse, 'RESULT', 'ERR_DETAIL');
            return $this->app['view']->render('error.twig', compact('error_title', 'error_message'));
        }

        $response = array(
            'trans_code' => $this->gmoEpsilonRequestService->getXMLValue($xmlResponse, 'RESULT', 'TRANS_CODE'),
            'order_number' => $Order->getId()
        );
        // 受注番号をセット
        $this->app['session']->set('eccube.front.shopping.order.id', $Order->getId());

        // 0：決済NG   1：決済OK  5：3DS処理（カード会社に接続必要）    9：システムエラー（パラメータ不足、不正等）
        // 3DS処理（カード会社に接続必要）
        $results = (int) $this->gmoEpsilonRequestService->getXMLValue($xmlResponse, 'RESULT', 'RESULT');
        if ($results === $this->const['receive_parameters']['result']['3ds']) {
            // 3Dセキュア認証送信パラメータ1　加盟店様⇒カード会社
            return $this->app['view']->render('EccubePaymentLite3/Twig/shopping/transition_3ds_screen.twig', array(
                // 3DS処理時カード会社への接続用URLエンコードされています。
                'AcsUrl' => $this->gmoEpsilonRequestService->getXMLValue($xmlResponse, 'RESULT', 'ACSURL'),
                // 3DS認証処理に必要な項目です。
                'PaReq' => $this->gmoEpsilonRequestService->getXMLValue($xmlResponse, 'RESULT', 'PAREQ'),
                'TermUrl' => $this->app['url_generator']->generate('paylite_shopping_reception_3ds', array(), UrlGeneratorInterface::ABSOLUTE_URL),
                'MD' => $Order->getPreOrderId(),
            ));
        }

        if ($results === $this->const['receive_parameters']['result']['3ds2']) {
            // 3D2.0セキュア認証送信パラメータ1　加盟店様⇒カード会社
            return $this->app['view']->render('EccubePaymentLite3/Twig/shopping/transition_3ds2_screen.twig', array(
                // 3DS2.0処理時カード会社への接続用URLエンコードされています。
                'ACSUrl' => $this->gmoEpsilonRequestService->getXMLValue($xmlResponse, 'RESULT', 'TDS2_URL'),
                'PaReq' => $this->gmoEpsilonRequestService->getXMLValue($xmlResponse, 'RESULT', 'PAREQ'),
                'TermUrl' => $this->app['url_generator']->generate('paylite_shopping_reception_3ds2', array(), UrlGeneratorInterface::ABSOLUTE_URL),
                'MD' => $Order->getPreOrderId(),
            ));
        }

        return $this->compTokenProcess($Order, $response);
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

        // 注文完了画面に遷移
        return $this->app->redirect($this->app->url('shopping_complete'));
    }

    /**
     * トークン決済完了処理
     *
     * @param Order $Order
     * @param array $response
     * @return RedirectResponse
     */
    function compTokenProcess($Order, $response)
    {
        $cartService = $this->app['eccube.service.cart'];
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
                log_error('Credit card token complete errors ', array($e->getMessage()));
                $this->app['monolog.gmoepsilon']->error($e);
                $this->app->addError('front.shopping.system.error');
                return $this->app->redirect($this->app->url('shopping_error'));
            }

        }
        // カート削除
        $cartService->clear()->save();
        // 受注IDを完了画面に引き継ぐ
        $this->app['session']->set('eccube.front.shopping.order.id', $Order->getId());
        // 注文完了画面に遷移
        return $this->app->redirect($this->app->url('shopping_complete'));
    }

    /**
     * リクエストパラメータを設定
     *
     * @param Order $Order
     * @param PaymentExtension
     * @return array
     */
    function setTokenParameter($Order, $PaymentExtension, $token)
    {
        $objPlugin =& PluginUtil::getInstance($this->app);
        $Shipping = $Order->getShippings()[0];
        $Customer = $Order->getCustomer();
        $user_id = is_null($Customer) ? 'non_customer' : $Customer->getId();

        $itemInfo = $this->getItemInfo();
        $mission_code = $PaymentExtension->getMissionCode();
        if (is_null($mission_code)) {
            $mission_code = 1;
        } else {
            // 定期購入・非会員の場合、空文字に置き換え
            $user_id = $user_id == 'non_customer' ? '' : $user_id;
        }

        $pluginVersion = $this->pluginRepository->findOneBy(array('code' => 'EccubePaymentLite3'))->getVersion();

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
            'user_agent' => array_key_exists('HTTP_USER_AGENT', $_SERVER) ? $_SERVER['HTTP_USER_AGENT'] : null,
            'tds_check_code' => 1, // 3DSフラグ / NULL or 1 ：通常処理　（初回）
            'token' => $token,
            'keitai' => 0, // 3DS-keitai / 購入者の利用端末が携帯の場合必須 / NULL　or　0　：PC　or　1：携帯 / *3DS処理が携帯電話では利用不可のため通知が必要となります
            'security_check' => 1,

            // Start specific params of 3ds 2.0
            'tds_flag'=>'21', // 3DS2.0フラ グ
            'billAddrCity' => $Order->getPref()->getName(), // 請求先住所(都市)
            'billAddrCountry' => 392, // 請求先住所(国番号) =>  set default is Japan
            'billAddrLine1' => $Order->getAddr01(), // 請求先住所(区域部分_1行目)
            'billAddrLine2' => $Order->getAddr02(), // 請求先住所(区域部分_2行目)
            'billAddrLine3' => '', // 請求先住所(区域部分_3行目)
            'billAddrPostCode' => $Order->getZip01().$Order->getZip02(), // 請求先住所(郵便番号)
            'billAddrState' => $Order->getPref()->getId(), // 請求先住所 (州または都道府県番号)
            'shipAddrCity' => $Shipping->getPref()->getName(), // 送り先住所(都市)
            'shipAddrCountry' => 392, // 送り先住所(国番号) => set default is Japan
            'shipAddrLine1' => $Shipping->getAddr01(), // 送り先住所(区域部分_1行目)
            'shipAddrLine2' => $Shipping->getAddr02(), // 送り先住所(区域部分_2行目)
            'shipAddrLine3' => '', // 送り先住所(区域部分_3行目)
            'shipAddrPostCode' => $Shipping->getZip01().$Shipping->getZip02(), // 送り先住所(郵便番号)
            'shipAddrState' => $Shipping->getPref()->getId(), // 送り先住所 (州または都道府県番号)
            'threeDSReqAuthMethod' => '02', // ログイ ン認証方法
            'challengeInd' => '04', // チャレンジ要求
            // End specific params of 3ds 2.0
        );
        $this->app['monolog.gmoepsilon']->addInfo(' Sent Token arr3DS2Parameter = ' . print_r($arrResult, true));
        return $arrResult;
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
            // Create or update Epsilon member
            $this->createOrUpdateEpsilonMember($this->app['orm.em'], $this->app->user());
        }

        $OrderExtension = new OrderExtension();
        $OrderExtension->setId($Order->getId());
        $OrderExtension->setTransCode($response['trans_code']);
        $OrderExtension->setGmoEpsilonOrderNo($response['order_number']);

        if(isset($response['result'])){
            // Get payment status
            $PaymentStatus = $this->app['eccube.plugin.epsilon.repository.payment_status']->find(1);//仮売上
            // Set payment status
            $OrderExtension->setPaymentStatus($PaymentStatus);
        }

        $this->app['orm.em']->persist($OrderExtension);
    }

    /**
     * Create or update Epsilon Member
     * @param $em
     * @param $Customer
     * @return bool
     */
    function createOrUpdateEpsilonMember($em , $Customer){
        $requestGetUserInfoService = $this->app['eccube.plugin.epsilon.getinfo.services'];
        // Get user info from Epsilon
        $results = $requestGetUserInfoService->handle();
        if ($results['status'] === 'OK') {
            try {
                // Check exist Epsilon Member
                $EpsilonMember = $this->app['eccube.plugin.epsilon.repository.epsilon_member']->getEpsilonMemberByCustomerId($Customer->getId());
                if(is_null($EpsilonMember)){
                    $EpsilonMember = new EpsilonMember();
                }
                // Get card expire of customer from Epsilon
                $cardExpire = $this->app['eccube.plugin.epsilon.service.get_card_expire_date']->getCardExpire($results['cardExpire']);
                $EpsilonMember->setGmoEpsilonCreditCardExpirationDate($cardExpire);
                $EpsilonMember->setCardChangeRequestMailSendDate(null);
                $EpsilonMember->setCustomer($Customer);
                $em->persist($EpsilonMember);

            } catch (\Exception $e) {
                log_error('Create or update Epsilon Member errors ', array($e->getMessage()));
                $this->app['monolog.gmoepsilon']->error($e);
                return false;
            }
        }
    }

    /**
     * チェックするレスポンスパラメータのキーを取得
     *
     * @return array
     */
    function getCheckParameter()
    {
        return array('trans_code', 'user_id', 'result', 'order_number');
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
        // 共通のリクエストパラメータを取得
        $arrParameter = parent::setParameter($Order, $PaymentExtension);
        $Shipping = $Order->getShippings()[0];
        // Start specific params of 3ds 2.0
        $arr3DS2Parameter = array(
            'tds_flag'=>'21', // 3DS2.0フラ グ
            'billAddrCity' => $Order->getPref()->getName(), // 請求先住所(都市)
            'billAddrCountry' => 392, // 請求先住所(国番号) =>  set default is Japan
            'billAddrLine1' => $Order->getAddr01(), // 請求先住所(区域部分_1行目)
            'billAddrLine2' => $Order->getAddr02(), // 請求先住所(区域部分_2行目)
            'billAddrLine3' => '', // 請求先住所(区域部分_3行目)
            'billAddrPostCode' => $Order->getZip01().$Order->getZip02(), // 請求先住所(郵便番号)
            'billAddrState' => $Order->getPref()->getId(), // 請求先住所 (州または都道府県番号)
            'shipAddrCity' => $Shipping->getPref()->getName(), // 送り先住所(都市)
            'shipAddrCountry' => 392, // 送り先住所(国番号) => set default is Japan
            'shipAddrLine1' => $Shipping->getAddr01(), // 送り先住所(区域部分_1行目)
            'shipAddrLine2' => $Shipping->getAddr02(), // 送り先住所(区域部分_2行目)
            'shipAddrLine3' => '', // 送り先住所(区域部分_3行目)
            'shipAddrPostCode' => $Shipping->getZip01().$Shipping->getZip02(), // 送り先住所(郵便番号)
            'shipAddrState' => $Shipping->getPref()->getId(), // 送り先住所 (州または都道府県番号)
            'threeDSReqAuthMethod' => '02', // ログイ ン認証方法
            'challengeInd' => '04', // チャレンジ要求
        );
        // End sample specific params of 3ds 2.0
        $arrParameter = array_merge($arrParameter, $arr3DS2Parameter);

        $this->app['monolog.gmoepsilon']->addInfo(' Sent Link arr3DS2Parameter = ' . print_r($arrParameter, true));

        return $arrParameter;
    }

}
