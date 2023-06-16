<?php

namespace Plugin\EccubePaymentLite3\Service\Action;

use Eccube\Application;
use Eccube\Entity\Order;
use Plugin\EccubePaymentLite3\Entity\Extension\OrderExtension;

class UpdateGmoEpsilonOrder
{
    /**
     * @var Application
     */
    private $app;

    /**
     * constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @param Order $Order
     * @param string $transCode
     * @param string $gmoEpsilonOrderNo
     */
    public function updateAfterMakingPayment($Order, $transCode, $gmoEpsilonOrderNo)
    {
        // 受注ステータスを新規受付へ変更
        $OrderStatus = $this->app['eccube.repository.order_status']->find($this->app['config']['order_new']);
        $Order
            ->setOrderStatus($OrderStatus)
            ->setPaymentDate(new \DateTime());

        $this->app['orm.em']->persist($Order);

        /** @var OrderExtension $OrderExtension */
        $OrderExtension = $this->app['eccube.plugin.epsilon.repository.order_extension']->find($Order->getId());
        if (is_null($OrderExtension)) {
            $OrderExtension = new OrderExtension();
            $OrderExtension->setId($Order->getId());
        }
        $OrderExtension
            ->setTransCode($transCode)
            ->setGmoEpsilonOrderNo($gmoEpsilonOrderNo);

        $this->app['orm.em']->persist($OrderExtension);

        // 会員の場合、購入回数、購入金額などを更新
        $Customer = $Order->getCustomer();
        if ($Customer) {
            // 会員の場合、購入回数、購入金額などを更新
            $this->app['eccube.repository.customer']->updateBuyData($this->app, $Customer, $Order->getOrderStatus()->getId());

            $this->app['orm.em']->persist($Customer);
        }

        $this->app['orm.em']->flush();
    }
}
