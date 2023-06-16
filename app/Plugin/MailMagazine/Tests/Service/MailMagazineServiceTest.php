<?php

namespace Plugin\MailMagazine\Tests\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Eccube\Entity\Master\Pref;
use Plugin\MailMagazine\Entity\MailMagazineSendHistory;
use Plugin\MailMagazine\Tests\AbstractMailMagazineTestCase;

class MailMagazineServiceTest extends AbstractMailMagazineTestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $mailer;

    /**
     * @var array
     */
    private $sentAddresses;

    public function setUp()
    {
        parent::setUp();
        $this->app['mailer'] = $this->mailer = $this->getMockBuilder('\Swift_Mailer')->disableOriginalConstructor()->getMock();
        $this->sentAddresses = array();
    }

    public function testGetHistoryFileName()
    {
        $dir = $this->app['config']['root_dir'].'/app/mail_magazine/';
        self::assertEquals($dir.'mail_magazine_in_1.txt', $this->mailMagazineService->getHistoryFileName(1));
        self::assertEquals($dir.'mail_magazine_in_2.txt', $this->mailMagazineService->getHistoryFileName(2));
        self::assertEquals($dir.'mail_magazine_in_1.txt', $this->mailMagazineService->getHistoryFileName(1, true));
        self::assertEquals($dir.'mail_magazine_out_2.txt', $this->mailMagazineService->getHistoryFileName(2, false));
    }

    public function testCreateMailMagazineHistory_履歴データができる()
    {
        $this->createMailmagaCustomer('1_create_mail_magazine_history@example.com', 'name01_1', 'name02_1');
        $this->createMailmagaCustomer('2_create_mail_magazine_history@example.com', 'name01_2', 'name02_2');
        $this->createMailmagaCustomer('3_create_mail_magazine_history@example.com', 'name01_3', 'name02_3');

        $expectedId = $this->mailMagazineService->createMailMagazineHistory(array(
            'pref' => null,
            'sex' => new ArrayCollection(),
            'customer_status' => new ArrayCollection(),
            'subject' => 'subject',
            'body' => 'body',
            'multi' => 'create_mail_magazine_history@example.com',
        ));

        /** @var MailMagazineSendHistory $actual */
        $actual = $this->mailMagazineSendHistoryRepository->find($expectedId);

        self::assertEquals('subject', $actual->getSubject());
        self::assertEquals('body', $actual->getBody());
        self::assertEquals(3, $actual->getSendCount());
        self::assertEquals(0, $actual->getCompleteCount());
    }

    public function testCreateMailMagazineHistory_履歴ファイルができる()
    {
        $c1 = $this->createMailmagaCustomer('1_create_mail_magazine_history@example.com', 'name01_1', 'name02_1');
        $c2 = $this->createMailmagaCustomer('2_create_mail_magazine_history@example.com', 'name01_2', 'name02_2');
        $c3 = $this->createMailmagaCustomer('3_create_mail_magazine_history@example.com', 'name01_3', 'name02_3');

        $actualId = $this->mailMagazineService->createMailMagazineHistory(array(
            'pref' => null,
            'sex' => new ArrayCollection(),
            'customer_status' => new ArrayCollection(),
            'subject' => 'subject',
            'body' => 'body',
            'multi' => 'create_mail_magazine_history@example.com',
        ));

        $fileName = $this->mailMagazineService->getHistoryFileName($actualId);

        self::assertTrue(file_exists($fileName));

        $expected = '0,'.$c1->getId().',1_create_mail_magazine_history@example.com,name01_1 name02_1'.PHP_EOL.
                    '0,'.$c2->getId().',2_create_mail_magazine_history@example.com,name01_2 name02_2'.PHP_EOL.
                    '0,'.$c3->getId().',3_create_mail_magazine_history@example.com,name01_3 name02_3'.PHP_EOL;

        self::assertEquals($expected, file_get_contents($fileName));
    }

    public function testSendrMailMagazine_送信成功時に送信完了件数が更新される()
    {
        $historyId = $this->createHistory($this->createMailmagaCustomer());
        $this->setUpMailerStub(array(true));

        $history = $this->mailMagazineSendHistoryRepository->find($historyId);
        self::assertEquals(0, $history->getCompleteCount());

        $this->mailMagazineService->sendrMailMagazine($historyId);

        /** @var MailMagazineSendHistory $history */
        $history = $this->mailMagazineSendHistoryRepository->find($historyId);
        self::assertEquals(1, $history->getCompleteCount());
    }

    public function testSendrMailMagazine_送信成功時に結果ファイルが作成される()
    {
        $customer = $this->createMailmagaCustomer('sendr_mail_magazine@example.com', 'name01', 'name02');
        $historyId = $this->createHistory($customer);
        $this->setUpMailerStub(array(true));

        $this->mailMagazineService->sendrMailMagazine($historyId);

        $fileName = $this->mailMagazineService->getHistoryFileName($historyId, false);
        self::assertEquals('1,'.$customer->getId().',sendr_mail_magazine@example.com,name01 name02'.PHP_EOL, file_get_contents($fileName));
    }

    public function testSendrMailMagazine_送信成功時に配信ファイルが削除される()
    {
        $historyId = $this->createHistory($this->createMailmagaCustomer());
        $this->setUpMailerStub(array(true));

        self::assertTrue(file_exists($this->mailMagazineService->getHistoryFileName($historyId)));

        $this->mailMagazineService->sendrMailMagazine($historyId);

        self::assertFalse(file_exists($this->mailMagazineService->getHistoryFileName($historyId)));
    }

    public function testSendrMailMagazine_送信失敗時にも送信完了件数が更新される()
    {
        $historyId = $this->createHistory($this->createMailmagaCustomer());
        $this->setUpMailerStub(array(false));

        $history = $this->mailMagazineSendHistoryRepository->find($historyId);
        self::assertEquals(0, $history->getCompleteCount());

        $this->mailMagazineService->sendrMailMagazine($historyId);

        /** @var MailMagazineSendHistory $history */
        $history = $this->mailMagazineSendHistoryRepository->find($historyId);
        self::assertEquals(1, $history->getCompleteCount());
    }

    public function testSendrMailMagazine_送信失敗時に結果ファイルが作成される()
    {
        $customer = $this->createMailmagaCustomer('sendr_mail_magazine@example.com', 'name01', 'name02');
        $historyId = $this->createHistory($customer);
        $this->setUpMailerStub(array(false));

        $this->mailMagazineService->sendrMailMagazine($historyId);

        $fileName = $this->mailMagazineService->getHistoryFileName($historyId, false);
        self::assertEquals('2,'.$customer->getId().',sendr_mail_magazine@example.com,name01 name02'.PHP_EOL, file_get_contents($fileName));
    }

    public function testSendrMailMagazine_送信失敗時に配信ファイルが削除される()
    {
        $historyId = $this->createHistory($this->createMailmagaCustomer());
        $this->setUpMailerStub(array(false));

        self::assertTrue(file_exists($this->mailMagazineService->getHistoryFileName($historyId)));

        $this->mailMagazineService->sendrMailMagazine($historyId);

        self::assertFalse(file_exists($this->mailMagazineService->getHistoryFileName($historyId)));
    }

    public function testSendrMailMagazine_成功していたメールは再送できない()
    {
        $this->setUpMailerStub(array(true));
        $historyId = $this->createHistory($this->createMailmagaCustomer());

        $this->mailMagazineService->sendrMailMagazine($historyId);
        $this->mailMagazineService->markRetry($historyId);
        $this->mailMagazineService->sendrMailMagazine($historyId);

        self::assertEquals(array('mail_magazine_service_test@example.com'), $this->sentAddresses);
    }

    public function testSendrMailMagazine_失敗したメールは再送できる()
    {
        $this->setUpMailerStub(array(false, true));
        $historyId = $this->createHistory($this->createMailmagaCustomer());

        $this->mailMagazineService->sendrMailMagazine($historyId);

        self::assertEquals(array(
            'mail_magazine_service_test@example.com',
        ), $this->sentAddresses);

        $this->mailMagazineService->markRetry($historyId);
        $this->mailMagazineService->sendrMailMagazine($historyId);

        self::assertEquals(array(
            'mail_magazine_service_test@example.com',
            'mail_magazine_service_test@example.com',
        ), $this->sentAddresses);
    }

    public function testSendrMailMagazine_未配信メールを再送できる()
    {
        // 3件分の履歴を作成
        $c1 = $this->createMailmagaCustomer('1_create_mail_magazine_history@example.com', 'name01_1', 'name02_1');
        $c2 = $this->createMailmagaCustomer('2_create_mail_magazine_history@example.com', 'name01_2', 'name02_2');
        $c3 = $this->createMailmagaCustomer('3_create_mail_magazine_history@example.com', 'name01_3', 'name02_3');

        $historyId = $this->mailMagazineService->createMailMagazineHistory(array(
            'pref' => null,
            'sex' => new ArrayCollection(),
            'customer_status' => new ArrayCollection(),
            'subject' => 'subject',
            'body' => 'body',
            'multi' => 'create_mail_magazine_history@example.com',
        ));

        // 1件だけ送れたことにする
        $resultFile = $this->mailMagazineService->getHistoryFileName($historyId, false);
        file_put_contents($resultFile, '1,'.$c1->getId().',1_create_mail_magazine_history@example.com,name01_1 name02_1'.PHP_EOL);

        $this->setUpMailerStub(array(true, true));

        // 再送
        $this->mailMagazineService->markRetry($historyId);
        $this->mailMagazineService->sendrMailMagazine($historyId);

        // 未配信のアドレスに対してメールが送られるはず
        self::assertEquals(array(
            '2_create_mail_magazine_history@example.com',
            '3_create_mail_magazine_history@example.com',
        ), $this->sentAddresses);

        // 結果ファイルは3件分あるはず
        $expected = '1,'.$c1->getId().',1_create_mail_magazine_history@example.com,name01_1 name02_1'.PHP_EOL.
                    '1,'.$c2->getId().',2_create_mail_magazine_history@example.com,name01_2 name02_2'.PHP_EOL.
                    '1,'.$c3->getId().',3_create_mail_magazine_history@example.com,name01_3 name02_3'.PHP_EOL;
        self::assertEquals($expected, file_get_contents($resultFile));
    }

    public function testSendrMailMagazine_10件中最初の5件だけメールを送れる()
    {
        $customers = array(
            $this->createMailmagaCustomer('0_create_mail_magazine_history@example.com', 'name01_0', 'name02_0'),
            $this->createMailmagaCustomer('1_create_mail_magazine_history@example.com', 'name01_1', 'name02_1'),
            $this->createMailmagaCustomer('2_create_mail_magazine_history@example.com', 'name01_2', 'name02_2'),
            $this->createMailmagaCustomer('3_create_mail_magazine_history@example.com', 'name01_3', 'name02_3'),
            $this->createMailmagaCustomer('4_create_mail_magazine_history@example.com', 'name01_4', 'name02_4'),
            $this->createMailmagaCustomer('5_create_mail_magazine_history@example.com', 'name01_5', 'name02_5'),
            $this->createMailmagaCustomer('6_create_mail_magazine_history@example.com', 'name01_6', 'name02_6'),
            $this->createMailmagaCustomer('7_create_mail_magazine_history@example.com', 'name01_7', 'name02_7'),
            $this->createMailmagaCustomer('8_create_mail_magazine_history@example.com', 'name01_8', 'name02_8'),
            $this->createMailmagaCustomer('9_create_mail_magazine_history@example.com', 'name01_9', 'name02_9'),
        );

        $historyId = $this->mailMagazineService->createMailMagazineHistory(array(
            'pref' => null,
            'sex' => new ArrayCollection(),
            'customer_status' => new ArrayCollection(),
            'subject' => 'subject',
            'body' => 'body',
            'multi' => 'create_mail_magazine_history@example.com',
        ));

        $this->setUpMailerStub(array(true, true, true, true, true));

        // 最初の5件だけ送信
        $this->mailMagazineService->sendrMailMagazine($historyId, 0, 5);

        // 5件だけメールが送られるはず
        self::assertEquals(array(
            '0_create_mail_magazine_history@example.com',
            '1_create_mail_magazine_history@example.com',
            '2_create_mail_magazine_history@example.com',
            '3_create_mail_magazine_history@example.com',
            '4_create_mail_magazine_history@example.com',
        ), $this->sentAddresses);

        // 結果ファイルは5件分あるはず
        $resultFile = $this->mailMagazineService->getHistoryFileName($historyId, false);
        $expected = '1,'.$customers[0]->getId().',0_create_mail_magazine_history@example.com,name01_0 name02_0'.PHP_EOL.
                    '1,'.$customers[1]->getId().',1_create_mail_magazine_history@example.com,name01_1 name02_1'.PHP_EOL.
                    '1,'.$customers[2]->getId().',2_create_mail_magazine_history@example.com,name01_2 name02_2'.PHP_EOL.
                    '1,'.$customers[3]->getId().',3_create_mail_magazine_history@example.com,name01_3 name02_3'.PHP_EOL.
                    '1,'.$customers[4]->getId().',4_create_mail_magazine_history@example.com,name01_4 name02_4'.PHP_EOL;
        self::assertEquals($expected, file_get_contents($resultFile));
    }

    public function testSendrMailMagazine_10件中最初の6件目から10件目までメールを送れる()
    {
        $customers = array(
            $this->createMailmagaCustomer('0_create_mail_magazine_history@example.com', 'name01_0', 'name02_0'),
            $this->createMailmagaCustomer('1_create_mail_magazine_history@example.com', 'name01_1', 'name02_1'),
            $this->createMailmagaCustomer('2_create_mail_magazine_history@example.com', 'name01_2', 'name02_2'),
            $this->createMailmagaCustomer('3_create_mail_magazine_history@example.com', 'name01_3', 'name02_3'),
            $this->createMailmagaCustomer('4_create_mail_magazine_history@example.com', 'name01_4', 'name02_4'),
            $this->createMailmagaCustomer('5_create_mail_magazine_history@example.com', 'name01_5', 'name02_5'),
            $this->createMailmagaCustomer('6_create_mail_magazine_history@example.com', 'name01_6', 'name02_6'),
            $this->createMailmagaCustomer('7_create_mail_magazine_history@example.com', 'name01_7', 'name02_7'),
            $this->createMailmagaCustomer('8_create_mail_magazine_history@example.com', 'name01_8', 'name02_8'),
            $this->createMailmagaCustomer('9_create_mail_magazine_history@example.com', 'name01_9', 'name02_9'),
        );

        $historyId = $this->mailMagazineService->createMailMagazineHistory(array(
            'pref' => null,
            'sex' => new ArrayCollection(),
            'customer_status' => new ArrayCollection(),
            'subject' => 'subject',
            'body' => 'body',
            'multi' => 'create_mail_magazine_history@example.com',
        ));

        $this->setUpMailerStub(array_fill(0, 10, true));

        // 最初の5件だけ送信
        $this->mailMagazineService->sendrMailMagazine($historyId, 0, 5);

        // 5件だけメールが送られるはず
        self::assertEquals(array(
            '0_create_mail_magazine_history@example.com',
            '1_create_mail_magazine_history@example.com',
            '2_create_mail_magazine_history@example.com',
            '3_create_mail_magazine_history@example.com',
            '4_create_mail_magazine_history@example.com',
        ), $this->sentAddresses);

        // 結果ファイルは5件分あるはず
        $resultFile = $this->mailMagazineService->getHistoryFileName($historyId, false);
        $expected = '1,'.$customers[0]->getId().',0_create_mail_magazine_history@example.com,name01_0 name02_0'.PHP_EOL.
                    '1,'.$customers[1]->getId().',1_create_mail_magazine_history@example.com,name01_1 name02_1'.PHP_EOL.
                    '1,'.$customers[2]->getId().',2_create_mail_magazine_history@example.com,name01_2 name02_2'.PHP_EOL.
                    '1,'.$customers[3]->getId().',3_create_mail_magazine_history@example.com,name01_3 name02_3'.PHP_EOL.
                    '1,'.$customers[4]->getId().',4_create_mail_magazine_history@example.com,name01_4 name02_4'.PHP_EOL;
        self::assertEquals($expected, file_get_contents($resultFile));

        // 6件目から10件目まで送信
        $this->mailMagazineService->sendrMailMagazine($historyId, 5, 5);

        // 6件目から10件目までメールが送られるはず
        self::assertEquals(array(
            '0_create_mail_magazine_history@example.com',
            '1_create_mail_magazine_history@example.com',
            '2_create_mail_magazine_history@example.com',
            '3_create_mail_magazine_history@example.com',
            '4_create_mail_magazine_history@example.com',
            '5_create_mail_magazine_history@example.com',
            '6_create_mail_magazine_history@example.com',
            '7_create_mail_magazine_history@example.com',
            '8_create_mail_magazine_history@example.com',
            '9_create_mail_magazine_history@example.com',
        ), $this->sentAddresses);

        $resultFile = $this->mailMagazineService->getHistoryFileName($historyId, false);
        $expected = '1,'.$customers[0]->getId().',0_create_mail_magazine_history@example.com,name01_0 name02_0'.PHP_EOL.
                    '1,'.$customers[1]->getId().',1_create_mail_magazine_history@example.com,name01_1 name02_1'.PHP_EOL.
                    '1,'.$customers[2]->getId().',2_create_mail_magazine_history@example.com,name01_2 name02_2'.PHP_EOL.
                    '1,'.$customers[3]->getId().',3_create_mail_magazine_history@example.com,name01_3 name02_3'.PHP_EOL.
                    '1,'.$customers[4]->getId().',4_create_mail_magazine_history@example.com,name01_4 name02_4'.PHP_EOL.
                    '1,'.$customers[5]->getId().',5_create_mail_magazine_history@example.com,name01_5 name02_5'.PHP_EOL.
                    '1,'.$customers[6]->getId().',6_create_mail_magazine_history@example.com,name01_6 name02_6'.PHP_EOL.
                    '1,'.$customers[7]->getId().',7_create_mail_magazine_history@example.com,name01_7 name02_7'.PHP_EOL.
                    '1,'.$customers[8]->getId().',8_create_mail_magazine_history@example.com,name01_8 name02_8'.PHP_EOL.
                    '1,'.$customers[9]->getId().',9_create_mail_magazine_history@example.com,name01_9 name02_9'.PHP_EOL;
        self::assertEquals($expected, file_get_contents($resultFile));
    }

    public function testSendrMailMagazine_未送信がある状態で再送処理をせずに送信する()
    {
        // 10件分の履歴
        $customers = array(
            $this->createMailmagaCustomer('0_create_mail_magazine_history@example.com', 'name01_0', 'name02_0'),
            $this->createMailmagaCustomer('1_create_mail_magazine_history@example.com', 'name01_1', 'name02_1'),
            $this->createMailmagaCustomer('2_create_mail_magazine_history@example.com', 'name01_2', 'name02_2'),
            $this->createMailmagaCustomer('3_create_mail_magazine_history@example.com', 'name01_3', 'name02_3'),
            $this->createMailmagaCustomer('4_create_mail_magazine_history@example.com', 'name01_4', 'name02_4'),
            $this->createMailmagaCustomer('5_create_mail_magazine_history@example.com', 'name01_5', 'name02_5'),
            $this->createMailmagaCustomer('6_create_mail_magazine_history@example.com', 'name01_6', 'name02_6'),
            $this->createMailmagaCustomer('7_create_mail_magazine_history@example.com', 'name01_7', 'name02_7'),
            $this->createMailmagaCustomer('8_create_mail_magazine_history@example.com', 'name01_8', 'name02_8'),
            $this->createMailmagaCustomer('9_create_mail_magazine_history@example.com', 'name01_9', 'name02_9'),
        );

        $historyId = $this->mailMagazineService->createMailMagazineHistory(array(
            'pref' => null,
            'sex' => new ArrayCollection(),
            'customer_status' => new ArrayCollection(),
            'subject' => 'subject',
            'body' => 'body',
            'multi' => 'create_mail_magazine_history@example.com',
        ));

        $this->setUpMailerStub(array_fill(0, 10, true));

        /*
         * 5件送信
         */
        $this->mailMagazineService->sendrMailMagazine($historyId, 0, 5);

        // ここでは5件送信される
        self::assertEquals(array(
            '0_create_mail_magazine_history@example.com',
            '1_create_mail_magazine_history@example.com',
            '2_create_mail_magazine_history@example.com',
            '3_create_mail_magazine_history@example.com',
            '4_create_mail_magazine_history@example.com',
        ), $this->sentAddresses);

        // 結果ファイルは5件
        $resultFile = $this->mailMagazineService->getHistoryFileName($historyId, false);
        $expected = '1,'.$customers[0]->getId().',0_create_mail_magazine_history@example.com,name01_0 name02_0'.PHP_EOL.
                    '1,'.$customers[1]->getId().',1_create_mail_magazine_history@example.com,name01_1 name02_1'.PHP_EOL.
                    '1,'.$customers[2]->getId().',2_create_mail_magazine_history@example.com,name01_2 name02_2'.PHP_EOL.
                    '1,'.$customers[3]->getId().',3_create_mail_magazine_history@example.com,name01_3 name02_3'.PHP_EOL.
                    '1,'.$customers[4]->getId().',4_create_mail_magazine_history@example.com,name01_4 name02_4'.PHP_EOL;
        self::assertEquals($expected, file_get_contents($resultFile));

        /*
         * 本来なら再送処理(markRetury)をしてから送信するが、
         * history.backなどで、再送処理をせずにもう一度送信処理が行われた場合を想定
         */
        $this->mailMagazineService->sendrMailMagazine($historyId, 0, 5);

        // メールは新しく送られないはず
        self::assertEquals(array(
            '0_create_mail_magazine_history@example.com',
            '1_create_mail_magazine_history@example.com',
            '2_create_mail_magazine_history@example.com',
            '3_create_mail_magazine_history@example.com',
            '4_create_mail_magazine_history@example.com',
        ), $this->sentAddresses);

        $resultFile = $this->mailMagazineService->getHistoryFileName($historyId, false);

        // 結果ファイルは5件のまま
        $expected = '1,'.$customers[0]->getId().',0_create_mail_magazine_history@example.com,name01_0 name02_0'.PHP_EOL.
                    '1,'.$customers[1]->getId().',1_create_mail_magazine_history@example.com,name01_1 name02_1'.PHP_EOL.
                    '1,'.$customers[2]->getId().',2_create_mail_magazine_history@example.com,name01_2 name02_2'.PHP_EOL.
                    '1,'.$customers[3]->getId().',3_create_mail_magazine_history@example.com,name01_3 name02_3'.PHP_EOL.
                    '1,'.$customers[4]->getId().',4_create_mail_magazine_history@example.com,name01_4 name02_4'.PHP_EOL;
        self::assertEquals($expected, file_get_contents($resultFile));

        /*
         * 6件目から10件目まで送信
         */
        $this->mailMagazineService->sendrMailMagazine($historyId, 5, 5);

        // 新たに6件目から10件目までメールが送られるはず
        self::assertEquals(array(
            '0_create_mail_magazine_history@example.com',
            '1_create_mail_magazine_history@example.com',
            '2_create_mail_magazine_history@example.com',
            '3_create_mail_magazine_history@example.com',
            '4_create_mail_magazine_history@example.com',
            '5_create_mail_magazine_history@example.com',
            '6_create_mail_magazine_history@example.com',
            '7_create_mail_magazine_history@example.com',
            '8_create_mail_magazine_history@example.com',
            '9_create_mail_magazine_history@example.com',
        ), $this->sentAddresses);

        $expected = '1,'.$customers[0]->getId().',0_create_mail_magazine_history@example.com,name01_0 name02_0'.PHP_EOL.
                    '1,'.$customers[1]->getId().',1_create_mail_magazine_history@example.com,name01_1 name02_1'.PHP_EOL.
                    '1,'.$customers[2]->getId().',2_create_mail_magazine_history@example.com,name01_2 name02_2'.PHP_EOL.
                    '1,'.$customers[3]->getId().',3_create_mail_magazine_history@example.com,name01_3 name02_3'.PHP_EOL.
                    '1,'.$customers[4]->getId().',4_create_mail_magazine_history@example.com,name01_4 name02_4'.PHP_EOL.
                    '1,'.$customers[5]->getId().',5_create_mail_magazine_history@example.com,name01_5 name02_5'.PHP_EOL.
                    '1,'.$customers[6]->getId().',6_create_mail_magazine_history@example.com,name01_6 name02_6'.PHP_EOL.
                    '1,'.$customers[7]->getId().',7_create_mail_magazine_history@example.com,name01_7 name02_7'.PHP_EOL.
                    '1,'.$customers[8]->getId().',8_create_mail_magazine_history@example.com,name01_8 name02_8'.PHP_EOL.
                    '1,'.$customers[9]->getId().',9_create_mail_magazine_history@example.com,name01_9 name02_9'.PHP_EOL;
        self::assertEquals($expected, file_get_contents($resultFile));

        /** @var MailMagazineSendHistory $history */
        $history = $this->mailMagazineSendHistoryRepository->find($historyId);
        self::assertEquals(10, $history->getCompleteCount());
    }

    public function testSendrMailMagazine_エラーがあった場合はエラー数を履歴に保持する()
    {
        $this->createMailmagaCustomer('0_create_mail_magazine_history@example.com', 'name01_0', 'name02_0');
        $this->createMailmagaCustomer('1_create_mail_magazine_history@example.com', 'name01_1', 'name02_1');
        $this->createMailmagaCustomer('2_create_mail_magazine_history@example.com', 'name01_2', 'name02_2');
        $this->createMailmagaCustomer('3_create_mail_magazine_history@example.com', 'name01_3', 'name02_3');
        $this->createMailmagaCustomer('4_create_mail_magazine_history@example.com', 'name01_4', 'name02_4');
        $this->createMailmagaCustomer('5_create_mail_magazine_history@example.com', 'name01_5', 'name02_5');
        $this->createMailmagaCustomer('6_create_mail_magazine_history@example.com', 'name01_6', 'name02_6');
        $this->createMailmagaCustomer('7_create_mail_magazine_history@example.com', 'name01_7', 'name02_7');
        $this->createMailmagaCustomer('8_create_mail_magazine_history@example.com', 'name01_8', 'name02_8');
        $this->createMailmagaCustomer('9_create_mail_magazine_history@example.com', 'name01_9', 'name02_9');
        $this->createMailmagaCustomer('a_create_mail_magazine_history@example.com', 'name01_a', 'name02_a');
        $this->createMailmagaCustomer('b_create_mail_magazine_history@example.com', 'name01_b', 'name02_b');
        $this->createMailmagaCustomer('c_create_mail_magazine_history@example.com', 'name01_c', 'name02_c');
        $this->createMailmagaCustomer('d_create_mail_magazine_history@example.com', 'name01_d', 'name02_d');
        $this->createMailmagaCustomer('e_create_mail_magazine_history@example.com', 'name01_e', 'name02_e');

        $historyId = $this->mailMagazineService->createMailMagazineHistory(array(
            'pref' => null,
            'sex' => new ArrayCollection(),
            'customer_status' => new ArrayCollection(),
            'subject' => 'subject',
            'body' => 'body',
            'multi' => 'create_mail_magazine_history@example.com',
        ));

        $this->setUpMailerStub(array(
            true, false, false, true, false,
            true, true,  false, true, false,
            true, true,  true,  true, false,
        ));

        /*
         * 5件送信
         */
        $this->mailMagazineService->sendrMailMagazine($historyId, 0, 5);

        /** @var MailMagazineSendHistory $history */
        $history = $this->mailMagazineSendHistoryRepository->find($historyId);
        self::assertEquals(15, $history->getSendCount());
        self::assertEquals(5, $history->getCompleteCount());
        self::assertEquals(3, $history->getErrorCount());

        /*
         * 5件送信
         */
        $this->mailMagazineService->sendrMailMagazine($historyId, 5, 5);

        /** @var MailMagazineSendHistory $history */
        $history = $this->mailMagazineSendHistoryRepository->find($historyId);
        self::assertEquals(15, $history->getSendCount());
        self::assertEquals(10, $history->getCompleteCount());
        self::assertEquals(5, $history->getErrorCount());

        /*
         * 5件送信
         */
        $this->mailMagazineService->sendrMailMagazine($historyId, 10, 5);

        /** @var MailMagazineSendHistory $history */
        $history = $this->mailMagazineSendHistoryRepository->find($historyId);
        self::assertEquals(15, $history->getSendCount());
        self::assertEquals(15, $history->getCompleteCount());
        self::assertEquals(6, $history->getErrorCount());
    }

    public function testSendrMailMagazine_再送してもエラー数を正しく履歴に保持する()
    {
        $this->createMailmagaCustomer('0_create_mail_magazine_history@example.com', 'name01_0', 'name02_0');
        $this->createMailmagaCustomer('1_create_mail_magazine_history@example.com', 'name01_1', 'name02_1');
        $this->createMailmagaCustomer('2_create_mail_magazine_history@example.com', 'name01_2', 'name02_2');
        $this->createMailmagaCustomer('3_create_mail_magazine_history@example.com', 'name01_3', 'name02_3');
        $this->createMailmagaCustomer('4_create_mail_magazine_history@example.com', 'name01_4', 'name02_4');
        $this->createMailmagaCustomer('5_create_mail_magazine_history@example.com', 'name01_5', 'name02_5');
        $this->createMailmagaCustomer('6_create_mail_magazine_history@example.com', 'name01_6', 'name02_6');
        $this->createMailmagaCustomer('7_create_mail_magazine_history@example.com', 'name01_7', 'name02_7');
        $this->createMailmagaCustomer('8_create_mail_magazine_history@example.com', 'name01_8', 'name02_8');
        $this->createMailmagaCustomer('9_create_mail_magazine_history@example.com', 'name01_9', 'name02_9');
        $this->createMailmagaCustomer('a_create_mail_magazine_history@example.com', 'name01_a', 'name02_a');
        $this->createMailmagaCustomer('b_create_mail_magazine_history@example.com', 'name01_b', 'name02_b');
        $this->createMailmagaCustomer('c_create_mail_magazine_history@example.com', 'name01_c', 'name02_c');
        $this->createMailmagaCustomer('d_create_mail_magazine_history@example.com', 'name01_d', 'name02_d');
        $this->createMailmagaCustomer('e_create_mail_magazine_history@example.com', 'name01_e', 'name02_e');

        $historyId = $this->mailMagazineService->createMailMagazineHistory(array(
            'pref' => null,
            'sex' => new ArrayCollection(),
            'customer_status' => new ArrayCollection(),
            'subject' => 'subject',
            'body' => 'body',
            'multi' => 'create_mail_magazine_history@example.com',
        ));

        $this->setUpMailerStub(array(
            true, false, false, true, false,
            true, false, false,
        ));

        /*
         * 5件送信
         */
        $this->mailMagazineService->sendrMailMagazine($historyId, 0, 5);

        /** @var MailMagazineSendHistory $history */
        $history = $this->mailMagazineSendHistoryRepository->find($historyId);
        self::assertEquals(15, $history->getSendCount());
        self::assertEquals(5, $history->getCompleteCount());
        self::assertEquals(3, $history->getErrorCount());

        /*
         * 再送
         */
        $this->mailMagazineService->sendrMailMagazine($historyId, 0, 5);

        /** @var MailMagazineSendHistory $history */
        $history = $this->mailMagazineSendHistoryRepository->find($historyId);
        self::assertEquals(15, $history->getSendCount());
        self::assertEquals(5, $history->getCompleteCount());
        self::assertEquals(2, $history->getErrorCount());
    }

    /**
     * メーラのスタブを設定。
     * 引数の順番でメールの送信結果を返す。
     * [false, true] なら最初のメール送信は失敗、2通目のメール送信は成功。
     *
     * @param array|$arrayOfReturn メール送信結果の配列
     */
    private function setUpMailerStub($arrayOfReturn)
    {
        $stack = &$this->sentAddresses;
        $this->mailer->expects($this->exactly(count($arrayOfReturn)))->method('send')->with(
            $this->callback(function ($message) use (&$stack) {
                $stack[] = current(array_keys($message->getTo()));

                return true;
            })
        )->will(new \PHPUnit_Framework_MockObject_Stub_ConsecutiveCalls($arrayOfReturn));
    }
}
