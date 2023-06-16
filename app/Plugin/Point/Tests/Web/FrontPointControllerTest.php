<?php

namespace Eccube\Tests\Web;

use Eccube\Common\Constant;
use Eccube\Event\EventArgs;
use Eccube\Tests\Web\AbstractWebTestCase;
use Plugin\Point\Event\WorkPlace\AdminOrder;
use Plugin\Point\Entity\PointInfo;
use Plugin\Point\Tests\Util\PointTestUtil;

/**
 * @see ShoppingControllerTest
 */
class FrontPointControllerTest extends AbstractWebTestCase
{

    protected $Customer;

    public function setUp()
    {
        parent::setUp();
        $this->BaseInfo = $this->app['eccube.repository.base_info']->get();
        $this->Customer = $this->createCustomer();
        $this->initializeMailCatcher();
    }

    public function tearDown()
    {
        $this->cleanUpMailCatcherMessages();
        parent::tearDown();
    }

    /**
     * カート画面のテストケース.
     */
    public function testPointCart()
    {
        $currentPoint = 1000000;

        $faker = $this->getFaker();
        $Customer = $this->logIn();
        $client = $this->client;

        // 保有ポイントを設定する
        PointTestUtil::saveCustomerPoint($Customer, $currentPoint, $this->app);

        // カート画面
        $this->scenarioCartIn($client);

        $crawler = $client->request('GET', '/cart');
        $this->assertRegExp('/現在の保有ポイントは「'.number_format($currentPoint).' pt」です。/u', $crawler->filter('#cart_item__point_info')->text());
    }

    /**
     * ポイントを使用しないテストケース.
     */
    public function testPointShopping()
    {
        $faker = $this->getFaker();
        $Customer = $this->logIn();
        $client = $this->client;

        // カート画面
        $this->scenarioCartIn($client);

        // 確認画面
        $crawler = $this->scenarioConfirm($client);
        $this->expected = 'ご注文内容のご確認';
        $this->actual = $crawler->filter('h1.page-heading')->text();
        $this->verify();

        // 完了画面
        $crawler = $this->scenarioComplete($client, $this->app->path('shopping_confirm'));
        $this->assertTrue($client->getResponse()->isRedirect($this->app->url('shopping_complete')));

        $Messages = $this->getMailCatcherMessages();
        $Message = $this->getMailCatcherMessage($Messages[0]->id);

        $this->expected = '[' . $this->BaseInfo->getShopName() . '] ご注文ありがとうございます';
        $this->actual = $Message->subject;
        $this->verify();

        $body = $this->parseMailCatcherSource($Message);
        $this->assertRegexp('/利用ポイント：0 pt/u', $body);
        $this->assertRegexp('/加算ポイント：1,100 pt/u', $body);

        // 生成された受注のチェック
        $Order = $this->app['eccube.repository.order']->findOneBy(
            array(
                'Customer' => $Customer
            )
        );

        $this->expected = $Customer->getName01();
        $this->actual = $Order->getName01();
        $this->verify();

        $Points = $this->app['eccube.plugin.point.repository.point']->findBy(array(
            'Customer' => $Customer,
            'Order' => $Order
        ));
        $provisionalPoint = array_reduce(
            array_map(
                function ($Point) {
                    return $Point->getPlgDynamicPoint();
                }, $Points
            ),
            function ($carry, $item) {
                return $carry += $item;
            }
        );
        $this->expected = 1100;
        $this->actual = $provisionalPoint;
        $this->verify('仮ポイントの合計は '.$this->expected);
    }

