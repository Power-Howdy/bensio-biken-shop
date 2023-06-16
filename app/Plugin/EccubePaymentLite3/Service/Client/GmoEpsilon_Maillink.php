<?php

namespace Plugin\EccubePaymentLite3\Service\Client;

use Eccube\Application;
use Eccube\Entity\Order;
use Plugin\EccubePaymentLite3\Entity\Extension\OrderExtension;
use Plugin\EccubePaymentLite3\Entity\Extension\PaymentExtension;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * 決済モジュール 決済処理：メールリンク決済
 */
class GmoEpsilon_Maillink extends GmoEpsilon_Base
{

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

    /**
     * 決済処理
     *
     * @param Order $Order
     * @param PaymentExtension $PaymentExtension
     * @return RedirectResponse
     */
    function payProcess($Order, $PaymentExtension)
    {
        // トランザクション制御
        $em = $this->app['orm.em'];
        $em->getConnection()->beginTransaction();
        try {
            // 受注情報を更新
            $this->updateOrder($Order, array());

            $em->getConnection()->commit();
            $em->flush();
        } catch (\Exception $e) {
            $em->getConnection()->rollback();
            $em->close();

            $this->app->log($e);

            $this->app->addError('front.shopping.system.error');
            return $this->app->redirect($this->app->url('shopping_error'));
        }

        // カート削除
        $this->app['eccube.service.cart']->clear()->save();

        // 受注IDを完了画面に引き継ぐ
        $this->app['session']->set('eccube.front.shopping.order.id', $Order->getId());

        // メール送信
        $this->sendOrderMail($Order);

        // 受注番号をセット
        $this->app['session']->set('eccube.plugin.epsilon.orderId', $Order->getId());

        // 注文完了画面に遷移
        return $this->app->redirect($this->app->url('shopping_complete'));
    }

    /**
     * 決済完了処理
     *
     * @param Order $Order
     * @param array $data
     * @return RedirectResponse
     */
    function compProcess($Order, $data)
    {
        // 受注情報を更新
        switch ($data['payment_type_id']) {
    		case $this->app['config']['EccubePaymentLite3']['const']['PAY_ID_CONVENI']:
    		case $this->app['config']['EccubePaymentLite3']['const']['PAY_ID_PAYEASY']:
    			// コンビニ・ペイジー
                $OrderStatus = $this->app['eccube.repository.order_status']->find($this->app['config']['order_pay_wait']);
    			break;
            case $this->app['config']['EccubePaymentLite3']['const']['PAY_ID_DEFERRED']:
                // 後払い
                $OrderStatus = $this->app['eccube.repository.order_status']->find($this->app['config']['order_new']);
                break;
            default:
    			// その他クレジットなど
                $OrderStatus = $this->app['eccube.repository.order_status']->find($this->app['config']['order_pre_end']);
    			break;
    	}

        $this->app['eccube.repository.order']->changeStatus($Order->getId(), $OrderStatus);

        $OrderExtension = new OrderExtension();
        $OrderExtension->setId($Order->getId());
        $OrderExtension->setTransCode($data['trans_code']);
        $OrderExtension->setGmoEpsilonOrderNo($data['order_number']);
        $this->app['orm.em']->persist($OrderExtension);

        // 受注IDを完了画面に引き継ぐ
        $this->app['session']->set('eccube.front.shopping.order.id', $Order->getId());

        // メール送信
        $this->sendOrderMail($Order);

        // 注文完了画面に遷移
        return $this->app->redirect($this->app->url('shopping_complete'));
    }

    /**
     * 受注情報を更新
     *
     * @param Order $Order
     * @param array $data
     */
    function updateOrder($Order, $data)
    {
        $OrderStatus = $this->app['eccube.repository.order_status']->find($this->app['config']['order_new']);
        $this->app['eccube.repository.order']->changeStatus($Order->getId(), $OrderStatus);

        // 在庫情報更新
        $this->app['eccube.service.order']->setStockUpdate($this->app['orm.em'], $Order);

        if ($this->app->isGranted('ROLE_USER')) {
            // 会員の場合、購入金額を更新
            $this->app['eccube.service.order']->setCustomerUpdate($this->app['orm.em'], $Order, $this->app->user());
        }
    }

}
