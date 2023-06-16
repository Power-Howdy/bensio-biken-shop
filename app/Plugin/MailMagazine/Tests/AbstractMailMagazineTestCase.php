<?php

namespace Plugin\MailMagazine\Tests;

use Doctrine\Common\Collections\ArrayCollection;
use Eccube\Common\Constant;
use Eccube\Entity\Master\Pref;
use Eccube\Tests\Service\AbstractServiceTestCase;
use Plugin\MailMagazine\Entity\MailmagaCustomer;
use Plugin\MailMagazine\Service\MailMagazineService;

abstract class AbstractMailMagazineTestCase extends AbstractServiceTestCase
{
    /**
     * @var MailMagazineService
     */
    protected $mailMagazineService;

    /**
     * @var MailMagazineSendHistoryRepository
     */
    protected $mailMagazineSendHistoryRepository;

    public function setUp()
    {
        parent::setUp();
        $this->mailMagazineService = $this->app['eccube.plugin.mail_magazine.service.mail'];
        $this->mailMagazineSendHistoryRepository = $this->app[MailMagazineService::REPOSITORY_SEND_HISTORY];
    }

    /**
     * @param string $email
     * @param string $name01
     * @param string $name02
     *
     * @return \Eccube\Entity\Customer
     */
    protected function createMailmagaCustomer($email = 'mail_magazine_service_test@example.com', $name01 = 'name01', $name02 = 'name02')
    {
        $c = $this->createCustomer($email);
        if ($name01) {
            $c->setName01($name01);
        }
        if ($name02) {
            $c->setName02($name02);
        }
        $this->app['orm.em']->persist($c);
        $this->app['orm.em']->flush($c);

        $mc = new MailmagaCustomer();
        $mc->setCustomerId($c->getId());
        $mc->setDelFlg(Constant::DISABLED);
        $mc->setMailmagaFlg('1');

        $this->app['orm.em']->persist($mc);
        $this->app['orm.em']->flush($mc);

        return $c;
    }

    protected function createHistory(\Eccube\Entity\Customer $Customer)
    {
        return $this->mailMagazineService->createMailMagazineHistory(array(
            'pref' => null,
            'sex' => new ArrayCollection(),
            'customer_status' => new ArrayCollection(),
            'subject' => 'subject',
            'body' => 'body',
            'multi' => $Customer->getEmail(),
        ));
    }
}