    /**
     * ポイント利用のテストケース.
     */
    public function testUsePointShopping()
    {
        $currentPoint = 1000;   // 保有ポイント
        $usePoint = 100;        // 利用ポイント

        // ポイント確定ステータスを「発送済み」に設定
        $PointInfo = $this->app['eccube.plugin.point.repository.pointinfo']->getLastInsertData();
        $PointInfo->setPlgAddPointStatus($this->app['config']['order_deliv']);
        $this->app['orm.em']->flush();

        $faker = $this->getFaker();
        $Customer = $this->logIn();
        $client = $this->client;

        // 保有ポイントを設定する
        PointTestUtil::saveCustomerPoint($Customer, $currentPoint, $this->app);

        // カート画面
        $this->scenarioCartIn($client);

        // 確認画面
        $crawler = $this->scenarioConfirm($client);
        $this->expected = 'ご注文内容のご確認';
        $this->actual = $crawler->filter('h1.page-heading')->text();
        $this->verify();

        // ポイント利用画面
        $crawler = $client->request('GET', $this->app->path('point_use'));
        $this->assertRegexp(
            '/現在の保有ポイントは「'.number_format($currentPoint).' pt」です。/u',
            $crawler->filter('#detail_box')->text()
        );

        // ポイント利用処理
        $crawler = $this->scenarioUsePoint($client, $usePoint);
        $this->assertTrue($client->getResponse()->isRedirect($this->app->url('shopping')));

        // 完了画面
        $crawler = $this->scenarioComplete($client, $this->app->path('shopping_confirm'));
        $this->assertTrue($client->getResponse()->isRedirect($this->app->url('shopping_complete')));

        $Messages = $this->getMailCatcherMessages();
        $Message = $this->getMailCatcherMessage($Messages[0]->id);

        $this->expected = '[' . $this->BaseInfo->getShopName() . '] ご注文ありがとうございます';
        $this->actual = $Message->subject;
        $this->verify();

        $body = $this->parseMailCatcherSource($Message);

        $this->assertRegexp('/利用ポイント：'.$usePoint.' pt/u', $body);
        $this->assertRegexp('/加算ポイント：1,100 pt/u', $body);

        $this->expected = $currentPoint - $usePoint;
        $this->actual = PointTestUtil::calculateCurrentPoint($Customer, $this->app);
        $this->verify('保有ポイントの合計は '.$this->expected);
    }

    /**
     * ポイント利用のテストケース.
     *
     * 長期間利用した際のシナリオ
     * 1. 50回購入
     * 2. 1 のうち、25回ポイント確定
     * 3. 新たに 50回購入し、各100ポイントずつ利用する
     * 4. 2で確定しなかったポイントを確定
     */
    public function testLongUsePointShopping()
    {
        $addPoint = 1100;       // 1回の受注で加算されるポイント
        $purchaseNum = 50;     // 購入回数
        $usePoint = 100;        // 利用ポイント
        $discount = 100;        // 値引き額

        // ポイント確定ステータスを「発送済み」に設定
        $PointInfo = $this->app['eccube.plugin.point.repository.pointinfo']->getLastInsertData();
        $PointInfo->setPlgAddPointStatus($this->app['config']['order_deliv']);
        $this->app['orm.em']->flush();

        $Customer = $this->logIn();
        $client = $this->client;
        $calculator = $this->app['eccube.plugin.point.calculate.helper.factory'];
        $calculator->addEntity('Customer', $Customer);


        for ($i = 0; $i < $purchaseNum; $i++) {
            // カート画面
            $this->scenarioCartIn($client);
            // 確認画面
            $crawler = $this->scenarioConfirm($client);
            // 完了画面
            $crawler = $this->scenarioComplete($client, $this->app->path('shopping_confirm'));
        }

        $Orders = $this->app['eccube.repository.order']->findBy(array('Customer' => $Customer));
        $this->expected = $purchaseNum;
        $this->actual = count($Orders);
        $this->verify('購入回数は'.$purchaseNum.'回');

        $this->expected = 0;
        $this->actual = PointTestUtil::calculateCurrentPoint($Customer, $this->app);
        $this->verify('保有ポイントの合計は '.$this->expected);
        $OrderDeliv = $this->app['eccube.repository.order_status']->find($this->app['config']['order_deliv']);

        // 半分だけ受注ステータスを発送済みに更新
        $i = 0;
        $deliveryNum = 0;
        $orderNewIds = array(); // 新規受付の order_id
        foreach ($Orders as $Order) {
            if (($i % 2) === 0) {
                $Order->setOrderStatus($OrderDeliv);
                $this->app['orm.em']->flush($Order);

                $deliveryNum++;

                // ポイント確定
                $this->fixPoint($Order, $Customer);
            } else {
                $orderNewIds[] = $Order->getId();
            }
            $i++;
        }

        $this->expected = $addPoint * $deliveryNum;
        $this->actual = PointTestUtil::calculateCurrentPoint($Customer, $this->app);
        $this->verify('保有ポイントの合計は '.$this->expected);
        $currentPoint = $this->actual;


        $provisionalAddPoint = 0; // 仮ポイント確認用
        for ($i = 0; $i < $purchaseNum; $i++) {
            // カート画面
            $this->scenarioCartIn($client);
            // 確認画面
            $crawler = $this->scenarioConfirm($client);
            // ポイント利用処理
            $crawler = $this->scenarioUsePoint($client, $usePoint);
            // 完了画面
            $crawler = $this->scenarioComplete($client, $this->app->path('shopping_confirm'));
            $provisionalAddPoint += $addPoint;
        }

        $this->expected = $currentPoint - ($usePoint * $purchaseNum);
        $this->actual = PointTestUtil::calculateCurrentPoint($Customer, $this->app);
        $this->verify('保有ポイントの合計は '.$this->expected);
        $currentPoint = $this->expected;

        $deliveryNum2 = 0;
        foreach ($orderNewIds as $order_id) {
            $NewOrder = $this->app['eccube.repository.order']->find($order_id);
            $NewOrder->setOrderStatus($OrderDeliv);
            $this->app['orm.em']->flush($NewOrder);

            $deliveryNum2++;

            // ポイント確定
            $this->fixPoint($NewOrder, $Customer);
        }

        $this->expected = $currentPoint + ($addPoint * $deliveryNum2);
        $this->actual = PointTestUtil::calculateCurrentPoint($Customer, $this->app);
        $this->verify('保有ポイントの合計は '.$this->expected);

        $this->expected = $provisionalAddPoint;
        $this->actual = $calculator->getProvisionalAddPoint();
        $this->verify('現在の仮ポイント合計は '.$this->expected);
    }

