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

namespace Plugin\MailMagazine\Form\Extension;

use Eccube\Entity\Customer;
use Plugin\MailMagazine\Entity\MailmagaCustomer;
use Plugin\MailMagazine\Util\Version;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Validator\Constraints as Assert;

class EntryMailMagazineTypeExtension extends AbstractTypeExtension
{
    private $app;

    public function __construct(\Eccube\Application $app)
    {
        $this->app = $app;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $mailmagaFlg = null;
        if ($this->app->isGranted('IS_AUTHENTICATED_FULLY')) {
            /** @var Customer $Customer */
            $Customer = $this->app->user();
            $MailmagaCustomerRepository = $this->app['eccube.plugin.mail_magazine.repository.mail_magazine_mailmaga_customer'];
            /** @var MailmagaCustomer $MailmagaCustomer */
            $MailmagaCustomer = $MailmagaCustomerRepository->findOneBy(array('customer_id' => $Customer->getId()));
            if (!is_null($MailmagaCustomer)) {
                $mailmagaFlg = $MailmagaCustomer->getMailmagaFlg();
            }
        }

        $builder
            ->add('mailmaga_flg', 'choice', array(
                'label' => 'メールマガジン送付について',
                'choices' => array(
                    '1' => '受け取る',
                    '0' => '受け取らない',
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true,
                'constraints' => array(
                    new Assert\NotBlank(),
                ),
                'mapped' => false,
                'data' => $mailmagaFlg,
            ))
            ;
    }

    /*
     * {@inheritdoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $freeze = $form->getConfig()->getAttribute('freeze');

        if ($freeze) {
            $value = $view->vars['form']->children['mailmaga_flg']->vars['data'];
            $choices = $view->vars['form']->children['mailmaga_flg']->vars['choices'];
            foreach ($choices as $choice) {
                if ($choice->value == $value) {
                    if (Version::isSupport('3.0.13', '<')) {
                        $view->vars['form']->children['mailmaga_flg']->vars['data'] = array('name' => $choice->label, 'id' => $value);
                    } else {
                        $view->vars['form']->children['mailmaga_flg']->vars['data'] = $choice->value;
                    }
                    break;
                }
            }
        }
    }

    public function getExtendedType()
    {
        return 'entry';
    }
}
