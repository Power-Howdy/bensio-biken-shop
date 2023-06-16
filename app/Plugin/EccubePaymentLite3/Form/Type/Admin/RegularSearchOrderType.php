<?php



namespace Plugin\EccubePaymentLite3\Form\Type\Admin;

use \Symfony\Component\Form\AbstractType;
use \Symfony\Component\Form\Extension\Core\Type;
use \Symfony\Component\Form\FormBuilderInterface;
use \Symfony\Component\Validator\Constraints as Assert;

class RegularSearchOrderType extends AbstractType
{
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $config = $this->config;
        $builder
            // 受注ID・購入者名・購入者（フリガナ）・購入者会社名
            ->add('multi', 'text', array(
                'label' => '受注ID・購入者名・購入者（フリガナ）・購入者会社名',
                'required' => false,
                'constraints' => array(
                    new Assert\Length(array('max' => $config['stext_len'])),
                ),
            ))
            ->add('latest_status', 'order_status', array(
                'label' => '最終対応状況',
            ))
            ->add('regular_status', 'regular_status', array(
                'label' => '定期継続状況',
            ))
            ->add('name', 'text', array(
                'required' => false,
            ))
            ->add('kana', 'text', array(
                'required' => false,
                'constraints' => array(
                    new Assert\Regex(array(
                        'pattern' => "/^[ァ-ヶｦ-ﾟー]+$/u",
                        'message' => 'form.type.admin.notkanastyle',
                    )),
                ),
            ))
            ->add('email', 'email', array(
                'required' => false,
            ))
            ->add('tel', 'text', array(
                'required' => false,
                'constraints' => array(
                    new Assert\Regex(array(
                        'pattern' => "/^[\d-]+$/u",
                        'message' => 'form.type.admin.nottelstyle',
                    )),
                ),
            ))
            ->add('sex', 'sex', array(
                'label' => '性別',
                'required' => false,
                'expanded' => true,
                'multiple' => true,
            ))
            ->add('first_order_date_start', 'date', array(
                'label' => '初回購入日(FROM)',
                'required' => false,
                'input' => 'datetime',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'empty_value' => array('year' => '----', 'month' => '--', 'day' => '--'),
            ))
            ->add('first_order_date_end', 'date', array(
                'label' => '初回購入日(TO)',
                'required' => false,
                'input' => 'datetime',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'empty_value' => array('year' => '----', 'month' => '--', 'day' => '--'),
            ))
            ->add('buy_product_id', 'number', array(
                'label' => '購入商品ID',
                'required' => false,
            ))
            ->add('buy_product_name', 'text', array(
                'label' => '購入商品名',
                'required' => false,
            ))
            ->add('regular_count_start', 'number', array(
                'label' => '定期回数(FROM)',
                'required' => false,
            ))
            ->add('regular_count_end', 'number', array(
                'label' => '定期回数(TO)',
                'required' => false,
            ))
            ->addEventSubscriber(new \Eccube\Event\FormEventSubscriber());
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'admin_search_regular_order';
    }
}