    /**
     * ポイント利用(減算方式)のテストケース.
     *
     * 長期間利用した際のシナリオ
     * 1. 50回購入
     * 2. 1 のうち、25件ポイント確定
     * 3. 新たに 50回購入し、各100ポイントずつ利用する(減算方式)
     * 4. 2で確定しなかったポイントを確定
     * 5. 3の受注のうち25件ポイント確定、25件削除
     * 6. 3のポイント確定受注の利用・加算ポイントを変更する
     */
    public function testLongUsePointShoppingWithSubtraction()
    {
        $addPoint = 1100;       // 1回の受注で加算されるポイント
        $purchaseNum = 50;     // 購入回数
        $usePoint = 100;        // 利用ポイント
        $discount = 100;        // 値引き額

        // ポイント確定ステータスを「発送済み」に設定
        $PointInfo = $this->app['eccube.plugin.point.repository.pointinfo']->getLastInsertData();
        $PointInfo->setPlgAddPointStatus($this->app['config']['order_deliv']);
        // ポイント減算方式に設定
        $PointInfo->setPlgCalculationType(PointInfo::POINT_CALCULATE_SUBTRACTION);
        $this->app['orm.em']->flush();

        $Customer = $this->logIn();
        $client = $this->client;
        $calculator = $this->app['eccube.plugin.point.calculate.helper.factory'];
        $calculator->addEntity('Customer', $Customer);


        for ($i = 0; $i < $purchaseNum; $i++) {
            // カート画面
            $this->scenarioCartIn($client);
            // 確認画面
            $crawler = $this->scenarioConfirm($client);
            // 完了画面
            $crawler = $this->scenarioComplete($client, $this->app->path('shopping_confirm'));
        }

        $Orders = $this->app['eccube.repository.order']->findBy(array('Customer' => $Customer));
        $this->expected = $purchaseNum;
        $this->actual = count($Orders);
        $this->verify('購入回数は'.$purchaseNum.'回');

        $this->expected = 0;
        $this->actual = PointTestUtil::calculateCurrentPoint($Customer, $this->app);
        $this->verify('保有ポイントの合計は '.$this->expected);
        $OrderDeliv = $this->app['eccube.repository.order_status']->find($this->app['config']['order_deliv']);

        // 半分だけ受注ステータスを発送済みに更新
        $i = 0;
        $deliveryNum = 0;
        $orderNewIds = array(); // 新規受付の order_id
        foreach ($Orders as $Order) {
            if (($i % 2) === 0) {
                $Order->setOrderStatus($OrderDeliv);
                $this->app['orm.em']->flush($Order);

                $deliveryNum++;

                // ポイント確定
                $this->fixPoint($Order, $Customer);
            } else {
                $orderNewIds[] = $Order->getId();
            }
            $i++;
        }

        $this->expected = $addPoint * $deliveryNum;
        $this->actual = PointTestUtil::calculateCurrentPoint($Customer, $this->app);
        $this->verify('保有ポイントの合計は '.$this->expected);
        $currentPoint = $this->actual;


        $provisionalAddPoint = 0; // 仮ポイント確認用
        for ($i = 0; $i < $purchaseNum; $i++) {
            // カート画面
            $this->scenarioCartIn($client);
            // 確認画面
            $crawler = $this->scenarioConfirm($client);
            // ポイント利用処理
            $crawler = $this->scenarioUsePoint($client, $usePoint);
            // 完了画面
            $crawler = $this->scenarioComplete($client, $this->app->path('shopping_confirm'));
            $provisionalAddPoint += $addPoint - ($discount * ($PointInfo->getPlgBasicPointRate() / 100));

            // できるだけたくさんのデータでテストするため他の会員の受注を生成する
            $this->createOrder($this->createCustomer());
        }

        $this->expected = $currentPoint - ($usePoint * $purchaseNum);
        $this->actual = PointTestUtil::calculateCurrentPoint($Customer, $this->app);
        $this->verify('保有ポイントの合計は '.$this->expected);
        $currentPoint = $this->expected;

        $deliveryNum2 = 0;
        foreach ($orderNewIds as $order_id) {
            $NewOrder = $this->app['eccube.repository.order']->find($order_id);
            $NewOrder->setOrderStatus($OrderDeliv);
            $this->app['orm.em']->flush($NewOrder);

            $deliveryNum2++;

            // ポイント確定
            $this->fixPoint($NewOrder, $Customer);
        }

        $this->expected = $currentPoint + ($addPoint * $deliveryNum2);
        $this->actual = PointTestUtil::calculateCurrentPoint($Customer, $this->app);
        $this->verify('保有ポイントの合計は '.$this->expected);
        $currentPoint = $this->expected;

        $this->expected = $provisionalAddPoint;
        $this->actual = $calculator->getProvisionalAddPoint();
        $this->verify('現在の仮ポイント合計は '.$this->expected);

        $OrderNew = $this->app['eccube.repository.order_status']->find($this->app['config']['order_new']);
        $NewOrders2 = $this->app['eccube.repository.order']->findBy(
            array(
                'Customer' => $Customer,
                'OrderStatus' => $OrderNew
            )
        );
        $i = 0;
        $deleted = 0;
        $fixAddPoint = 0;
        $deleteUsePoint = 0;
        $usePointOrderIds = array();
        foreach ($NewOrders2 as $NewOrder) {
            if (($i % 2) === 0) {
                $NewOrder->setOrderStatus($OrderDeliv);
                $this->app['orm.em']->flush($NewOrder);

                // ポイント確定
                $this->fixPoint($NewOrder, $Customer);
                $fixAddPoint += $addPoint - ($discount * ($PointInfo->getPlgBasicPointRate() / 100));
                $usePointOrderIds[] = $NewOrder->getId();
            } else {
                // 受注削除
                $this->deleteOrder($NewOrder);
                $deleted++;
                $deleteUsePoint += $usePoint; // 利用したポイントを戻す
            }
            $i++;
        }

        $this->expected = 0;
        $this->actual = $calculator->getProvisionalAddPoint();
        $this->verify('現在の仮ポイント合計は '.$this->expected);

        $this->expected = $currentPoint + $fixAddPoint + $deleteUsePoint;
        $this->actual = PointTestUtil::calculateCurrentPoint($Customer, $this->app);
        $this->verify('保有ポイントの合計は '.$this->expected);
        $currentPoint = $this->expected;

        // 受注のポイントを変更する
        foreach ($usePointOrderIds as $order_id) {
            $UsePointOrder = $this->app['eccube.repository.order']->find($order_id);
            // 利用 200pt, 加算 1098pt に変更する
            $changeUsePoint = 200;
            $changeAddPoint = 1098;
            $this->saveOrder($UsePointOrder, $changeUsePoint, $changeAddPoint);
            $currentPoint -= ($changeUsePoint - $usePoint);
            $currentPoint += ($changeAddPoint - ($addPoint - ($discount * ($PointInfo->getPlgBasicPointRate() / 100))));
        }

        $this->expected = $currentPoint;
        $this->actual = PointTestUtil::calculateCurrentPoint($Customer, $this->app);
        $this->verify('保有ポイントの合計は '.$this->expected);
    }

