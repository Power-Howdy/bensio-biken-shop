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

use Eccube\Common\Constant;
use Plugin\MailMagazine\Tests\Web\MailMagazineCommon;

class MailMagazineEventOnRenderAdminCustomerBeforeTest extends MailMagazineCommon
{
    protected function createFormData()
    {
        $faker = $this->getFaker();
        $tel = explode('-', $faker->phoneNumber);

        $email = $faker->safeEmail;
        $password = $faker->lexify('????????');
        $birth = $faker->dateTimeBetween;

        $form = array(
            'name' => array(
                'name01' => $faker->lastName,
                'name02' => $faker->firstName,
            ),
            'kana' => array(
                'kana01' => $faker->lastKanaName,
                'kana02' => $faker->firstKanaName,
            ),
            'company_name' => $faker->company,
            'zip' => array(
                'zip01' => $faker->postcode1(),
                'zip02' => $faker->postcode2(),
            ),
            'address' => array(
                'pref' => '5',
                'addr01' => $faker->city,
                'addr02' => $faker->streetAddress,
            ),
            'tel' => array(
                'tel01' => $tel[0],
                'tel02' => $tel[1],
                'tel03' => $tel[2],
            ),
            'fax' => array(
                'fax01' => $tel[0],
                'fax02' => $tel[1],
                'fax03' => $tel[2],
            ),
            'email' => $email,
            'password' => array(
                'first' => $password,
                'second' => $password,
            ),
            'birth' => array(
                'year' => $birth->format('Y'),
                'month' => $birth->format('n'),
                'day' => $birth->format('j'),
            ),
            'sex' => 1,
            'job' => 1,
            'status' => 1,
            '_token' => 'dummy',
        );

        return $form;
    }

    public function testOnRenderAdminCustomerBefore_Edit()
    {
        $Customer = $this->createMailMagazineCustomer();

        $this->client->request('GET',
            $this->app->url('admin_customer_new', array('id' => $Customer->getId()))
        );

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    public function testOnRenderAdminCustomerBefore_EditPost()
    {
        $Customer = $this->createMailMagazineCustomer();
        $updateFlg = Constant::DISABLED;
        $form = $this->createFormData();
        $form = array_merge($form, array(
            'mailmaga_flg' => $updateFlg,
        ));
        $this->client->request('POST',
            $this->app->url('admin_customer_edit', array('id' => $Customer->getId())),
            array(
                'admin_customer' => $form,
            )
        );

        $MailCustomer = $this->app['eccube.plugin.mail_magazine.repository.mail_magazine_mailmaga_customer']
            ->findOneBy(array('customer_id' => $Customer->getId()));
        $this->actual = $MailCustomer->getMailmagaFlg();
        $this->expected = $updateFlg;
        $this->verify();
    }

    public function testOnRenderAdminCustomerBefore_EditPost_WithInvalidPostData()
    {
        $Customer = $this->createMailMagazineCustomer();
        $updateFlg = Constant::DISABLED;
        $form = $this->createFormData();
        $form = array_merge($form, array(
            // バリデーションエラーになるケース
            'kana' => array('kana01' => 'invalid'),
            'mailmaga_flg' => $updateFlg,
        ));
        $this->client->request('POST',
            $this->app->url('admin_customer_edit', array('id' => $Customer->getId())),
            array(
                'admin_customer' => $form,
            )
        );

        $MailCustomer = $this->app['eccube.plugin.mail_magazine.repository.mail_magazine_mailmaga_customer']
            ->findOneBy(array('customer_id' => $Customer->getId()));
        $this->actual = $MailCustomer->getMailmagaFlg();
        $this->expected = $updateFlg;
        // 保存されない
        $this->assertNotEquals($this->actual, $this->expected);
    }
}
