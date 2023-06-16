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
 * メルマガテンプレート設定用
 */

namespace Plugin\MailMagazine\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;

class MailMagazineTemplateEditType extends AbstractType
{
    public $app;

    public function __construct(\Silex\Application $app)
    {
        $this->app = $app;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $app = $this->app;

        $builder
            ->add('subject', 'text', array(
                'label' => '件名',
                'required' => true,
                'constraints' => array(
                    new Assert\NotBlank(),
                ),
            ))
            ->add('body', 'textarea', array(
                'label' => '本文 (テキスト形式)',
                'required' => true,
                'constraints' => array(
                    new Assert\NotBlank(),
                ),
            ))
            ->add('htmlBody', 'textarea', array(
                'label' => '本文 (HTML形式)',
                'required' => false,
            ))
            ->addEventListener(FormEvents::POST_SUBMIT, function ($event) use ($app) {
            })
            ->addEventSubscriber(new \Eccube\Event\FormEventSubscriber());
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Plugin\MailMagazine\Entity\MailMagazineTemplate',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'mail_magazine_template_edit';
    }
}
