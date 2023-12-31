<?php

namespace Plugin\EccubePaymentLite3\Form\Type\Admin;

use Doctrine\ORM\EntityRepository;
use Eccube\Application;
use Eccube\Common\Constant;
use Eccube\Entity\Shipping;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;

class RegularShippingType extends AbstractType
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $app = $this->app;
        $config = $app['config'];
        $BaseInfo = $app['eccube.repository.base_info']->get();

        $builder
            ->add('name', 'name', array(
                'required' => true,
                'options' => array(
                    'attr' => array(
                        'maxlength' => $config['stext_len'],
                    ),
                    'constraints' => array(
                        new Assert\NotBlank(),
                        new Assert\Length(array('max' => $config['stext_len'])),
                    ),
                ),
            ))
            ->add('kana', 'name', array(
                'options' => array(
                    'attr' => array(
                        'maxlength' => $config['stext_len'],
                    ),
                    'constraints' => array(
                        new Assert\NotBlank(),
                        new Assert\Length(array('max' => $config['stext_len'])),
                        new Assert\Regex(array(
                            'pattern' => "/^[ァ-ヶｦ-ﾟー]+$/u",
                        )),
                    ),
                ),
            ))
            ->add('company_name', 'text', array(
                'label' => '会社名',
                'required' => false,
                'constraints' => array(
                    new Assert\Length(array(
                        'max' => $config['stext_len'],
                    ))
                ),
            ))
            ->add('zip', 'zip', array())
            ->add('address', 'address', array(
                'addr01_options' => array(
                    'constraints' => array(
                        new Assert\NotBlank(),
                        new Assert\Length(array(
                            'max' => $config['mtext_len'],
                        )),
                    ),
                ),
                'addr02_options' => array(
                    'constraints' => array(
                        new Assert\Length(array(
                            'max' => $config['mtext_len'],
                        )),
                    ),
                ),
            ))
            ->add('tel', 'tel', array(
                'required' => true,
            ))
            ->add('fax', 'tel', array(
                'label' => 'FAX番号',
                'required' => false,
            ))
            ->add('Delivery', 'entity', array(
                'label' => '配送業者',
                'class' => 'Eccube\Entity\Delivery',
                'property' => 'name',
                'empty_value' => '選択してください',
                'empty_data' => null,
                'constraints' => array(
                    new Assert\NotBlank(),
                ),
            ))
            ->add('shipping_delivery_date', 'date', array(
                'label' => 'お届け日',
                'placeholder' => '',
                'format' => 'yyyy-MM-dd',
                'required' => false,
            ))
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($BaseInfo) {
                if ($BaseInfo->getOptionMultipleShipping() == Constant::ENABLED) {
                    $form = $event->getForm();
                    $form->add('RegularShipmentItems', 'collection', array(
                        'type' => 'epsilon_regular_shipment_item',
                        'allow_add' => true,
                        'allow_delete' => true,
                        'prototype' => true,
                    ));
                }
            })
            ->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
                /** @var Shipping $data */
                $data = $event->getData();
                /** @var Form $form */
                $form = $event->getForm();

                if (is_null($data)) {
                    return;
                }

                $Delivery = $data->getDelivery();

                // お届け時間を配送業者で絞り込み
                $form->add('DeliveryTime', 'entity', array(
                'label' => 'お届け時間',
                'class' => 'Eccube\Entity\DeliveryTime',
                'property' => 'delivery_time',
                'empty_value' => '指定なし',
                'empty_data' => null,
                'required' => false,
                    'query_builder' => function (EntityRepository $er) use($Delivery) {
                        return $er->createQueryBuilder('dt')
                            ->where('dt.Delivery = :Delivery')
                            ->setParameter('Delivery', $Delivery);
                    },
                ));

            })
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) use ($app) {
                $data = $event->getData();
                $form = $event->getForm();
                if (!$data) {
                    return;
                }

                $value = $data['Delivery'];
                if (empty($value)) {
                    $value = 0;
                }
                $Delivery = $app['eccube.repository.delivery']->find($value);

                // お届け時間を配送業者で絞り込み
                $form->add('DeliveryTime', 'entity', array(
                    'label' => 'お届け時間',
                    'class' => 'Eccube\Entity\DeliveryTime',
                    'property' => 'delivery_time',
                    'empty_value' => '指定なし',
                    'empty_data' => null,
                    'required' => false,
                    'query_builder' => function (EntityRepository $er) use($Delivery) {
                        return $er->createQueryBuilder('dt')
                            ->where('dt.Delivery = :Delivery')
                            ->setParameter('Delivery', $Delivery);
                    },
                ));
            })
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($BaseInfo) {
                if ($BaseInfo->getOptionMultipleShipping() == Constant::ENABLED) {
                    $form = $event->getForm();
                    $regularShipmentItems = $form['RegularShipmentItems']->getData();

                    if (empty($regularShipmentItems) || count($regularShipmentItems) < 1) {
                        // 画面下部にエラーメッセージを表示させる
                        $form['shipping_delivery_date']->addError(new FormError('商品が追加されていません。'));
                    }
                }
            })
            ->addEventSubscriber(new \Eccube\Event\FormEventSubscriber());
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'Plugin\EccubePaymentLite3\Entity\RegularShipping',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'epsilon_regular_shipping';
    }
}
