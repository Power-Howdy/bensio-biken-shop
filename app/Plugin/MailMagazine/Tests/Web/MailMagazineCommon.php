<?php
/**
 * This file is part of EC-CUBE.
 *
 * Copyright(c) EC-CUBE CO.,LTD. All Rights Reserved.
 * https://www.ec-cube.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\MailMagazine\Tests\Web;

use Eccube\Common\Constant;
use Eccube\Entity\Master\CustomerStatus;
use Eccube\Entity\Master\Sex;
use Eccube\Tests\Web\Admin\AbstractAdminWebTestCase;
use Plugin\MailMagazine\Entity\MailmagaCustomer;
use Plugin\MailMagazine\Entity\MailMagazineSendHistory;
use Plugin\MailMagazine\Entity\MailMagazineTemplate;

class MailMagazineCommon extends AbstractAdminWebTestCase
{
    protected function createMagazineTemplate()
    {
        $fake = $this->getFaker();
        $MailTemplate = new MailMagazineTemplate();

        $MailTemplate
            ->setSubject($fake->word)
            ->setBody($fake->word);
        $MailTemplate->setDelFlg(Constant::DISABLED);
        $this->app['orm.em']->persist($MailTemplate);
        $this->app['orm.em']->flush();

        return $MailTemplate;
    }

    protected function createMailMagazineCustomer()
    {
        $fake = $this->getFaker();
        $current_date = new \DateTime();

        $Sex = $this->app['eccube.repository.master.sex']->find(1);

        $Customer = $this->createCustomer();
        $Customer
            ->setSex($Sex)
            ->setBirth($current_date->modify('-20 years'))
            ->setTel01($fake->randomNumber(3))
            ->setTel02($fake->randomNumber(3))
            ->setTel03($fake->randomNumber(3))
            ->setCreateDate($current_date->modify('-20 days'))
            ->setUpdateDate($current_date->modify('-1 days'))
            ->setLastBuyDate($current_date->modify('-1 days'))
        ;
        $this->app['orm.em']->persist($Customer);
        $this->app['orm.em']->flush();

        // create mail customer
        $MailmagaCustomer = new MailmagaCustomer();
        $MailmagaCustomer
            ->setCustomerId($Customer->getId())
            ->setMailmagaFlg(Constant::ENABLED)
            ->setDelFlg(Constant::DISABLED)
            ->setCreateDate($current_date)
            ->setUpdateDate($current_date);
        $this->app['orm.em']->persist($MailmagaCustomer);
        $this->app['orm.em']->flush();

        return $Customer;
    }

    protected function createSearchForm(\Eccube\Entity\Customer $MailCustomer, $birth_month = null)
    {
        // create order
        $Order = $this->createOrder($MailCustomer);
        $order_detail = $Order->getOrderDetails();
        $old_date = new \DateTime('1980-01-01');

        return array(
            '_token' => 'dummy',
            'multi' => $MailCustomer->getId(),
            'pref' => $MailCustomer->getPref()->getId(),
            'sex' => array($MailCustomer->getSex()->getId()),
            'birth_start' => $old_date->format('Y-m-d'),
            'birth_end' => $MailCustomer->getBirth()->format('Y-m-d'),
            'tel' => array('tel01' => $MailCustomer->getTel01(),
                'tel02' => $MailCustomer->getTel02(),
                'tel03' => $MailCustomer->getTel03(), ),
            'buy_total_start' => 0,
            'buy_total_end' => $MailCustomer->getBuyTotal(),
            'buy_times_start' => 0,
            'buy_times_end' => $MailCustomer->getBuyTimes(),
            'create_date_start' => $old_date->format('Y-m-d'),
            'create_date_end' => $MailCustomer->getCreateDate()->format('Y-m-d'),
            'update_date_start' => $old_date->format('Y-m-d'),
            'update_date_end' => $MailCustomer->getUpdateDate()->format('Y-m-d'),
            'last_buy_start' => $old_date->format('Y-m-d'),
            'last_buy_end' => $MailCustomer->getLastBuyDate()->format('Y-m-d'),
            'customer_status' => array($MailCustomer->getStatus()->getId()),
            'buy_product_code' => $order_detail[0]->getProductName(),
            'birth_month' => $birth_month,
        );
    }

    protected function createSendHistory(\Eccube\Entity\Customer $MailCustomer)
    {
        $currentDatetime = new \DateTime();
        $MailTemplate = $this->createMagazineTemplate();
        $formData = $this->createSearchForm($MailCustomer);
        $formData['customer_status'] = array($MailCustomer->getStatus());
        $formData['pref'] = $this->app['eccube.repository.master.pref']->find($formData['pref']);
        $formData['sex'] = array($MailCustomer->getSex());
        $formData = array_merge($formData, $formData['tel']);
        unset($formData['tel']);

        // -----------------------------
        // plg_send_history
        // -----------------------------
        $SendHistory = new MailMagazineSendHistory();

        // data
        $SendHistory->setBody($MailTemplate->getBody());
        $SendHistory->setSubject($MailTemplate->getSubject());
        $SendHistory->setSendCount(1);
        $SendHistory->setCompleteCount(1);
        $SendHistory->setErrorCount(0);
        $SendHistory->setDelFlg(Constant::DISABLED);

        $SendHistory->setEndDate(null);
        $SendHistory->setUpdateDate(null);

        $SendHistory->setCreateDate($currentDatetime);
        $SendHistory->setStartDate($currentDatetime);

        // json形式で検索条件を保存
        $formData['sex'] = array_filter(array_map(function ($entity) {
            if ($entity instanceof Sex) {
                return $entity->toArray();
            } else {
                return false;
            }
        }, $formData['sex']));

        $formData['customer_status'] = array_filter(array_map(function ($entity) {
            if ($entity instanceof CustomerStatus) {
                return $entity->toArray();
            } else {
                return false;
            }
        }, $formData['customer_status']));

        $SendHistory->setSearchData(json_encode($formData));

        $this->app['eccube.plugin.mail_magazine.repository.mail_magazine_history']->createSendHistory($SendHistory);

        return $SendHistory;
    }
}
