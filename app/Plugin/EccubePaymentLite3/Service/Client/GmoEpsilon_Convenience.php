<?php

namespace Plugin\EccubePaymentLite3\Service\Client;

use Eccube\Application;
use Eccube\Entity\Order;
use Plugin\EccubePaymentLite3\Entity\Extension\OrderExtension;
use Plugin\EccubePaymentLite3\Entity\Extension\PaymentExtension;
use Plugin\EccubePaymentLite3\Util\PaymentUtil;
use Plugin\EccubePaymentLite3\Util\PluginUtil;
use Eccube\Entity\MailHistory;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * 決済モジュール 決済処理: コンビニ決済
 */
class GmoEpsilon_Convenience extends GmoEpsilon_Base
{

    private $data;

    /**
     * コンストラクタ
     *
     * @return void
     */
    function __construct(Application $app)
    {
        parent::__construct($app);
        $this->app = $app;
        $this->const = $app['config']['EccubePaymentLite3']['const'];
    }

    function getCheckParameter()
    {
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

        // カート削除
        $cartService->clear()->save();

        // 受注IDを完了画面に引き継ぐ
        $this->app['session']->set('eccube.front.shopping.order.id', $Order->getId());

        // メール送信
        $this->sendOrderMail($Order);

        return $this->app->redirect($this->app->url('shopping_complete'));
    }

    /**
     * 受注情報を更新
     *
     * @param Order $Order
     * @param array $arrXML
     */
    function updateOrder($Order, $arrXML)
    {
        // リクエスト結果を取得
        $conveni_code = $this->getXMLValue($arrXML, 'RESULT', 'CONVENI_CODE');
        $receipt_no = $this->getXMLValue($arrXML,'RESULT','RECEIPT_NO');
        $payment_url = $this->getXMLValue($arrXML,'RESULT','HARAIKOMI_URL');
        $company_code = $this->getXMLValue($arrXML,'RESULT','KIGYOU_CODE');
        $order_no = $this->getXMLValue($arrXML,'RESULT','ORDER_NUMBER');
        $tel = $this->data["tel01"]."-".$this->data["tel02"]."-".$this->data["tel03"];
        $payment_limit = $this->getXMLValue($arrXML,'RESULT','CONVENI_LIMIT');
        $trans_code = $this->getXMLValue($arrXML,'RESULT','TRANS_CODE');
        $state = $this->getXMLValue($arrXML,'RESULT','STATE');

        // コンビニ別に決済情報を設定
        $arrPayInfo = array();
        $this->setPayInfo($arrPayInfo, 'title', '', 'コンビニ決済');
        switch ($conveni_code) {
            case $this->const['CONVENI_ID_SEVENELEVEN']:
                $this->setPayInfo($arrPayInfo, 'message_pre', '', $this->const['SEVENELEVEN_PRE_MESSAGE']);
                $this->setPayInfo($arrPayInfo, 'payment_url', '払込票URL', $payment_url);         // 払込票URL(PC)
                $this->setPayInfo($arrPayInfo, 'receipt_no', '払込票番号（13桁）', $receipt_no);   // 払込票番号
                $this->setPayInfo($arrPayInfo, 'payment_limit', 'お支払期限', $payment_limit);     // 支払期限
                $this->setPayInfo($arrPayInfo, 'message', '', $this->const['SEVENELEVEN_MESSAGE']);
                break;
            case $this->const['CONVENI_ID_FAMILYMART']:
                $this->setPayInfo($arrPayInfo, 'message_pre', '', $this->const['FAMIRYMART_PRE_MESSAGE']);
                $this->setPayInfo($arrPayInfo, 'company_code', '企業コード（5桁）', $company_code); // 企業コード
                $this->setPayInfo($arrPayInfo, 'receipt_no', '注文番号（12桁）', $receipt_no);     // 注文番号
                $this->setPayInfo($arrPayInfo, 'payment_limit', 'お支払期限', $payment_limit);     // 支払期限
                $this->setPayInfo($arrPayInfo, 'message', '', $this->const['FAMIRYMART_MESSAGE']);
                break;
            case $this->const['CONVENI_ID_LAWSON']:
                $this->setPayInfo($arrPayInfo, 'message_pre', '', $this->const['LAWSON_PRE_MESSAGE']);
                $this->setPayInfo($arrPayInfo, 'receipt_no', '受付番号（6桁）', $receipt_no);     // 払込票番号
                $this->setPayInfo($arrPayInfo, 'tel', '電話番号', $tel);                         // 電話番号
                $this->setPayInfo($arrPayInfo, 'payment_limit', 'お支払期限', $payment_limit);   // 支払期限
                $this->setPayInfo($arrPayInfo, 'message', '', $this->const['LAWSON_MESSAGE']);
                break;
            case $this->const['CONVENI_ID_SEICOMART']:
                $this->setPayInfo($arrPayInfo, 'message_pre', '', $this->const['SEICOMART_PRE_MESSAGE']);
                $this->setPayInfo($arrPayInfo, 'receipt_no', '受付番号（6桁）', $receipt_no);     // 払込票番号
                $this->setPayInfo($arrPayInfo, 'tel', '電話番号', $tel);                         // 電話番号
                $this->setPayInfo($arrPayInfo, 'payment_limit', 'お支払期限', $payment_limit);   // 支払期限
                $this->setPayInfo($arrPayInfo, 'message', '', $this->const['SEICOMART_MESSAGE']);
                break;
            case $this->const['CONVENI_ID_MINISTOP']:
                $this->setPayInfo($arrPayInfo, 'message_pre', '', $this->const['MINISTOP_PRE_MESSAGE']);
                $this->setPayInfo($arrPayInfo, '', '払込票番号', $receipt_no);                   // 払込票番号
                $this->setPayInfo($arrPayInfo, 'tel', '電話番号', $tel);                         // 電話番号
                $this->setPayInfo($arrPayInfo, 'payment_limit', 'お支払期限', $payment_limit);   // 支払期限
                $this->setPayInfo($arrPayInfo, 'message', '', $this->const['MINISTOP_MESSAGE']);
                break;
        }

        // ステータス変更
        $OrderStatus = $this->app['eccube.repository.order_status']->find($this->app['config']['order_pay_wait']);
        $this->app['eccube.repository.order']->changeStatus($Order->getId(), $OrderStatus);

        // 在庫情報更新
        $this->app['eccube.service.order']->setStockUpdate($this->app['orm.em'], $Order);

        if ($this->app->isGranted('ROLE_USER')) {
            // 会員の場合、購入金額を更新
            $this->app['eccube.service.order']->setCustomerUpdate($this->app['orm.em'], $Order, $this->app->user());
        }

        // Epsilon決済情報を拡張テーブルに登録
        $OrderExtension = new OrderExtension();
        $OrderExtension->setId($Order->getId());
        $OrderExtension->setPaymentInfo(serialize($arrPayInfo));
        $OrderExtension->setTransCode($trans_code);
        $OrderExtension->setGmoEpsilonOrderNo($order_no);
        $PaymentStatus = $this->app['eccube.plugin.epsilon.repository.payment_status']->find($state);
        $OrderExtension->setPaymentStatus($PaymentStatus);
        $Order->setPaymentDate(new \DateTime());
        $this->app['orm.em']->persist($Order);
        $this->app['orm.em']->persist($OrderExtension);

        // セッションにorder_idを保持
        $this->app['session']->set('eccube.plugin.epsilon.orderId', $Order->getId());
    }