    /**
     * お届け先変更をした場合のテストケース.
     *
     * @link https://github.com/EC-CUBE/point-plugin/issues/114
     */
    public function testChangeShipping()
    {
        $currentPoint = 1000;   // 保有ポイント
        $usePoint = 100;        // 利用ポイント

        // ポイント確定ステータスを「発送済み」に設定
        $PointInfo = $this->app['eccube.plugin.point.repository.pointinfo']->getLastInsertData();
        $PointInfo->setPlgAddPointStatus($this->app['config']['order_deliv']);
        $this->app['orm.em']->flush();


        $faker = $this->getFaker();
        $Customer = $this->logIn();
        $client = $this->client;

        // 保有ポイントを設定する
        PointTestUtil::saveCustomerPoint($Customer, $currentPoint, $this->app);

        // カート画面
        $this->scenarioCartIn($client);

        // 確認画面
        $crawler = $this->scenarioConfirm($client);
        $this->expected = 'ご注文内容のご確認';
        $this->actual = $crawler->filter('h1.page-heading')->text();
        $this->verify();

        // ポイント利用画面
        $crawler = $client->request('GET', $this->app->path('point_use'));
        $this->assertRegexp(
            '/現在の保有ポイントは「'.number_format($currentPoint).' pt」です。/u',
            $crawler->filter('#detail_box')->text()
        );

        // ポイント利用処理
        $crawler = $this->scenarioUsePoint($client, $usePoint);
        $this->assertTrue($client->getResponse()->isRedirect($this->app->url('shopping')));

        // お届け先指定画面
        $crawler = $client->request(
            'POST',
            $this->app->path('shopping_delivery'),
            array(
                'shopping' => array(
                    'shippings' => array(
                        0 => array(
                            'delivery' => 1,
                            'deliveryTime' => 1
                        ),
                    ),
                    'payment' => 1,
                    'message' => $faker->text(),
                    '_token' => 'dummy'
                )
            )
        );

        $this->assertTrue($client->getResponse()->isRedirect($this->app->url('shopping')));

        // 完了画面
        $crawler = $this->scenarioComplete($client, $this->app->path('shopping_confirm'));
        $this->assertTrue($client->getResponse()->isRedirect($this->app->url('shopping_complete')));

        $Messages = $this->getMailCatcherMessages();
        $Message = $this->getMailCatcherMessage($Messages[0]->id);

        $this->expected = '[' . $this->BaseInfo->getShopName() . '] ご注文ありがとうございます';
        $this->actual = $Message->subject;
        $this->verify();

        $body = $this->parseMailCatcherSource($Message);

        $this->assertRegexp('/利用ポイント：'.$usePoint.' pt/u', $body);
        $this->assertRegexp('/加算ポイント：1,100 pt/u', $body);

        $this->expected = $currentPoint - $usePoint;
        $this->actual = PointTestUtil::calculateCurrentPoint($Customer, $this->app);
        $this->verify('保有ポイントの合計は '.$this->expected);
    }

