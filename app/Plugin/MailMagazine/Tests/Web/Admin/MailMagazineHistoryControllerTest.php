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

namespace Plugin\MailMagazine\Tests\Web\Admin;

use Plugin\MailMagazine\Tests\Web\MailMagazineCommon;

class MailMagazineHistoryControllerTest extends MailMagazineCommon
{
    public function testIndex()
    {
        $this->client->request('GET',
            $this->app->url('plugin_mail_magazine_history')
        );
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    public function testPreview()
    {
        $MailCustomer = $this->createMailMagazineCustomer();
        $SendHistory = $this->createSendHistory($MailCustomer);

        $this->client->request('GET',
            $this->app->url('plugin_mail_magazine_history_preview', array('id' => $SendHistory->getId()))
        );

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    public function testPreview_IdIncorrect()
    {
        $this->client->request('GET',
            $this->app->url('plugin_mail_magazine_history_preview', array('id' => 9999999))
        );

        $this->assertTrue($this->client->getResponse()->isRedirect($this->app->url('plugin_mail_magazine_history')));
    }

    public function testPreview_IdIsNull()
    {
        $this->client->request('GET',
            $this->app->url('plugin_mail_magazine_history_preview', array('id' => null))
        );
        $this->assertTrue($this->client->getResponse()->isRedirect($this->app->url('plugin_mail_magazine_history')));
    }

    public function testCondition()
    {
        $MailCustomer = $this->createMailMagazineCustomer();
        $SendHistory = $this->createSendHistory($MailCustomer);

        $this->client->request('GET',
            $this->app->url('plugin_mail_magazine_history_condition', array('id' => $SendHistory->getId()))
        );

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    public function testCondition_IdIncorrect()
    {
        $this->client->request('GET',
            $this->app->url('plugin_mail_magazine_history_condition', array('id' => 9999999))
        );

        $this->assertTrue($this->client->getResponse()->isRedirect($this->app->url('plugin_mail_magazine_history')));
    }

    public function testCondition_IdIsNull()
    {
        $this->client->request('GET',
            $this->app->url('plugin_mail_magazine_history_condition', array('id' => null))
        );
        $this->assertTrue($this->client->getResponse()->isRedirect($this->app->url('plugin_mail_magazine_history')));
    }

    public function testDelete()
    {
        $MailCustomer = $this->createMailMagazineCustomer();
        $SendHistory = $this->createSendHistory($MailCustomer);

        $this->client->request('POST',
            $this->app->url('plugin_mail_magazine_history_delete', array('id' => $SendHistory->getId()))
        );

        $this->assertTrue($this->client->getResponse()->isRedirect($this->app->url('plugin_mail_magazine_history')));
    }

    public function testDelete_IdIncorrect()
    {
        $this->client->request('POST',
            $this->app->url('plugin_mail_magazine_history_delete', array('id' => 9999999))
        );

        $this->assertTrue($this->client->getResponse()->isRedirect($this->app->url('plugin_mail_magazine_history')));
    }

    public function testDelete_IdIsNull()
    {
        $this->setExpectedException('\Symfony\Component\HttpKernel\Exception\BadRequestHttpException');
        $this->client->request('POST',
            $this->app->url('plugin_mail_magazine_history_delete', array('id' => null))
        );
    }

    public function testDelete_NotPost()
    {
        $this->setExpectedException('\Symfony\Component\HttpKernel\Exception\BadRequestHttpException');
        $this->client->request('GET',
            $this->app->url('plugin_mail_magazine_history_delete', array('id' => null))
        );
    }
}
