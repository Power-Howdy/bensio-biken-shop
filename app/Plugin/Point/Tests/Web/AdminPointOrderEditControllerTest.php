<?php

namespace Eccube\Tests\Web;

use Eccube\Tests\Web\Admin\AbstractAdminWebTestCase;
use Plugin\Point\Tests\Util\PointTestUtil;
use Plugin\Point\Entity\PointInfo;

class AdminPointOrderEditControllerTest extends AbstractAdminWebTestCase
{
    protected $Customer;
    protected $Order;
    protected $Product;

    public function setUp()
    {
        parent::setUp();
        $this->Customer = $this->createCustomer();
        $this->Product = $this->createProduct();
    }

    public function createFormData($Customer, $Product, $usePoint = 0, $addPoint = 0)
    {
        $ProductClasses = $Product->getProductClasses();
        $faker = $this->getFaker();
        $tel = explode('-', $faker->phoneNumber);

        $email = $faker->safeEmail;
        $delivery_date = $faker->dateTimeBetween('now', '+ 5 days');

        $order = array(
            '_token' => 'dummy',
            'Customer' => $Customer->getId(),
            'OrderStatus' => 1,
            'name' => array(
                'name01' => $faker->lastName,
                'name02' => $faker->firstName,
            ),
            'kana' => array(
                'kana01' => $faker->lastKanaName ,
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
            'message' => $faker->text,
            'Payment' => 1,
            'discount' => 0,
            'delivery_fee_total' => 0,
            'charge' => 0,
            'note' => $faker->text,
            'use_point' => $usePoint,
            'add_point' => $addPoint,
            'OrderDetails' => array(
                array(
                    'Product' => $Product->getId(),
                    'ProductClass' => $ProductClasses[0]->getId(),
                    'price' => $ProductClasses[0]->getPrice02(),
                    'quantity' => 1,
                    'tax_rate' => 8
                )
            ),
            'Shippings' => array(
                array(
                    'name' => array(
                        'name01' => $faker->lastName,
                        'name02' => $faker->firstName,
                    ),
                    'kana' => array(
                        'kana01' => $faker->lastKanaName ,
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
                    'Delivery' => 1,
                    'DeliveryTime' => 1,
                    'shipping_delivery_date' => array(
                        'year' => $delivery_date->format('Y'),
                        'month' => $delivery_date->format('n'),
                        'day' => $delivery_date->format('j')
                    )
                )
            )
        );
        return $order;
    }

    public function testRoutingAdminOrderNewPost()
    {
        $currentPoint = 1000;   // 現在の保有ポイント
        $usePoint = 100;        // 使用するポイント

        PointTestUtil::saveCustomerPoint($this->Customer, $currentPoint, $this->app);

        $crawler = $this->client->request(
            'POST',
            $this->app->url('admin_order_new'),
            array(
                'order' => $this->createFormData($this->Customer, $this->Product, $usePoint),
                'mode' => 'register'
            )
        );

        $url = $crawler->filter('a')->text();
        $this->assertTrue($this->client->getResponse()->isRedirect($url));

        preg_match('/([0-9]+)/', $url, $match);
        $order_id = $match[0];

        $crawler = $this->client->request(
            'GET',
            $this->app->url('admin_order_edit', array('id' => $order_id))
        );

        $this->expected = number_format($currentPoint - $usePoint).' Pt';
        $this->actual = $crawler->filter('#point_info_box p')->text();
        $this->verify('受注管理画面に表示されるポイントは '.$this->expected);

        $this->expected = $currentPoint - $usePoint;
        $this->actual = PointTestUtil::calculateCurrentPoint($this->Customer, $this->app);
        $this->verify('現在の保有ポイントは '.$this->expected);
    }

    public function testRoutingAdminOrderNewPostUseAndAddIsZero()
    {
        $currentPoint = 1000;   // 現在の保有ポイント
        $usePoint = 0;        // 使用するポイント
        $addPoint = 0;        // 加算するポイント

        PointTestUtil::saveCustomerPoint($this->Customer, $currentPoint, $this->app);

        $crawler = $this->client->request(
            'POST',
            $this->app->url('admin_order_new'),
            array(
                'order' => $this->createFormData($this->Customer, $this->Product, $usePoint, $addPoint),
                'mode' => 'register'
            )
        );

        $url = $crawler->filter('a')->text();
        $this->assertTrue($this->client->getResponse()->isRedirect($url));

        preg_match('/([0-9]+)/', $url, $match);
        $order_id = $match[0];

        $crawler = $this->client->request(
            'GET',
            $this->app->url('admin_order_edit', array('id' => $order_id))
        );

        $this->expected = number_format($currentPoint - $usePoint).' Pt';
        $this->actual = $crawler->filter('#point_info_box p')->text();
        $this->verify('受注管理画面に表示されるポイントは '.$this->expected);

        $this->expected = $currentPoint - $usePoint;
        $this->actual = PointTestUtil::calculateCurrentPoint($this->Customer, $this->app);
        $this->verify('現在の保有ポイントは '.$this->expected);
    }

    public function testRoutingAdminOrderNewPostUseAndAddIsNull()
    {
        $currentPoint = 1000;   // 現在の保有ポイント
        $usePoint = null;        // 使用するポイント
        $addPoint = null;        // 加算するポイント

        PointTestUtil::saveCustomerPoint($this->Customer, $currentPoint, $this->app);

        $crawler = $this->client->request(
            'POST',
            $this->app->url('admin_order_new'),
            array(
                'order' => $this->createFormData($this->Customer, $this->Product, $usePoint, $addPoint),
                'mode' => 'register'
            )
        );

        $url = $crawler->filter('a')->text();
        $this->assertTrue($this->client->getResponse()->isRedirect($url));

        preg_match('/([0-9]+)/', $url, $match);
        $order_id = $match[0];

        $crawler = $this->client->request(
            'GET',
            $this->app->url('admin_order_edit', array('id' => $order_id))
        );

        $this->expected = number_format($currentPoint - $usePoint).' Pt';
        $this->actual = $crawler->filter('#point_info_box p')->text();
        $this->verify('受注管理画面に表示されるポイントは '.$this->expected);

        $this->expected = $currentPoint - $usePoint;
        $this->actual = PointTestUtil::calculateCurrentPoint($this->Customer, $this->app);
        $this->verify('現在の保有ポイントは '.$this->expected);
    }

    public function testRoutingAdminOrderNewPostUseAndAddIsOne()
    {
        // ポイント確定ステータスを「発送済み」に設定
        $PointInfo = $this->app['eccube.plugin.point.repository.pointinfo']->getLastInsertData();
        $PointInfo->setPlgAddPointStatus($this->app['config']['order_deliv']);
        $this->app['orm.em']->flush();

        $currentPoint = 1000;   // 現在の保有ポイント
        $usePoint = 1;        // 使用するポイント
        $addPoint = 1;        // 加算するポイント

        PointTestUtil::saveCustomerPoint($this->Customer, $currentPoint, $this->app);

        $crawler = $this->client->request(
            'POST',
            $this->app->url('admin_order_new'),
            array(
                'order' => $this->createFormData($this->Customer, $this->Product, $usePoint, $addPoint),
                'mode' => 'register'
            )
        );

        $url = $crawler->filter('a')->text();
        $this->assertTrue($this->client->getResponse()->isRedirect($url));

        preg_match('/([0-9]+)/', $url, $match);
        $order_id = $match[0];

        $crawler = $this->client->request(
            'GET',
            $this->app->url('admin_order_edit', array('id' => $order_id))
        );

        $this->expected = number_format($currentPoint - $usePoint).' Pt';
        $this->actual = $crawler->filter('#point_info_box p')->text();
        $this->verify('受注管理画面に表示されるポイントは '.$this->expected);

        $this->expected = $currentPoint - $usePoint;
        $this->actual = PointTestUtil::calculateCurrentPoint($this->Customer, $this->app);
        $this->verify('現在の保有ポイントは '.$this->expected);
    }

    public function testRoutingAdminOrderEdit()
    {
        $currentPoint = 1000;
        $Customer = $this->createCustomer();
        $Order = $this->createOrder($Customer);

        PointTestUtil::saveCustomerPoint($Customer, $currentPoint, $this->app);

        $formData = $this->createFormData($Customer, $this->Product);
        $crawler = $this->client->request(
            'GET',
            $this->app->url('admin_order_edit', array('id' => $Order->getId()))
        );

        $this->expected = number_format($currentPoint).' Pt';
        $this->actual = $crawler->filter('#point_info_box p')->text();
        $this->verify('受注管理画面に表示されるポイントは '.$this->expected);
    }

    public function testRoutingAdminOrderEditPost()
    {
        $currentPoint = 1000;   // 現在の保有ポイント
        $usePoint = 100;        // 使用するポイント

        $Customer = $this->createCustomer();
        $Order = $this->createOrder($Customer);
        PointTestUtil::saveCustomerPoint($Customer, $currentPoint, $this->app);

        $formData = $this->createFormData($Customer, $this->Product, $usePoint);
        $crawler = $this->client->request(
            'POST',
            $this->app->url('admin_order_edit', array('id' => $Order->getId())),
            array(
                'order' => $formData,
                'mode' => 'register'
            )
        );
        $this->assertTrue($this->client->getResponse()->isRedirect($this->app->url('admin_order_edit', array('id' => $Order->getId()))));

        $crawler = $this->client->request(
            'GET',
            $this->app->url('admin_order_edit', array('id' => $Order->getId()))
        );

        $this->expected = number_format($currentPoint - $usePoint).' Pt';
        $this->actual = $crawler->filter('#point_info_box p')->text();
        $this->verify('受注管理画面に表示されるポイントは '.$this->expected);

        $this->expected = $currentPoint - $usePoint;
        $this->actual = PointTestUtil::calculateCurrentPoint($Customer, $this->app);
        $this->verify('現在の保有ポイントは '.$this->expected);
    }
}