    /**
     * ポイントがマイナスの際の表示テストケース.
     */
    public function testMinusPoint()
    {
        $currentPoint = -1000;   // 保有ポイント
        $usePoint = 0;

        $faker = $this->getFaker();
        $Customer = $this->logIn();
        $client = $this->client;

        // 保有ポイントを設定する
        PointTestUtil::saveCustomerPoint($Customer, $currentPoint, $this->app);

        // Myページ
        $crawler = $client->request('GET', $this->app->path('mypage'));
        $this->assertRegexp(
            '/現在の保有ポイントは「0 pt」です。/u',
            $crawler->filter('.txt_center')->text(),
            'Myページ'
        );

        // カート画面
        $this->scenarioCartIn($client);
        $crawler = $client->request('GET', $this->app->url('cart'));
        $this->assertRegexp(
            '/現在の保有ポイントは「0 pt」です。/u',
            $crawler->filter('#cart_item__point_info')->text(),
            'カート画面'
        );

        // 確認画面
        $crawler = $this->scenarioConfirm($client);
        $this->expected = 'ご注文内容のご確認';
        $this->actual = $crawler->filter('h1.page-heading')->text();
        $this->verify();
        $this->assertRegexp(
            '/現在の保有ポイントは「0 pt」です。/u',
            $crawler->filter('#point_box__info')->text(),
            '購入確認画面'
        );

        // ポイント利用画面
        $crawler = $client->request('GET', $this->app->path('point_use'));
        $this->assertRegexp(
            '/現在の保有ポイントは「0 pt」です。/u',
            $crawler->filter('#detail_box')->text(),
            'ポイント利用画面'
        );
        $this->assertNotRegexp(
            '/「'.number_format($currentPoint).' pt」までご利用いただけます。/u',
            $crawler->filter('#detail_box')->text(),
            'ポイント利用画面'
        );

        // 完了画面
        $crawler = $this->scenarioComplete($client, $this->app->path('shopping_confirm'));
        $this->assertTrue($client->getResponse()->isRedirect($this->app->url('shopping_complete')));
    }

