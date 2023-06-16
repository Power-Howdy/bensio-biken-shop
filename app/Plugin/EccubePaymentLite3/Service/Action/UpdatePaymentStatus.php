<?php

namespace Plugin\EccubePaymentLite3\Service\Action;

use Eccube\Application;
use Eccube\Entity\Order;
use Plugin\EccubePaymentLite3\Entity\Extension\OrderExtension;
use Plugin\EccubePaymentLite3\Entity\Master\PaymentStatus;

class UpdatePaymentStatus
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
     * Handle
     *
     * @param Order $Order
     * @param PaymentStatus $PaymentStatus
     */
    public function handle($Order, $PaymentStatus)
    {
        /** @var OrderExtension $OrderExtension */
        $OrderExtension = $this->app['eccube.plugin.epsilon.repository.order_extension']->find($Order->getId());
        if ($OrderExtension instanceof OrderExtension) {
            $OrderExtension->setPaymentStatus($PaymentStatus);

            $this->app['orm.em']->persist($OrderExtension);
            $this->app['orm.em']->flush($OrderExtension);
        }
    }
}
