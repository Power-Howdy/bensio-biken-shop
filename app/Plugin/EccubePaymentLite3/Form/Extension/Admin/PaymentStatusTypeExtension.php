<?php

namespace Plugin\EccubePaymentLite3\Form\Extension\Admin;

use Eccube\Entity\Order;
use Plugin\EccubePaymentLite3\Entity\Extension\OrderExtension;
use Plugin\EccubePaymentLite3\Entity\Master\PaymentStatus;
use Silex\Application;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

class PaymentStatusTypeExtension extends AbstractTypeExtension
{
    /**
     * @var Application
     */
    public $app;

    /**
     * constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Build Form
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Order $Order */
        $Order = $builder->getForm()->getData();
        if (is_null($Order) || !$Order->getId()) {
            return;
        }

        $statuses = array(
            PaymentStatus::UNPAID,
            PaymentStatus::CHARGED,
            PaymentStatus::TEMPORARY_SALES,
            PaymentStatus::CANCEL
        );

        // Check GMO後払い
        if ($Order->getPaymentMethod() === $this->app['config']['EccubePaymentLite3']['const']['PAY_NAME_DEFERRED']) {
            $statuses = array_merge($statuses, array(
                PaymentStatus::UNDER_REVIEW,
                PaymentStatus::SHIPPING_REGISTRATION,
                PaymentStatus::EXAMINATION_NG,
            ));
        }

        $PaymentStatuses = $this->app['eccube.plugin.epsilon.repository.payment_status']->findBy(array('id' => $statuses), array('rank' => 'ASC'));
        $PaymentStatus = null;

        /** @var OrderExtension $OrderExtension */
        $OrderExtension = $this->app['eccube.plugin.epsilon.repository.order_extension']->find($Order->getId());
        if ($OrderExtension) {
            $PaymentStatus = $OrderExtension->getPaymentStatus();
        }

        $builder->add('PaymentStatus', 'entity', array(
            'class' => 'Plugin\EccubePaymentLite3\Entity\Master\PaymentStatus',
            'property' => 'name',
            'required' => false,
            'mapped' => false,
            'placeholder' => '-',
            'choices' => $PaymentStatuses,
            'data' => $PaymentStatus
        ));
    }

    /**
     * Get Extended Type
     *
     * @return string
     */
    public function getExtendedType()
    {
        return 'order';
    }
}
