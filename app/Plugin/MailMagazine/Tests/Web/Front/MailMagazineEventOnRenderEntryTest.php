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

namespace Plugin\MailMagazine\Tests\Web\Front;

use Eccube\Common\Constant;
use Eccube\Tests\Web\AbstractWebTestCase;

class MailMagazineEventOnRenderEntryTest extends AbstractWebTestCase
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
            'email' => array(
                'first' => $email,
                'second' => $email,
            ),
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
            '_token' => 'dummy',
        );

        return $form;
    }

    public function testOnRenderEntry()
    {
        $crawler = $this->client->request('GET',
            $this->app->url('entry')
        );

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $crawler->filter('#entry_mailmaga_flg')->html();
        $this->assertTrue(true);
    }

    public function testOnRenderEntry_Post()
    {
        $formData = $this->createFormData();
        $updateFlg = Constant::ENABLED;

        $formData['mailmaga_flg'] = $updateFlg;

        $this->client->request('POST',
            $this->app->url('entry'),
            array(
                'entry' => $formData,
                'mode' => 'confirm',
            )
        );

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    public function testOnRenderEntry_PostComplete()
    {
        $this->initializeMailCatcher();
        $formData = $this->createFormData();
        $updateFlg = Constant::ENABLED;

        $formData['mailmaga_flg'] = $updateFlg;

        $this->client->request('POST',
            $this->app->url('entry'),
            array(
                'entry' => $formData,
                'mode' => 'complete',
            )
        );
        $this->assertTrue($this->client->getResponse()->isRedirect($this->app->url('entry_complete')));

        $this->cleanUpMailCatcherMessages();
    }
}
