<?php

namespace Plugin\EccubePaymentLite3\Controller;

use Eccube\Controller\AbstractController;
use Eccube\Entity\MailHistory;
use Eccube\Entity\Order;
use Eccube\Service\OrderHelper;
use Eccube\Service\Payment\PaymentMethodInterface;
use Exception;
use Plugin\EccubePaymentLite3\Entity\EpsilonMember;
use Plugin\EccubePaymentLite3\Entity\Extension\OrderExtension;
use Plugin\EccubePaymentLite3\Util\PluginUtil;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class Reception3DSAuthenticationController extends AbstractController
{
    private $app;

    private $const;

    /**
     * 3Dセキュア認証受信パラメータ1　カード会社⇒加盟店様
     * @param \Eccube\Application $app
     * @param Request $request
     * @return RedirectResponse
     */
    public function index(\Eccube\Application $app, Request $request)
    {
        $this->app = $app;
        $this->const = $app['config']['EccubePaymentLite3']['const'];

        $md = '';
        $paRes = '';
        if ($request->get('MD')) {
            $md = $request->get('MD');
        }
        if ($request->get('PaRes')) {
            $paRes = $request->get('PaRes');
        }

        $preOrderId = $md;
        $Order = $this->getPurchasePendingOrder($preOrderId);
        if (!$Order) {
            log_info('[注文処理] 決済処理中の受注が存在しません.', array($preOrderId));

            return $this->app->redirect($this->app->url('shopping_error'));
        }

        $objPlugin =& PluginUtil::getInstance($this->app);
        $parameters = array(
            'contract_code' => $objPlugin->getSubData('contract_code'),
            'order_number' => $Order->getId(),
            'tds_check_code' => 2, // 2：3DS結果確認処理（2回目）
            'tds_pares' => $paRes, // カード会社からの戻り値「PaRes」を設定してください。
        );

        // 3Dセキュア認証送信パラメータ2　加盟店様⇒イプシロン
        $xmlResponse = $this->app['eccube.plugin.epsilon.request.services']->sendData(
            $this->app['eccube.plugin.epsilon.services']->getUrl('direct_card_payment'),
            $parameters
        );

        $message = $this->app['eccube.plugin.epsilon.request.services']->getXMLValue($xmlResponse, 'RESULT', 'ERR_DETAIL');
        $errCode = $this->app['eccube.plugin.epsilon.request.services']->getXMLValue($xmlResponse, 'RESULT', 'ERR_CODE');
        $result = (int) $this->app['eccube.plugin.epsilon.request.services']->getXMLValue($xmlResponse, 'RESULT', 'RESULT');

        if (!empty($errCode)) {
        $this->app['monolog.gmoepsilon']->addInfo('ERR_CODE = '.$errCode);
        $this->app['monolog.gmoepsilon']->addInfo('ERR_DETAIL = '.$message);
            return $this->app->redirect($this->app->url('shopping_error'));
        }

        if ($result === $this->const['receive_parameters']['result']['ok']) {
            $response = array(
                'trans_code' => $this->app['eccube.plugin.epsilon.request.services']->getXMLValue($xmlResponse, 'RESULT', 'TRANS_CODE'),
                'order_number' => $Order->getId()
            );
            return $this->compTokenProcess($Order, $response);
        }
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
     * 決済処理中の受注を取得する.
     *
     * @param null|string $preOrderId
     *
     * @return null|Order
     */
    public function getPurchasePendingOrder($preOrderId = null)
    {
        if (null === $preOrderId) {
            return null;
        }
        $OrderStatus = $this->app['eccube.repository.order_status']->find($this->app['config']['order_pending']);
        return $this->app['eccube.repository.order']->findOneBy(array(
            'pre_order_id' => $preOrderId,
            'OrderStatus' => $OrderStatus,
        ));
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
}
