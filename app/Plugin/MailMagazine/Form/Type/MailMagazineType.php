<?php
/*
* This file is part of EC-CUBE
*
* Copyright(c) EC-CUBE CO.,LTD. All Rights Reserved.
* https://www.ec-cube.co.jp/
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
/*
 * [メルマガ配信]-[配信内容設定]用Form
 */

namespace Plugin\MailMagazine\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class MailMagazineType extends AbstractType
{
    private $app;

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
            // 会員ID・メールアドレス・名前・名前(フリガナ)
            ->add('multi', 'text', array(
                'label' => '会員ID・メールアドレス・名前・名前(フリガナ)',
                'required' => false,
                'constraints' => array(
                    new Assert\Length(array('max' => $config['stext_len'])),
                ),
            ))
            ->add('company_name', 'text', array(
                'label' => '会社名',
                'required' => false,
                'constraints' => array(
                    new Assert\Length(array('max' => $config['stext_len'])),
                ),
            ))
            ->add('pref', 'pref', array(
                'label' => '都道府県',
                'required' => false,
            ))
            ->add('sex', 'sex', array(
                'label' => '性別',
                'required' => false,
                'expanded' => true,
                'multiple' => true,
            ))
            ->add('birth_month', 'choice', array(
                'label' => '誕生月',
                'required' => false,
                'choices' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12),
            ))
            ->add('birth_start', 'birthday', array(
                'label' => '誕生日',
                'required' => false,
                'input' => 'datetime',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'empty_value' => array('year' => '----', 'month' => '--', 'day' => '--'),
            ))
            ->add('birth_end', 'birthday', array(
                'label' => '誕生日',
                'required' => false,
                'input' => 'datetime',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'empty_value' => array('year' => '----', 'month' => '--', 'day' => '--'),
            ))
            ->add('tel', 'tel', array(
                'label' => '電話番号',
                'required' => false,
            ))
            ->add('buy_total_start', 'integer', array(
                'label' => '購入金額',
                'required' => false,
                'constraints' => array(
                    new Assert\Length(array('max' => $config['price_len'])),
                ),
            ))
            ->add('buy_total_end', 'integer', array(
                'label' => '購入金額',
                'required' => false,
                'constraints' => array(
                    new Assert\Length(array('max' => $config['price_len'])),
                ),
            ))
            ->add('buy_times_start', 'integer', array(
                'label' => '購入回数',
                'required' => false,
                'constraints' => array(
                    new Assert\Length(array('max' => $config['int_len'])),
                ),
            ))
            ->add('buy_times_end', 'integer', array(
                'label' => '購入回数',
                'required' => false,
                'constraints' => array(
                    new Assert\Length(array('max' => $config['int_len'])),
                ),
            ))
            ->add('create_date_start', 'date', array(
                'label' => '登録日',
                'required' => false,
                'input' => 'datetime',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'empty_value' => array('year' => '----', 'month' => '--', 'day' => '--'),
            ))
            ->add('create_date_end', 'date', array(
                'label' => '登録日',
                'required' => false,
                'input' => 'datetime',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'empty_value' => array('year' => '----', 'month' => '--', 'day' => '--'),
            ))
            ->add('update_date_start', 'date', array(
                'label' => '更新日',
                'required' => false,
                'input' => 'datetime',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'empty_value' => array('year' => '----', 'month' => '--', 'day' => '--'),
            ))
            ->add('update_date_end', 'date', array(
                'label' => '更新日',
                'required' => false,
                'input' => 'datetime',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'empty_value' => array('year' => '----', 'month' => '--', 'day' => '--'),
            ))
            ->add('last_buy_start', 'date', array(
                'label' => '最終購入日',
                'required' => false,
                'input' => 'datetime',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'empty_value' => array('year' => '----', 'month' => '--', 'day' => '--'),
            ))
            ->add('last_buy_end', 'date', array(
                'label' => '最終購入日',
                'required' => false,
                'input' => 'datetime',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'empty_value' => array('year' => '----', 'month' => '--', 'day' => '--'),
            ))
            ->add('buy_product_name', 'text', array(
                'label' => '購入商品名',
                'required' => false,
                'constraints' => array(
                    new Assert\Length(array('max' => $config['stext_len'])),
                ),
            ))
            ->add('buy_product_code', 'text', array(
                'label' => '購入商品コード',
                'required' => false,
                'constraints' => array(
                    new Assert\Length(array('max' => $config['stext_len'])),
                ),
            ))
          // TODO DBから取得するのが正しいので修正
//             ->add('customer_status', 'choice', array(
//                 'label' => '会員ステータス',
//                 'required' => false,
//                 'choices' => array(
//                     '1' => '仮会員',
//                     '2' => '本会員',
//                 ),
//                 'expanded' => true,
//                 'multiple' => true,
//                 'empty_value' => false,
//             ))
            ->add('customer_status', 'customer_status', array(
                    'label' => '会員ステータス',
                    'required' => false,
                    'expanded' => true,
                    'multiple' => true,
            ))

            ->add('pageno', 'hidden', array(
            ))
            ->add('pagemax', 'page_max', array(
            ))
            // 以降テンプレート選択で使用する項目
            ->add('id', 'hidden')
            ->add('template', 'mail_magazine_template', array(
                'label' => 'テンプレート',
                'required' => false,
                'mapped' => false,
            ))
            ->add('subject', 'text', array(
                'label' => '件名',
                'required' => true,
            ))
            ->add('body', 'textarea', array(
                'label' => '本文 (テキスト形式)',
                'required' => true,
            ))
            ->add('htmlBody', 'textarea', array(
                'label' => '本文 (HTML形式)',
                'required' => false,
            ))
            ->addEventSubscriber(new \Eccube\Event\FormEventSubscriber());
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'mail_magazine';
    }
}
