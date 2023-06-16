<?php

namespace Plugin\EccubePaymentLite3\Form\Extension\Admin;

use Eccube\Entity\Shipping;
use Plugin\EccubePaymentLite3\Entity\Extension\ShippingExtension;
use Silex\Application;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints as Assert;

class TrackingNumberTypeExtension extends AbstractTypeExtension
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
        $config = $this->app['config'];
        $app = $this->app;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($config, $app) {
            /** @var Shipping $Shipping */
            $Shipping = $event->getData();
            /** @var Form $form */
            $form = $event->getForm();
            $trackingNumber = '';

            if ($Shipping && !is_null($Shipping->getId())) {
                /** @var ShippingExtension $ShippingExtension */
                $ShippingExtension = $app['eccube.plugin.epsilon.repository.shipping_extension']->find($Shipping->getId());
                $trackingNumber = $ShippingExtension ? $ShippingExtension->getTrackingNumber() : '';
            }

            $form->add('tracking_number', 'text', array(
                'label' => 'お問い合わせ番号',
                'required' => false,
                'mapped' => false,
                'constraints' => array(
                    new Assert\Length(array(
                        'max' => $config['stext_len'],
                    ))
                ),
                'data' => $trackingNumber,
            ));
        });
    }

    /**
     * Get Extended Type
     *
     * @return string
     */
    public function getExtendedType()
    {
        return 'shipping';
    }
}
