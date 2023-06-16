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

class MailMagazineTemplateControllerTest extends MailMagazineCommon
{
    protected function createFormData()
    {
        $fake = $this->getFaker();

        return array(
            'subject' => $fake->word,
            'body' => $fake->word,
            '_token' => 'dummy',
        );
    }

    /**
     * Test routing.
     */
    public function testRoutingMailMagazineTemplate()
    {
        $this->client->request('GET',
            $this->app->url('plugin_mail_magazine_template')
        );
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    public function testRegist()
    {
        $this->client->request('GET',
            $this->app->url('plugin_mail_magazine_template_regist')
        );
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    public function testEdit()
    {
        $MailTemplate = $this->createMagazineTemplate();

        $this->client->request('POST',
            $this->app->url('plugin_mail_magazine_template_edit', array('id' => $MailTemplate->getId()))
        );

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    public function testEdit_IdIsNull()
    {
        $this->client->request('POST',
            $this->app->url('plugin_mail_magazine_template_edit', array('id' => null))
        );

        $this->assertTrue($this->client->getResponse()->isRedirect($this->app->url('plugin_mail_magazine_template')));
    }

    public function testEdit_IdIncorrect()
    {
        $this->client->request('POST',
            $this->app->url('plugin_mail_magazine_template_edit', array('id' => 9999999))
        );

        $this->assertTrue($this->client->getResponse()->isRedirect($this->app->url('plugin_mail_magazine_template')));
    }

    public function testEdit_NotPost()
    {
        $this->setExpectedException('\Symfony\Component\HttpKernel\Exception\BadRequestHttpException');
        $this->client->request('GET',
            $this->app->url('plugin_mail_magazine_template_edit', array('id' => null))
        );
    }

    public function testCommit_FormInvalid()
    {
        $form = $this->createFormData();
        unset($form['subject']);

        $this->client->request('POST',
            $this->app->url('plugin_mail_magazine_template_commit'),
            array('mail_magazine_template_edit' => $form)
        );
        $this->assertTrue(true);
    }

    public function testCommitEdit_IdIncorrect()
    {
        $form = $this->createFormData();

        $this->client->request('POST',
            $this->app->url('plugin_mail_magazine_template_commit', array('id' => 9999999)),
            array('mail_magazine_template_edit' => $form)
        );
        $this->assertTrue($this->client->getResponse()->isRedirect($this->app->url('plugin_mail_magazine_template')));
    }

    public function testCommitEdit_IdIsZero()
    {
        $form = $this->createFormData();

        $this->client->request('POST',
            $this->app->url('plugin_mail_magazine_template_commit', array('id' => 0)),
            array('mail_magazine_template_edit' => $form)
        );

        $this->assertTrue($this->client->getResponse()->isRedirect($this->app->url('plugin_mail_magazine_template')));
    }

    public function testCommitRegist()
    {
        $form = $this->createFormData();

        $this->client->request('POST',
            $this->app->url('plugin_mail_magazine_template_commit'),
            array('mail_magazine_template_edit' => $form)
        );

        $this->assertTrue($this->client->getResponse()->isRedirect($this->app->url('plugin_mail_magazine_template')));
        $MailTemplate = $this->app['eccube.plugin.mail_magazine.repository.mail_magazine']->findOneBy(array('subject' => $form['subject']));
        $this->actual = $MailTemplate->getBody();
        $this->expected = $form['body'];
        $this->verify();
    }

    public function testCommitEdit()
    {
        $MailTemplate = $this->createMagazineTemplate();

        $form = $this->createFormData();

        $this->client->request('POST',
            $this->app->url('plugin_mail_magazine_template_commit', array('id' => $MailTemplate->getId())),
            array('mail_magazine_template_edit' => $form)
        );

        $this->assertTrue($this->client->getResponse()->isRedirect($this->app->url('plugin_mail_magazine_template')));

        $this->actual = $MailTemplate->getSubject();
        $this->expected = $form['subject'];
        $this->verify();
    }

    public function testPreview()
    {
        $MailTemplate = $this->createMagazineTemplate();

        $this->client->request('GET',
            $this->app->url('plugin_mail_magazine_template_preview', array('id' => $MailTemplate->getId()))
        );

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    public function testPreview_IdIsNull()
    {
        $this->client->request('GET',
            $this->app->url('plugin_mail_magazine_template_preview', array('id' => null))
        );

        $this->assertTrue($this->client->getResponse()->isRedirect($this->app->url('plugin_mail_magazine_template')));
    }

    public function testPreview_IdIncorrect()
    {
        $this->client->request('GET',
            $this->app->url('plugin_mail_magazine_template_preview', array('id' => 9999999))
        );

        $this->assertTrue($this->client->getResponse()->isRedirect($this->app->url('plugin_mail_magazine_template')));
    }

    public function testDelete()
    {
        $MailTemplate = $this->createMagazineTemplate();

        $this->client->request('POST',
            $this->app->url('plugin_mail_magazine_template_delete', array('id' => $MailTemplate->getId()))
        );

        $this->assertTrue($this->client->getResponse()->isRedirect($this->app->url('plugin_mail_magazine_template')));
    }

    public function testDelete_IdIsNull()
    {
        $this->client->request('POST',
            $this->app->url('plugin_mail_magazine_template_delete', array('id' => null))
        );

        $this->assertTrue($this->client->getResponse()->isRedirect($this->app->url('plugin_mail_magazine_template')));
    }

    public function testDelete_IdIncorrect()
    {
        $this->client->request('POST',
            $this->app->url('plugin_mail_magazine_template_delete', array('id' => 9999999))
        );

        $this->assertTrue($this->client->getResponse()->isRedirect($this->app->url('plugin_mail_magazine_template')));
    }

    public function testDelete_IdIsZero()
    {
        $this->client->request('POST',
            $this->app->url('plugin_mail_magazine_template_delete', array('id' => 0))
        );

        $this->assertTrue($this->client->getResponse()->isRedirect($this->app->url('plugin_mail_magazine_template')));
    }
}
