<?php

namespace Plugin\EccubePaymentLite3\Form\Extension\Admin;

use Eccube\Entity\Delivery;
use Plugin\EccubePaymentLite3\Entity\Extension\DeliveryExtension;
use Silex\Application;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class DeliveryCompanyTypeExtension extends AbstractTypeExtension
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
        /** @var Delivery $Delivery */
        $Delivery = $builder->getForm()->getData();
        $deliveryId = $Delivery->getId();
        $DeliveryCompany = null;

        /** @var DeliveryExtension $DeliveryExtension */
        $DeliveryExtension = $deliveryId ? $this->app['eccube.plugin.epsilon.repository.delivery_extension']->find($deliveryId) : null;
        if ($DeliveryExtension) {
            $DeliveryCompany = $DeliveryExtension->getDeliveryCompany();
        }

        $builder->add('DeliveryCompany', 'entity', array(
            'class' => 'Plugin\EccubePaymentLite3\Entity\Master\DeliveryCompany',
            'label' => '配送会社',
            'property' => 'name',
            'required' => true,
            'mapped' => false,
            'multiple' => false,
            'expanded' => true,
            'data' => $DeliveryCompany,
            'constraints' => array(
                new Assert\NotBlank(),
            ),
        ));
    }

    /**
     * Get Extended Type
     *
     * @return string
     */
    public function getExtendedType()
    {
        return 'delivery';
    }
}
