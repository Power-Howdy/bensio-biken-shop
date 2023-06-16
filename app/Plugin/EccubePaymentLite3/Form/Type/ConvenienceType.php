<?php
/*
 * Copyright(c) 2015 GMO Payment Gateway, Inc. All rights reserved.
 * http://www.gmo-pg.com/
 */

namespace Plugin\EccubePaymentLite3\Form\Type;

use Eccube\Application;
use Plugin\EccubePaymentLite3\Util\PluginUtil;
use Plugin\EccubePaymentLite3\Util\PaymentUtil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ConvenienceType extends AbstractType {
    private $app;

    public function __construct(Application $app) {
        $this->app = $app;
    }

    /**
     * Build payment type form
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $objPlgUtil = new PluginUtil($this->app);
        $objUtil = new PaymentUtil($this->app);

        $Order = $this->app['eccube.repository.order']->findOneBy(array('pre_order_id' => $this->app['eccube.service.cart']->getPreOrderId()));

        // コンビニ名を全て取得
        $arrConveniences = $objUtil->getConvenienceNames();

        // 設定されているコンビニのみを抽出
        $arrUseConveniences = array();
        $arrUseConveniIds = array();
        $arrUseConveniIds = $objPlgUtil->getSubData('use_convenience');
        foreach ($arrUseConveniIds as $id) {
            if (isset($arrConveniences[$id])) {
                $arrUseConveniences[$id] = $arrConveniences[$id];
            }
        }

        $builder
            ->add('convenience', 'choice', array(
                'label' => 'コンビニ選択',
                'choices' => $arrUseConveniences,
                'multiple' => false,
                'expanded' => true,
                'constraints' => array(
                    new Assert\NotBlank(array('message' => '※ コンビニ選択が選択されていません。')),
                ),
            ))
            ->add('kana01', 'text', array(
                'label' => 'セイ',
                'constraints' => array(
                    new Assert\NotBlank(array('message' => '※ セイが入力されていません。')),
                ),
                'data' => $Order->getKana01(),
            ))
            ->add('kana02', 'text', array(
                'label' => 'メイ',
                'constraints' => array(
                    new Assert\NotBlank(array('message' => '※ メイが入力されていません。')),
                ),
                'data' => $Order->getKana02(),
            ))
            ->add('tel01', 'text', array(
                'label' => '電話番号1',
                'constraints' => array(
                    new Assert\NotBlank(array('message' => '※ 電話番号1が入力されていません。')),
                ),
                'data' => $Order->getTel01(),
            ))
            ->add('tel02', 'text', array(
                'label' => '電話番号2',
                'constraints' => array(
                    new Assert\NotBlank(array('message' => '※ 電話番号2が入力されていません。')),
                ),
                'data' => $Order->getTel02(),
            ))
            ->add('tel03', 'text', array(
                'label' => '電話番号3',
                'constraints' => array(
                    new Assert\NotBlank(array('message' => '※ 電話番号3が入力されていません。')),
                ),
                'data' => $Order->getTel03(),
            ))
            ->addEventSubscriber(new \Eccube\Event\FormEventSubscriber());;
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'convenience';
    }

}