    /**
     * 購入中にポイントがマイナスになった場合のテストケース.
     */
    public function testUsePointWithMinus()
    {
        $currentPoint = 1000;   // 保有ポイント
        $usePoint = 100;        // 利用ポイント
        $minusPoint = -2000;    // テスト用のポイント

        // ポイント確定ステータスを「発送済み」に設定
        $PointInfo = $this->app['eccube.plugin.point.repository.pointinfo']->getLastInsertData();
        $PointInfo->setPlgAddPointStatus($this->app['config']['order_deliv']);
        $this->app['orm.em']->flush();

        $faker = $this->getFaker();
        $Customer = $this->logIn();
        $client = $this->client;

        // 保有ポイントを設定する
        PointTestUtil::saveCustomerPoint($Customer, $currentPoint, $this->app);

        // カート画面
        $this->scenarioCartIn($client);

        // 確認画面
        $crawler = $this->scenarioConfirm($client);
        $this->expected = 'ご注文内容のご確認';
        $this->actual = $crawler->filter('h1.page-heading')->text();
        $this->verify();

        // ポイント利用画面
        $crawler = $client->request('GET', $this->app->path('point_use'));
        $this->assertRegexp(
            '/現在の保有ポイントは「'.number_format($currentPoint).' pt」です。/u',
            $crawler->filter('#detail_box')->text()
        );

        // ポイント利用処理
        $crawler = $this->scenarioUsePoint($client, $usePoint);
        $this->assertTrue($client->getResponse()->isRedirect($this->app->url('shopping')));

        // 保有ポイントをマイナスに設定する
        PointTestUtil::saveCustomerPoint($Customer, $minusPoint, $this->app);

        // 完了画面
        $crawler = $this->scenarioComplete($client, $this->app->path('shopping_confirm'));
        $this->assertTrue($client->getResponse()->isRedirect($this->app->url('shopping_complete')));

        $crawler = $client->request(
            'GET',
            $this->app->url('shopping_complete'));

        $Order = $this->app['eccube.repository.order']->findOneBy(
            array('Customer' => $Customer),
            array('id' => 'DESC')
        );

        // JavaScript の受注IDの部分のコードをパースしてチェックする
        $this->assertRegExp('/'.$Order->getId()."\)'\);/", $crawler->html(),
                            'マイナス警告メッセージが表示されているか');

        $Messages = $this->getMailCatcherMessages();
        $Message = $this->getMailCatcherMessage($Messages[0]->id);

        $this->expected = '[' . $this->BaseInfo->getShopName() . '] ポイント通知';
        $this->actual = $Message->subject;
        $this->verify('マイナス通知メールのチェック');

        $body = $this->parseMailCatcherSource($Message);

        $this->assertRegexp('/会員ID：'.$Customer->getId().'/u', $body);
        $this->assertRegexp('/注文番号：'.$Order->getId().'/u', $body);
        $this->assertRegexp('/利用ポイント：'.number_format($usePoint).'/u', $body);
        $this->assertRegexp('/保有ポイント：'.number_format($minusPoint - $usePoint + $currentPoint).'/u', $body);
    }

