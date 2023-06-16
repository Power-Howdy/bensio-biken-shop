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
 * メルマガテンプレート選択コンボボックス用に作成
 */

namespace Plugin\MailMagazine\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MailMagazineTemplateType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'class' => 'Plugin\MailMagazine\Entity\MailMagazineTemplate',
            'property' => 'subject',
            'label' => false,
            'multiple' => false,
            'expanded' => false,
            'required' => false,
            'empty_value' => '-',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('mt')
                    ->orderBy('mt.id', 'ASC');
            },
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'mail_magazine_template';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'entity';
    }
}
