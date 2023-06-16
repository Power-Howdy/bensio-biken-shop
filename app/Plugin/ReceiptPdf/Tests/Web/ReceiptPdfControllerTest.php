<?php
/*
 * This file is part of Receipt Pdf plugin
 *
 * Copyright (C) 2018 NinePoint Co. LTD. All Rights Reserved.
 *
 * Copyright (C) 2016 LOCKON CO.,LTD. All Rights Reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\ReceiptPdf\Tests\Web;

use Eccube\Common\Constant;
use Eccube\Entity\Member;
use Eccube\Entity\Order;
use Eccube\Tests\Web\Admin\AbstractAdminWebTestCase;
use Faker\Generator;
use Plugin\ReceiptPdf\Entity\ReceiptPdf;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpKernel\Client;

/**
 * Class ReceiptPdfControllerTest.
 */
class ReceiptPdfControllerTest extends AbstractAdminWebTestCase
{
    /**
     * Render test.
     */
    public function testRender()
    {
        $Order = $this->createOrderForSearch();
        $orderId = $Order->getId();
        /**
         * @var Crawler
         */
        $crawler = $this->client->request(
            'POST',
            $this->app->url('admin_order'),
            array('admin_search_order' => array(
                '_token' => 'dummy',
                'multi' => $orderId,
                ),
            )
        );

        $this->assertContains((string) $orderId, $crawler->filter('#result_list_main')->html());

        $expectedText = '帳票出力';
        $actualNode = $crawler->filter('#dropmenu')->html();
        $this->assertContains($expectedText, $actualNode);
    }

    /**
     * Render order pdf download.
     */
    public function testRenderDownloadWithDefault()
    {
        $Order = $this->createOrderForSearch();
        $orderId = $Order->getId();
        /**
         * @var Client $client
         */
        $client = $this->client;

        /**
         * @var Crawler $crawler
         */
        $crawler = $client->request('GET', $this->app->url('plugin_admin_receipt_pdf').'?ids'.$orderId.'=on');
        $html = $crawler->filter('.box-body')->html();
        $this->assertContains((string) $orderId, $html);
        $this->assertContains('お買上げ明細書(納品書)', $html);
        $this->assertContains('このたびはお買上げいただきありがとうございます。', $html);
        $this->assertContains('下記の内容にて納品させていただきます。', $html);
        $this->assertContains('ご確認くださいますよう、お願いいたします。', $html);
    }

    /**
     * Render order pdf download.
     */
    public function testRenderDownloadWithPreviousInput()
    {
        $Order = $this->createOrderForSearch();
        $orderId = $Order->getId();
        /**
         * @var Client $client
         */
        $client = $this->client;

        /**
         * @var Crawler $crawler
         */
        $crawler = $client->request('GET', $this->app->url('plugin_admin_receipt_pdf').'?ids'.$orderId.'=on');
        $form = $this->getForm($crawler);
        /**
         * @var Generator $faker
         */
        $faker = $this->getFaker();
        $form['admin_receipt_pdf[title]'] = $faker->text(50);
        $form['admin_receipt_pdf[message1]'] = $faker->text(30);
        $form['admin_receipt_pdf[message2]'] = $faker->text(30);
        $form['admin_receipt_pdf[message3]'] = $faker->text(30);
        $form['admin_receipt_pdf[note1]'] = $faker->text(50);
        $form['admin_receipt_pdf[note2]'] = $faker->text(50);
        $form['admin_receipt_pdf[note3]'] = $faker->text(50);
        $form['admin_receipt_pdf[default]'] = 1;
        $client->submit($form);
        $this->actual = $client->getResponse()->headers->get('Content-Type');
        $this->expected = 'application/pdf';
        $this->verify();

        $crawler = $client->request('GET', $this->app->url('plugin_admin_receipt_pdf').'?ids'.$orderId.'=on');
        $html = $crawler->filter('.box-body')->html();

        $this->assertContains((string) $orderId, $html);
        $this->assertContains($form['admin_receipt_pdf[title]']->getValue(), $html);
        $this->assertContains($form['admin_receipt_pdf[message1]']->getValue(), $html);
        $this->assertContains($form['admin_receipt_pdf[message2]']->getValue(), $html);
        $this->assertContains($form['admin_receipt_pdf[message3]']->getValue(), $html);
        $this->assertContains($form['admin_receipt_pdf[note1]']->getValue(), $html);
        $this->assertContains($form['admin_receipt_pdf[note2]']->getValue(), $html);
        $this->assertContains($form['admin_receipt_pdf[note3]']->getValue(), $html);
    }

    /**
     * Order pdf download.
     */
    public function testDownloadIdInvalid()
    {
        /**
         * @var Client $client
         */
        $client = $this->client;

        $client->request('GET', $this->app->url('plugin_admin_receipt_pdf'));
        $this->assertTrue($client->getResponse()->isRedirect($this->app->url('admin_order')));
        /**
         * @var Crawler $crawler
         */
        $crawler = $client->followRedirect();

        $html = $crawler->filter('.alert')->html();
        $this->assertContains('注文番号がありません。', $html);
    }

    /**
     * Order pdf download.
     */
    public function testDownloadWithBadMethod()
    {
        $this->setExpectedException('Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException');
        /**
         * @var Client $client
         */
        $client = $this->client;

        $client->request('GET', $this->app->url('plugin_admin_receipt_pdf_download'));

        $this->assertTrue($this->hasFailed());
    }

