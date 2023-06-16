<?php

namespace Plugin\EccubePaymentLite3\Form\Type\Admin;

use Eccube\Form\DataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;

class RegularOrderType extends AbstractType
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $config = $this->app['config'];

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
                        new Assert\NotBlank(),
                        new Assert\Length(array(
                            'max' => $config['mtext_len'],
                        )),
                    ),
                ),
            ))
            ->add('email', 'email', array(
                'label' => 'メールアドレス',
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Email(),
                ),
            ))
            ->add('tel', 'tel', array())
            ->add('fax', 'tel', array(
                'label' => 'FAX番号',
                'required' => false,
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
            ->add('message', 'textarea', array(
                'label' => '備考',
                'required' => false,
                'constraints' => array(
                    new Assert\Length(array(
                        'max' => $config['ltext_len'],
                    )),
                ),
            ))
            ->add('discount', 'money', array(
                'label' => '値引き',
                'currency' => 'JPY',
                'precision' => 0,
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Length(array(
                        'max' => $config['int_len'],
                    )),
                ),
            ))
            ->add('delivery_fee_total', 'money', array(
                'label' => '送料',
                'currency' => 'JPY',
                'precision' => 0,
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Length(array(
                        'max' => $config['int_len'],
                    )),
                ),
            ))
            ->add('charge', 'money', array(
                'label' => '手数料',
                'currency' => 'JPY',
                'precision' => 0,
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Length(array(
                        'max' => $config['int_len'],
                    )),
                ),
            ))
            ->add('note', 'textarea', array(
                'label' => 'SHOP用メモ欄',
                'required' => false,
                'constraints' => array(
                    new Assert\Length(array(
                        'max' => $config['ltext_len'],
                    )),
                ),
            ))
            ->add('RegularStatus', 'entity', array(
                'class' => 'Plugin\EccubePaymentLite3\Entity\Master\RegularStatus',
                'property' => 'name',
                'empty_value' => false,
                'empty_data' => null,
            ))
            ->add('Payment', 'entity', array(
                'class' => 'Eccube\Entity\Payment',
                'property' => 'method',
                'empty_value' => '選択してください',
                'empty_data' => null,
                'constraints' => array(
                    new Assert\NotBlank(),
                ),
            ))
            ->add('RegularOrderDetails', 'collection', array(
                'type' => new \Plugin\EccubePaymentLite3\Form\Type\Admin\RegularOrderDetailType($this->app),
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
            ))
            ->add('RegularShippings', 'collection', array(
                'type' => new \Plugin\EccubePaymentLite3\Form\Type\Admin\RegularShippingType($this->app)
            ));
        $builder
            ->add($builder->create('Customer', 'hidden')
                ->addModelTransformer(new DataTransformer\EntityToIdTransformer(
                    $this->app['orm.em'],
                    '\Eccube\Entity\Customer'
                )));
        $app = $this->app;
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) use ($app) {

            if ('calc' === $app['request']->get('mode')) {

                $data = $event->getData();

                $regularOrderDetails = &$data['RegularOrderDetails'];
                $regularShippings = &$data['RegularShippings'];

                $regularShipmentItems = array();
                foreach ($regularShippings as &$regularShipping) {
                    $items = &$regularShipping['RegularShipmentItems'];
                    if (count($items) > 0) {
                        foreach ($items as &$item) {
                            $regularShipmentItems[] = &$item;
                        }
                    }
                }

                if (count($regularOrderDetails) > 0) {
                    $regularOrderDetailsCount = count($regularOrderDetails);
                    $regularShipmentItemsCount = count($regularShipmentItems);
                    for ($i = 0; $i < $regularOrderDetailsCount; $i++) {
                        for ($j = 0; $j < $regularShipmentItemsCount; $j++) {
                            $itemidx = &$regularShipmentItems[$j]['itemidx'];
                            if ($itemidx == $i) {
                                $regularShipmentItem = &$regularShipmentItems[$j];
                                $regularShipmentItem['price'] = $regularOrderDetails[$i]['price'];
                                $regularOrderDetail = &$regularOrderDetails[$i];
                                $regularOrderDetail['quantity'] = $regularShipmentItems[$j]['quantity'];
                                break;
                            }
                        }
                    }
                }

                $event->setData($data);
            }

        });
        $builder->addEventSubscriber(new \Eccube\Event\FormEventSubscriber());
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Plugin\EccubePaymentLite3\Entity\RegularOrder',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'epsilon_regular_order';
    }
}
