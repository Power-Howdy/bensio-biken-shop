<?php

namespace Plugin\EccubePaymentLite3\Form\Extension\Admin;

use Silex\Application;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ProductTypeExtension extends AbstractTypeExtension
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
        $builder
            ->add('free_description_quantity', 'textarea', array(
                'label' => '分量に関するフリー記述',
                'mapped' => false,
                'required' => false,
            ))
            ->add('free_description_selling_price', 'textarea', array(
                'label' => '販売価格に関するフリー記述',
                'mapped' => false,
                'required' => false,
            ))
            ->add('free_description_payment_delivery', 'textarea', array(
                'label' => 'お支払い・引き渡しに関するフリー記述',
                'mapped' => false,
                'required' => false,
            ));

        $app = $this->app;
        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) use ($app) {
            $Product = $event->getData();
            $form = $event->getForm();
            if (is_object($Product)) {
                $ProductExtension = $app['eccube.plugin.epsilon.repository.product_extension']->findOneBy(array('product_id' => $Product->getId()));
                if ($ProductExtension) {
                    // 分量に関するフリー記述
                    $form->get('free_description_quantity')->setData($ProductExtension->getFreeDescriptionQuantity());
                    // 販売価格に関するフリー記述
                    $form->get('free_description_selling_price')->setData($ProductExtension->getFreeDescriptionSellingPrice());
                    // お支払い・引き渡しに関するフリー記述
                    $form->get('free_description_payment_delivery')->setData($ProductExtension->getFreeDescriptionPaymentDelivery());
                } else {
                    // 分量に関するフリー記述
                    $form->get('free_description_quantity')->setData("");
                    // 販売価格に関するフリー記述
                    $form->get('free_description_selling_price')->setData("");
                    // お支払い・引き渡しに関するフリー記述
                    $form->get('free_description_payment_delivery')->setData("");
                }
            }
        });
    }

    /**
     * Get Extended Type
     *
     * @return string
     */
    public function getExtendedType()
    {
        return 'admin_product';
    }
}