    /**
     * Order pdf download.
     *
     * @param string $field
     * @param string $message
     *
     * @dataProvider dataDownloadMaxLengthProvider
     */
    public function testDownloadMaxLength($field, $message)
    {
        $Order = $this->createOrderForSearch();
        $orderId = $Order->getId();
        /**
         * @var Client $client
         */
        $client = $this->client;

        /**
         * @var Crawler $crawler
         */
        $crawler = $client->request('GET', $this->app->url('plugin_admin_receipt_pdf').'?ids'.$orderId.'=on');
        $html = $crawler->filter('.box-body')->html();
        $this->assertContains((string) $orderId, $html);
        $this->assertContains('お買上げ明細書(納品書)', $html);
        $this->assertContains('このたびはお買上げいただきありがとうございます。', $html);
        $this->assertContains('下記の内容にて納品させていただきます。', $html);
        $this->assertContains('ご確認くださいますよう、お願いいたします。', $html);

        $form = $this->getForm($crawler);
        /**
         * @var Generator $faker
         */
        $faker = $this->getFaker();
        $form["$field"] = $faker->text(1000);
        $crawler = $client->submit($form);

        $this->assertTrue($client->getResponse()->isSuccessful());
        $html = $crawler->filter('.box-body')->html();
        $this->assertContains($message, $html);
    }

    /**
     * Data provider for max length test.
     *
     * @return array
     */
    public function dataDownloadMaxLengthProvider()
    {
        return array(
            array('admin_receipt_pdf[title]', '値が長すぎます。50文字以内でなければなりません。'),
            array('admin_receipt_pdf[message1]', '値が長すぎます。30文字以内でなければなりません。'),
            array('admin_receipt_pdf[message2]', '値が長すぎます。30文字以内でなければなりません。'),
            array('admin_receipt_pdf[message3]', '値が長すぎます。30文字以内でなければなりません。'),
            array('admin_receipt_pdf[note1]', '値が長すぎます。50文字以内でなければなりません。'),
            array('admin_receipt_pdf[note2]', '値が長すぎます。50文字以内でなければなりません。'),
            array('admin_receipt_pdf[note3]', '値が長すぎます。50文字以内でなければなりません。'),
        );
    }

    /**
     * Order pdf download.
     */
    public function testDownloadSuccess()
    {
        $Order = $this->createOrderForSearch();
        $orderId = $Order->getId();
        /**
         * @var Client $client
         */
        $client = $this->client;

        /**
         * @var Crawler $crawler
         */
        $crawler = $client->request('GET', $this->app->url('plugin_admin_receipt_pdf').'?ids'.$orderId.'=on');
        $html = $crawler->filter('.box-body')->html();
        $this->assertContains((string) $orderId, $html);
        $this->assertContains('お買上げ明細書(納品書)', $html);
        $this->assertContains('このたびはお買上げいただきありがとうございます。', $html);
        $this->assertContains('下記の内容にて納品させていただきます。', $html);
        $this->assertContains('ご確認くださいますよう、お願いいたします。', $html);

        $form = $this->getForm($crawler);
        $client->submit($form);

        $this->actual = $client->getResponse()->headers->get('Content-Type');
        $this->expected = 'application/pdf';
        $this->verify();
    }

    /**
     * Render order pdf download.
     */
    public function testDownloadWithPreviousInputSuccess()
    {
        $Order = $this->createOrderForSearch();
        $orderId = $Order->getId();
        /**
         * @var Client $client
         */
        $client = $this->client;

        /**
         * @var Generator $faker
         */
        $faker = $this->getFaker();
        $ReceiptPdf = new ReceiptPdf();
        $Admin = $this->app->user();
        $mid = 2; // member default id.
        if ($Admin instanceof Member) {
            $mid = $Admin->getId();
        }

        $ReceiptPdf->setId($mid)
            ->setIssueDate(new \DateTime())
            ->setTitle($faker->text(50))
            ->setMessage1($faker->text(30))
            ->setMessage2($faker->text(30))
            ->setMessage3($faker->text(30))
            ->setNote1($faker->text(50))
            ->setNote2($faker->text(50))
            ->setNote3($faker->text(50))
            ->setDelFlg(Constant::DISABLED);

        $this->app['orm.em']->persist($ReceiptPdf);
        $this->app['orm.em']->flush($ReceiptPdf);

        $crawler = $client->request('GET', $this->app->url('plugin_admin_receipt_pdf').'?ids'.$orderId.'=on');
        $html = $crawler->filter('.box-body')->html();

        $this->assertContains((string) $orderId, $html);
        $this->assertContains($ReceiptPdf->getTitle(), $html);
        $this->assertContains($ReceiptPdf->getMessage1(), $html);
        $this->assertContains($ReceiptPdf->getMessage2(), $html);
        $this->assertContains($ReceiptPdf->getMessage3(), $html);
        $this->assertContains($ReceiptPdf->getNote1(), $html);
        $this->assertContains($ReceiptPdf->getNote2(), $html);
        $this->assertContains($ReceiptPdf->getNote3(), $html);

        $form = $this->getForm($crawler);
        $client->submit($form);

        $this->actual = $client->getResponse()->headers->get('Content-Type');
        $this->expected = 'application/pdf';
        $this->verify();
    }

    /**
     * @param Crawler $crawler
     *
     * @return \Symfony\Component\DomCrawler\Form
     */
    private function getForm(Crawler $crawler)
    {
        $form = $crawler->selectButton('この内容で作成する')->form();
        $form['admin_receipt_pdf[_token]'] = 'dummy';

        return $form;
    }

    /**
     * Create order data for search function.
     *
     * @return Order
     */
    private function createOrderForSearch()
    {
        $Customer = $this->createCustomer();
        $Order = $this->createOrder($Customer);
        $Status = $this->app['eccube.repository.order_status']->find(5);
        // Update order_date to show on search
        $this->app['eccube.repository.order']->changeStatus($Order->getId(), $Status);

        return $Order;
    }
}
