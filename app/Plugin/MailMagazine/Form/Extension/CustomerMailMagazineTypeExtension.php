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
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CustomerMailMagazineTypeExtension extends AbstractTypeExtension
{
    private $app;

    public function __construct(\Eccube\Application $app)
    {
        $this->app = $app;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $mailmagaFlg = null;
        /** @var Customer $Customer */
        $Customer = isset($options['data']) ? $options['data'] : null;
        if (!is_null($Customer)) {
            $MailmagaCustomerRepository = $this->app['eccube.plugin.mail_magazine.repository.mail_magazine_mailmaga_customer'];
            /** @var MailmagaCustomer $MailmagaCustomer */
            $MailmagaCustomer = $MailmagaCustomerRepository->findOneBy(array('customer_id' => $Customer->getId()));
            if (!is_null($MailmagaCustomer)) {
                $mailmagaFlg = $MailmagaCustomer->getMailmagaFlg();
            }
        }

        $options = array(
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
        );

        if (!is_null($mailmagaFlg)) {
            $options['data'] = $mailmagaFlg;
        }

        $builder->add('mailmaga_flg', 'choice', $options);
    }

    public function getExtendedType()
    {
        return 'admin_customer';
    }
}