    protected function scenarioCartIn($client, $product_class_id = 1)
    {
        $crawler = $client->request('POST', '/cart/add', array('product_class_id' => $product_class_id));
        $this->app['eccube.service.cart']->lock();
        return $crawler;
    }

    protected function scenarioInput($client, $formData)
    {
        $crawler = $client->request(
            'POST',
            $this->app->path('shopping_nonmember'),
            array('nonmember' => $formData)
        );
        $this->app['eccube.service.cart']->lock();
        return $crawler;
    }

    protected function scenarioConfirm($client)
    {
        $crawler = $client->request('GET', $this->app->path('shopping'));
        return $crawler;
    }

    protected function scenarioComplete($client, $confirm_url)
    {
        $faker = $this->getFaker();

        $crawler = $client->request(
            'POST',
            $confirm_url,
            array('shopping' =>
                  array(
                      'shippings' =>
                      array(0 =>
                            array(
                                'delivery' => 1,
                                'deliveryTime' => 1
                            ),
                      ),
                      'payment' => 1,
                      'message' => $faker->text(),
                      '_token' => 'dummy'
                  )
            )
        );

        return $crawler;
    }

    /**
     * ポイント利用処理のシナリオ
     */
    protected function scenarioUsePoint($client, $usePoint)
    {
        $crawler = $client->request(
            'POST',
            $this->app->path('point_use'),
            array('front_point_use' =>
                  array(
                      'plg_use_point' => $usePoint,
                      '_token' => 'dummy'
                  )
            )
        );
        return $crawler;
    }

    /**
     * AdminOrder::fixPoint() を実行する.
     *
     * protected なので リフレクションを使用する.
     */
    protected function fixPoint($Order, $Customer)
    {
        $AdminOrder = new AdminOrder();
        $Reflect = new \ReflectionClass($AdminOrder);
        $Method = $Reflect->getMethod('fixPoint');
        $Method->setAccessible(true);
        $Method->invoke($AdminOrder, $Order, $Customer);
    }

    /**
     * AdminOrder::delete() を実行する.
     */
    protected function deleteOrder($Order)
    {
        $Order->setDelFlg(Constant::ENABLED);
        $this->app['orm.em']->flush($Order);

        $AdminOrder = new AdminOrder();
        $event = new EventArgs(
            array(
                'Order' => $Order
            ),
            null
        );
        $AdminOrder->delete($event);
    }

    /**
     * AdminOrder::save() を実行する.
     */
    protected function saveOrder($Order, $usePoint = 0, $addPoint = 0)
    {
        $form = array(
            'use_point' => new FormTypeMock($usePoint),
            'add_point' => new FormTypeMock($addPoint)
        );
        $AdminOrder = new AdminOrder();
        $event = new EventArgs(
            array(
                'TargetOrder' => $Order,
                'form' => $form
            ),
            null
        );
        $AdminOrder->save($event);
    }
}

class FormTypeMock
{
    protected $point;
    public function __construct($point)
    {
        $this->point = $point;
    }
    public function getData()
    {
        return $this->point;
    }
}