    /**
     * 受注メールを送信
     * (Epsilon決済情報を追加したテンプレートを使用)
     *
     * @param Order $Order
     */
    function sendOrderMail($Order)
    {
        // Epsilon決済情報を取得
        $orderEpsilonInfo = $this->app['eccube.plugin.epsilon.repository.order_extension']->find($Order->getId());
        $arrOther = unserialize($orderEpsilonInfo->getPaymentInfo());

        // 受注メール送信
        $message = $this->app['eccube.plugin.epsilon.service.mail']->sendOrderMail($Order, $arrOther);

        // 送信履歴を保存.
        $MailTemplate = $this->app['eccube.repository.mail_template']->find(1);

        $MailHistory = new MailHistory();
        $MailHistory
            ->setSubject($message->getSubject())
            ->setMailBody($message->getBody())
            ->setMailTemplate($MailTemplate)
            ->setSendDate(new \DateTime())
            ->setOrder($Order);

        $this->app['orm.em']->persist($MailHistory);
        $this->app['orm.em']->flush($MailHistory);
    }

    /**
     * 決済処理
     *
     * @param Order $Order
     * @param PaymentExtension
     * @return RedirectResponse
     */
    function payProcess($Order, $PaymentExtension)
    {
        $render_flg = true;
        $form = $this->app['form.factory']
            ->createBuilder('convenience')
            ->getForm();

        // リクエストパラメータをセット
        if ('POST' === $this->app['request']->getMethod()) {
            $form->handleRequest($this->app['request']);
            if ($form->isValid()) {
                $this->data = $form->getData();
                // リクエストパラメータをセット
                $arrParameter = $this->setParameter($Order, $PaymentExtension);
                $render_flg = false;
            }
        }

        // コンビニ決済画面表示
        if ($render_flg) {
            return $this->app['view']->render('EccubePaymentLite3/Twig/shopping/convenience.twig', array(
                'form' => $form->createView(),
                'title' => 'コンビニ決済',
                'order_number' => $Order->getId(),
            ));
        }

        // データ送信(POST)
        $objPlugin =& PluginUtil::getInstance($this->app);
        $destination_url = $objPlugin->getSubData('destination_url');
        $arrXML = $this->sendData($destination_url, $arrParameter);
        $err_code = $this->getXMLValue($arrXML, 'RESULT', 'ERR_CODE');
        // Error checking
        if (!empty($err_code)) {
            $this->app['monolog.gmoepsilon']->addInfo('request error. error_code = ' . $err_code);
            $error_title = 'システムエラーが発生しました。';
            $error_message = $this->getXMLValue($arrXML, 'RESULT', 'ERR_DETAIL');
            return $this->app['view']->render('error.twig', compact('error_title', 'error_message'));
        }

        // トランザクション制御
        $em = $this->app['orm.em'];
        $em->getConnection()->beginTransaction();
        try {
            // 受注情報更新
            $this->updateOrder($Order, $arrXML);
            $em->getConnection()->commit();
            $em->flush();
        } catch (\Exception $e) {
            $em->getConnection()->rollback();
            $em->close();

            $this->app->log($e);

            $this->app->addError('front.shopping.system.error');
            return $this->app->redirect($this->app->url('shopping_error'));
        }

        // 受注番号をセット
        $this->app['session']->set('eccube.plugin.epsilon.orderId', $Order->getId());

        // 注文完了処理
        return $this->app->redirect($this->app->url('paylite_shopping_payment_complete'));

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

        // コンビニ決済のリクエストパラメータを取得
        $arrConveniParameter = array(
                    'conveni_code' => $this->data['convenience'],
                    'user_tel' => $this->data['tel01'].$this->data['tel02'].$this->data['tel03'],
                    'user_name_kana' => $this->data['kana01'].$this->data['kana02'],
                    'haraikomi_mail' => 0,
        );
        $arrParameter = array_merge($arrParameter, $arrConveniParameter);

        return $arrParameter;
    }

}
