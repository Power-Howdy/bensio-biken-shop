<?php

namespace Plugin\EccubePaymentLite3\Form\Type\Admin;

use Eccube\Application;
use Plugin\EccubePaymentLite3\Entity\GmoEpsilonPlugin;
use Plugin\EccubePaymentLite3\Util\PaymentUtil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;
use Symfony\Component\Validator\Constraints as Assert;

class ConfigType extends AbstractType
{
    private $app;
    private $subData;

    public function __construct(Application $app, $subData = null)
    {
        $this->app = $app;
        $this->subData = $subData;
    }

    /**
     * Build config type form
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $objUtil = new PaymentUtil($this->app);
        if (empty($this->subData)) {
            $this->subData = array(
                'contract_code' => null,
                'environmental_setting' => null,
                'credit_payment_setting' => GmoEpsilonPlugin::TOKEN_PAYMENT,
                'use_payment' => array(),
                'use_convenience' => array(),
                'regular' => 0,
                'block_mode' => 0,
                'access_frequency_time' => null,
                'access_frequency' => null,
                'block_time' => null,
                'white_list' => null,
                'ip_black_lists' => null,
                'card_expiration_notification_days' => null,
            );
        } else if (!isset($this->subData['ssl_version'])) {
        	$this->subData['ssl_version'] = 6;
        } else if (!isset($this->subData['block_mode'])) {
            $this->subData['block_mode'] = 0;
        }
        $arrPayments = $objUtil->getPaymentNames();
        $arrConveniences = $objUtil->getConvenienceNames();

        $builder
            ->add('contract_code', 'text', array(
                'label' => '契約コード',
                'attr' => array(
                    'class' => 'lockon_card_row',
                ),
                'constraints' => array(
                    new Assert\NotBlank(array('message' => '※ 契約コードが入力されていません。')),
                ),
                'data' => $this->subData['contract_code'],
            ))

            ->add('environmental_setting', 'choice', array(
                'choices' => array(
                    GmoEpsilonPlugin::ENVIRONMENTAL_SETTING_DEVELOPMENT => '開発',
                    GmoEpsilonPlugin::ENVIRONMENTAL_SETTING_PRODUCTION => '本番',
                ),
                'data' => $this->subData['environmental_setting'],
                'multiple' => false,
                'expanded' => true,
                'constraints' => array(
                    new Assert\NotBlank(array('message' => '※ 環境設定は必須項目です。')),
                ),
            ))
            ->add('credit_payment_setting', 'choice', array(
                'choices' => array(
                    GmoEpsilonPlugin::LINK_PAYMENT => 'リンク決済',
                    GmoEpsilonPlugin::TOKEN_PAYMENT => 'トークン決済',
                ),
                'data' => $this->subData['credit_payment_setting'],
                'multiple' => false,
                'expanded' => true,
                'constraints' => array(
                    new Assert\NotBlank(array('message' => '※ クレジットカード決済設定は必須項目です。')),
                ),
            ))
            ->add('use_payment', 'choice', array(
                'label' => '利用決済方法',
                'choices' => $arrPayments,
                'expanded' => true,
                'multiple' => true,
                'data' => $this->subData['use_payment'],
                'constraints' => array(
                    new Assert\NotBlank(array('message' => '※ 利用決済方法が選択されていません。')),
                ),
            ))

            ->add('use_convenience', 'choice', array(
                'label' => '利用コンビニ',
                'choices' => $arrConveniences,
                'expanded' => true,
                'multiple' => true,
                'data' => $this->subData['use_convenience'],

            ))

            ->add('regular', 'choice', array(
                'choices' => array(
                    0 => '利用しない',
                    1 => '利用する',
                ),
                'data' => $this->subData['regular'],
                'multiple' => false,
                'expanded' => true,
            ))

            ->add('block_mode', 'choice', array(
                'choices' => array(
                    1 => 'ON',
                    0 => 'OFF',
                ),
                'data' => $this->subData['block_mode'],
                'multiple' => false,
                'expanded' => true,
                'constraints' => array(
                    new Assert\NotBlank(array('message' => '※ ブロックモードが選択されていません。')),
                ),
            ))

            ->add('access_frequency_time', 'text', array(
                'label' => 'アクセス頻度（時間）',
                'data' => $this->subData['access_frequency_time'],
                'required' => false,
                'attr' => array(
                    'class' => 'lockon_card_row',
                ),
                'constraints' => array(
                    new Assert\Length(array('max' => $this->app['config']['int_len'],)),
                    new Assert\Regex(array(
                        'pattern' => "/^\d+$/u",
                        'message' => 'form.type.numeric.invalid'
                    )),
                ),
            ))

            ->add('access_frequency', 'text', array(
                'label' => 'アクセス頻度（回数）',
                'data' => $this->subData['access_frequency'],
                'required' => false,
                'attr' => array(
                    'class' => 'lockon_card_row',
                ),
                'constraints' => array(
                    new Assert\Length(array('max' => $this->app['config']['int_len'],)),
                    new Assert\Regex(array(
                        'pattern' => "/^\d+$/u",
                        'message' => 'form.type.numeric.invalid'
                    )),
                ),
            ))

            ->add('block_time', 'text', array(
                'label' => 'ブロック時間',
                'data' => $this->subData['block_time'],
                'required' => false,
                'attr' => array(
                    'class' => 'lockon_card_row',
                ),
                'constraints' => array(
                    new Assert\Length(array('max' => $this->app['config']['int_len'],)),
                    new Assert\Regex(array(
                        'pattern' => "/^\d+$/u",
                        'message' => 'form.type.numeric.invalid'
                    )),
                ),
            ))

            ->add('white_list', 'textarea', array(
                'label' => 'ホワイトリスト',
                'data' => $this->subData['white_list'],
                'required' => false,
                'attr' => array(
                    'class' => 'lockon_card_row',
                ),
                'constraints' => array(
                    new Assert\Length(array('max' => 200,)),
                ),
            ))

            ->add('ip_black_lists', 'textarea', array(
                'label' => 'ブラックリスト',
                'data' => $this->subData['ip_black_lists'],
                'required' => false,
                'attr' => array(
                    'class' => 'lockon_card_row',
                ),
                'constraints' => array(
                    new Assert\Length(array('max' => 200,)),
                ),
            ))
            ->add('card_expiration_notification_days', 'choice', array(
                'label' => 'カード有効期限切れ通知日数',
                'choices' => array(
                    '' => '-',
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                    '9' => '9',
                    '10' => '10',
                    '11' => '11',
                    '12' => '12',
                    '13' => '13',
                    '14' => '14',
                    '15' => '15',
                    '16' => '16',
                    '17' => '17',
                    '18' => '18',
                    '19' => '19',
                    '20' => '20',
                    '21' => '21',
                    '22' => '22',
                    '23' => '23',
                    '24' => '24',
                    '25' => '25',
                ),
                'data' => isset($this->subData['card_expiration_notification_days']) ? $this->subData['card_expiration_notification_days'] : null,
                'multiple' => false,
                'expanded' => false,
                'constraints' => array(
                    new Assert\NotBlank(array('message' => '※ カード有効期限切れ通知日数が選択されていません。')),
                )
            ))

            ->addEventSubscriber(new \Eccube\Event\FormEventSubscriber());

        $builder->addEventListener(FormEvents::POST_BIND, function($event) {
            $form = $event->getForm();
            $block_mode = $form['block_mode']->getData();

            // ブロックモードONの場合チェック追加
            if ($block_mode === 1) {
                if (is_null($form['access_frequency_time']->getData())) {
                    $form['access_frequency_time']->addError(new FormError('※ アクセス頻度（時間）が入力されていません。'));
                }

                if (is_null($form['access_frequency']->getData())) {
                    $form['access_frequency']->addError(new FormError('※ アクセス頻度（回数）が入力されていません。'));
                }

                if (is_null($form['block_time']->getData())) {
                    $form['block_time']->addError(new FormError('※ ブロック時間が入力されていません。'));
                }

                if (!is_null($form['white_list']->getData())) {

                    $ips = explode(',', $form['white_list']->getData());
                    $ip_error = false;
                    foreach ($ips as $ip) {
                        if (!preg_match('/(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])/', $ip)) {
                            $ip_error = true;
                        }
                    }
                    if ($ip_error) {
                        $form['white_list']->addError(new FormError('※ IPアドレスの形式が不正です。'));
                    }
                }
            }

            if (!is_null($form['ip_black_lists']->getData())) {
                $ips = explode(',', $form['ip_black_lists']->getData());
                $ip_error = false;
                foreach ($ips as $ip) {
                    if (!preg_match('/(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])/', $ip)) {
                        $ip_error = true;
                    }
                }
                if ($ip_error) {
                    $form['ip_black_lists']->addError(new FormError('※ IPアドレスの形式が不正です。'));
                }
            }
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'config';
    }
}
