<?php
/*
* This file is part of EC-CUBE
*
* Copyright(c) 2000-2016 LOCKON CO.,LTD. All Rights Reserved.
* http://www.lockon.co.jp/
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
namespace Eccube\Tests\Helper\PointCalculateHelper;

use Eccube\Application;
use Eccube\Tests\EccubeTestCase;
use Plugin\Point\Entity\Point;
use Plugin\Point\Entity\PointInfo;
use Plugin\Point\Helper\PointHistoryHelper\PointHistoryHelper;

/**
 * Class PointCalculateHelperTest
 *
 * @package Eccube\Tests\Helper\PointCalculateHelper
 */
class PointCalculateHelperTest extends EccubeTestCase
{
    /**
     * 端数計算のテスト
     */
    public function testGetRoundValue()
    {
        $calculater = $this->app['eccube.plugin.point.calculate.helper.factory'];
        $PointInfo = $this->app['eccube.plugin.point.repository.pointinfo']->getLastInsertData();

        // 切り上げ
        $PointInfo->setPlgRoundType(PointInfo::POINT_ROUND_CEIL);
        $this->expected = 11;
        $this->actual = $calculater->getRoundValue(10.5);
        $this->verify();
        $this->actual = $calculater->getRoundValue(10.4);
        $this->verify();
        $this->actual = $calculater->getRoundValue(10.05);
        $this->verify();
        $this->actual = $calculater->getRoundValue(10.04);
        $this->verify();

        // 切り捨て
        $PointInfo->setPlgRoundType(PointInfo::POINT_ROUND_FLOOR);
        $this->expected = 10;
        $this->actual = $calculater->getRoundValue(10.5);
        $this->verify();
        $this->actual = $calculater->getRoundValue(10.4);
        $this->verify();
        $this->actual = $calculater->getRoundValue(10.05);
        $this->verify();
        $this->actual = $calculater->getRoundValue(10.04);
        $this->verify();

        // 四捨五入(少数点第一位を四捨五入する
        $PointInfo->setPlgRoundType(PointInfo::POINT_ROUND_ROUND);
        $this->expected = 11;
        $this->actual = $calculater->getRoundValue(10.5);
        $this->verify();
        $this->expected = 10;
        $this->actual = $calculater->getRoundValue(10.4);
        $this->verify();
        $this->expected = 10;
        $this->actual = $calculater->getRoundValue(10.05);
        $this->verify();
        $this->expected = 10;
        $this->actual = $calculater->getRoundValue(10.04);
        $this->verify();
    }

    /**
     * ポイント利用時の加算ポイント減算処理のテスト
     */
    public function testGetSubtractionCalculate()
    {
        $testData = array(
            array(1, 1, 0, 0, 0, 0),
            array(1, 1, 1, 0, 0, 0),
            array(1, 1, 2, 0, 0, 0),
            array(1, 1, 0, 0, 50, 50),
            array(1, 1, 1, 0, 50, 50),
            array(1, 1, 2, 0, 50, 50),
            array(1, 1, 0, 50, 0, 0),
            array(1, 1, 1, 50, 0, 0),
            array(1, 1, 2, 50, 0, 0),
            array(1, 1, 0, 1, 50, 49),
            array(1, 1, 1, 1, 50, 50),
            array(1, 1, 2, 1, 50, 50),
            array(1, 1, 0, 49, 50, 49),
            array(1, 1, 1, 49, 50, 50),
            array(1, 1, 2, 49, 50, 50),
            array(1, 1, 0, 50, 50, 49),
            array(1, 1, 1, 50, 50, 50),
            array(1, 1, 2, 50, 50, 50),
            array(5, 5, 0, 0, 0, 0),
            array(5, 5, 1, 0, 0, 0),
            array(5, 5, 2, 0, 0, 0),
            array(5, 5, 0, 0, 50, 50),
            array(5, 5, 1, 0, 50, 50),
            array(5, 5, 2, 0, 50, 50),
            array(5, 5, 0, 50, 0, 0),
            array(5, 5, 1, 50, 0, 0),
            array(5, 5, 2, 50, 0, 0),
            array(5, 5, 0, 1, 50, 49),
            array(5, 5, 1, 1, 50, 50),
            array(5, 5, 2, 1, 50, 50),
            array(5, 5, 0, 49, 50, 37),
            array(5, 5, 1, 49, 50, 38),
            array(5, 5, 2, 49, 50, 38),
            array(5, 5, 0, 50, 50, 37),
            array(5, 5, 1, 50, 50, 38),
            array(5, 5, 2, 50, 50, 38)
        );

        /** @var $calculater \Plugin\Point\Helper\PointCalculateHelper\PointCalculateHelper **/
        $calculater = $this->app['eccube.plugin.point.calculate.helper.factory'];
        /** @var $PointInfo \Plugin\Point\Entity\PointInfo **/
        $PointInfo = $this->app['eccube.plugin.point.repository.pointinfo']->getLastInsertData();
        $PointInfo->setPlgCalculationType(PointInfo::POINT_CALCULATE_SUBTRACTION);

        $i = 0;
        $max = count($testData);
        for ($i = 0; $i < $max; $i++)  {
            $data = $testData[$i];

            // 基本ポイント付与率
            $PointInfo->setPlgBasicPointRate($data[0]);
            // ポイント換算レート
            $PointInfo->setPlgPointConversionRate($data[1]);
            // 端数計算方法
            $PointInfo->setPlgRoundType($data[2]);
            // 利用ポイント
            $this->assertTrue($calculater->setUsePoint($data[3]));
            // 加算ポイント
            $calculater->setAddPoint($data[4]);
            // 期待値
            $this->expected = ($data[5]);
            $this->actual = $calculater->getSubtractionCalculate();
            $this->verify('index ' . $i . ' failed.');
        }
    }

    public function testGetAddPointByOrder()
    {
        $testData = array(
            /**
             * - 基本ポイント付与率
             * - ポイント換算レート
             * - 端数計算方法
             * - ポイント利用
             * - ポイント減算方式
             * - 商品毎ポイント付与率
             * - 商品価格
             * - 商品個数
             * - 期待値
             */
            0 => array(1, 1, 0, 0, 1, null, 5000, 1, 50),
            1 => array(1, 1, 1, 0, 1, null, 5000, 1, 50),
            2 => array(1, 1, 2, 0, 1, null, 5000, 1, 50),
            3 => array(1, 1, 0, 50, 1, null, 5000, 1, 50),
            4 => array(1, 1, 1, 50, 1, null, 5000, 1, 50),
            5 => array(1, 1, 2, 50, 1, null, 5000, 1, 50),
            6 => array(1, 1, 0, 0, 0, null, 5000, 1, 50),
            7 => array(1, 1, 1, 0, 0, null, 5000, 1, 50),
            8 => array(1, 1, 2, 0, 0, null, 5000, 1, 50),
            9 => array(1, 1, 0, 50, 0, null, 5000, 1, 49),
            10 => array(1, 1, 1, 50, 0, null, 5000, 1, 50),
            11 => array(1, 1, 2, 50, 0, null, 5000, 1, 50),
            12 => array(1, 1, 0, 0, 1, 0, 5000, 1, 0),
            13 => array(1, 1, 1, 0, 1, 0, 5000, 1, 0),
            14 => array(1, 1, 2, 0, 1, 0, 5000, 1, 0),
            15 => array(1, 1, 0, 50, 1, 0, 5000, 1, 0),
            16 => array(1, 1, 1, 50, 1, 0, 5000, 1, 0),
            17 => array(1, 1, 2, 50, 1, 0, 5000, 1, 0),
            18 => array(1, 1, 0, 0, 0, 0, 5000, 1, 0),
            19 => array(1, 1, 1, 0, 0, 0, 5000, 1, 0),
            20 => array(1, 1, 2, 0, 0, 0, 5000, 1, 0),
            21 => array(1, 1, 0, 50, 0, 0, 5000, 1, 0),
            22 => array(1, 1, 1, 50, 0, 0, 5000, 1, 0),
            23 => array(1, 1, 2, 50, 0, 0, 5000, 1, 0),
            24 => array(1, 1, 0, 0, 1, 1, 5000, 1, 50),
            25 => array(1, 1, 1, 0, 1, 1, 5000, 1, 50),
            26 => array(1, 1, 2, 0, 1, 1, 5000, 1, 50),
            27 => array(1, 1, 0, 50, 1, 1, 5000, 1, 50),
            28 => array(1, 1, 1, 50, 1, 1, 5000, 1, 50),
            29 => array(1, 1, 2, 50, 1, 1, 5000, 1, 50),
            30 => array(1, 1, 0, 0, 0, 1, 5000, 1, 50),
            31 => array(1, 1, 1, 0, 1, 1, 5000, 1, 50),
            32 => array(1, 1, 2, 0, 1, 1, 5000, 1, 50),
            33 => array(1, 1, 0, 50, 0, 1, 5000, 1, 49),
            34 => array(1, 1, 1, 50, 0, 1, 5000, 1, 50),
            35 => array(1, 1, 2, 50, 0, 1, 5000, 1, 50),
            36 => array(5, 5, 0, 0, 1, null, 5000, 1, 250),
            37 => array(5, 5, 1, 0, 1, null, 5000, 1, 250),
            38 => array(5, 5, 2, 0, 1, null, 5000, 1, 250),
            39 => array(5, 5, 0, 50, 1, null, 5000, 1, 250),
            40 => array(5, 5, 1, 50, 1, null, 5000, 1, 250),
            41 => array(5, 5, 2, 50, 1, null, 5000, 1, 250),
            42 => array(5, 5, 0, 0, 0, null, 5000, 1, 250),
            43 => array(5, 5, 1, 0, 0, null, 5000, 1, 250),
            44 => array(5, 5, 2, 0, 0, null, 5000, 1, 250),
            45 => array(5, 5, 0, 50, 0, null, 5000, 1, 237),
            46 => array(5, 5, 1, 50, 0, null, 5000, 1, 238),
            47 => array(5, 5, 2, 50, 0, null, 5000, 1, 238),
            48 => array(5, 5, 0, 0, 1, 0, 5000, 1, 0),
            49 => array(5, 5, 1, 0, 1, 0, 5000, 1, 0),
            50 => array(5, 5, 2, 0, 1, 0, 5000, 1, 0),
            51 => array(5, 5, 0, 50, 1, 0, 5000, 1, 0),
            52 => array(5, 5, 1, 50, 1, 0, 5000, 1, 0),
            53 => array(5, 5, 2, 50, 1, 0, 5000, 1, 0),
            54 => array(5, 5, 0, 0, 0, 0, 5000, 1, 0),
            55 => array(5, 5, 1, 0, 0, 0, 5000, 1, 0),
            56 => array(5, 5, 2, 0, 0, 0, 5000, 1, 0),
            57 => array(5, 5, 0, 50, 0, 0, 5000, 1, 0),
            58 => array(5, 5, 1, 50, 0, 0, 5000, 1, 0),
            59 => array(5, 5, 2, 50, 0, 0, 5000, 1, 0),
            60 => array(5, 5, 0, 0, 1, 1, 5000, 1, 50),
            61 => array(5, 5, 1, 0, 1, 1, 5000, 1, 50),
            62 => array(5, 5, 2, 0, 1, 1, 5000, 1, 50),
            63 => array(5, 5, 0, 50, 1, 1, 5000, 1, 50),
            64 => array(5, 5, 1, 50, 1, 1, 5000, 1, 50),
            65 => array(5, 5, 2, 50, 1, 1, 5000, 1, 50),
            66 => array(5, 5, 0, 0, 0, 1, 5000, 1, 50),
            67 => array(5, 5, 1, 0, 0, 1, 5000, 1, 50),
            68 => array(5, 5, 2, 0, 0, 1, 5000, 1, 50),
            69 => array(5, 5, 0, 50, 0, 1, 5000, 1, 37),
            70 => array(5, 5, 1, 50, 0, 1, 5000, 1, 38),
            71 => array(5, 5, 2, 50, 0, 1, 5000, 1, 38),
        );

        // テストデータ生成
        $Customer = $this->createCustomer();
        $Order = $this->createOrder($Customer);

        /** @var $calculater \Plugin\Point\Helper\PointCalculateHelper\PointCalculateHelper **/
        $calculater = $this->app['eccube.plugin.point.calculate.helper.factory'];
        /** @var $PointInfo \Plugin\Point\Entity\PointInfo **/
        $PointInfo = $this->app['eccube.plugin.point.repository.pointinfo']->getLastInsertData();

        $calculater->addEntity('Order', $Order);

        foreach ($testData as $i => $data) {
            // 基本ポイント付与率
            $PointInfo->setPlgBasicPointRate($data[0]);
            // ポイント換算レート
            $PointInfo->setPlgPointConversionRate($data[1]);
            // 端数計算方法
            $PointInfo->setPlgRoundType($data[2]);
            // 利用ポイント
            $this->assertTrue($calculater->setUsePoint($data[3]));
            // ポイント減算方式
            $PointInfo->setPlgCalculationType($data[4]);

            foreach ($Order->getOrderDetails() as $OrderDetail) {
                $ProductClass = $OrderDetail->getProductClass();
                $Product = $ProductClass->getProduct();
                // 商品ごとポイント付与率
                $this->app['eccube.plugin.point.repository.pointproductrate']->savePointProductRate($data[5], $Product);
                // 商品価格
                $ProductClass->setPrice02($data[6]);
                // 商品個数
                $OrderDetail->setQuantity($data[7]);
            }

            $this->expected = $data[8];
            $this->actual = $calculater->getAddPointByOrder();
            $this->verify('index ' . $i . ' failed.');
        }
    }

    public function testGetAddPointByCart()
    {
        $testData = array(
            /**
             * - 基本ポイント付与率
             * - 端数計算方法
             * - 商品毎ポイント付与率
             * - 商品価格
             * - 商品個数
             * - 期待値
             */
            0 => array(1, 0, null, 50, 1, 0),
            1 => array(1, 1, null, 50, 1, 1),
            2 => array(1, 2, null, 50, 1, 1),
            3 => array(1, 0, 5, 50, 1, 2),
            4 => array(1, 1, 5, 50, 1, 3),
            5 => array(1, 2, 5, 50, 1, 3),
        );

        $Product = $this->createProduct();
        $ProductClasses = $Product->getProductClasses();
        $ProductClass = $ProductClasses[0];

        /** @var $calculater \Plugin\Point\Helper\PointCalculateHelper\PointCalculateHelper **/
        $calculater = $this->app['eccube.plugin.point.calculate.helper.factory'];
        /** @var $PointInfo \Plugin\Point\Entity\PointInfo **/
        $PointInfo = $this->app['eccube.plugin.point.repository.pointinfo']->getLastInsertData();

        $calculater->addEntity('Cart', $this->app['eccube.service.cart']->getCart());

        foreach ($testData as $i => $data) {
            // 基本ポイント付与率
            $PointInfo->setPlgBasicPointRate($data[0]);
            // 端数計算方法
            $PointInfo->setPlgRoundType($data[1]);

            // 商品ごとポイント付与率
            $this->app['eccube.plugin.point.repository.pointproductrate']->savePointProductRate($data[2], $Product);
            // 商品価格
            $ProductClass->setPrice02($data[3]);

            // 商品個数
            $this->app['eccube.service.cart']->clear();
            $this->app['eccube.service.cart']->setProductQuantity($ProductClass, $data[4]);
            $this->app['eccube.service.cart']->save();

            $Cart = $this->app['session']->get('cart');
            $CartItems = $Cart->getCartItems();
            foreach ($CartItems as $item) {
                $item->setObject($ProductClass);
            }
            $calculater->addEntity('Cart', $Cart);

            $this->expected = $data[5];
            $this->actual = $calculater->getAddPointByCart();
            $this->verify('index ' . $i . ' failed.');
        }
    }

    public function testGetAddPointByCartWithNotfound()
    {
        try {
            $calculater = $this->app['eccube.plugin.point.calculate.helper.factory'];
            $calculater->getAddPointByCart();
            $this->fail('Throwable to \LogicException');
        } catch (\LogicException $e) {
            $this->assertEquals('cart not found.', $e->getMessage());
        }
    }

    public function testGetAddPointByProduct()
    {
        $testData = array(
            /**
             * - 基本ポイント付与率
             * - 端数計算方法
             * - 商品毎ポイント付与率
             * - 商品価格(最小)
             * - 商品価格(最大)
             * - 期待値(最小)
             * - 期待値(最大)
             */
            array(1, 0, null, 50, 490, 0, 4),
            array(1, 1, null, 50, 490, 1, 5),
            array(1, 2, null, 50, 490, 1, 5),
            array(1, 0, 5, 50, 490, 2, 24),
            array(1, 1, 5, 50, 490, 3, 25),
            array(1, 2, 5, 50, 490, 3, 25),
        );

        $Product = $this->createProduct('test', 2);
        $ProductClasses = $Product->getProductClasses();
        $ProductClass = $ProductClasses[0];

        /** @var $calculater \Plugin\Point\Helper\PointCalculateHelper\PointCalculateHelper **/
        $calculater = $this->app['eccube.plugin.point.calculate.helper.factory'];
        /** @var $PointInfo \Plugin\Point\Entity\PointInfo **/
        $PointInfo = $this->app['eccube.plugin.point.repository.pointinfo']->getLastInsertData();

        $max = count($testData);
        for ($i = 0; $i < $max; $i++) {
            $data = $testData[$i];

            // 基本ポイント付与率
            $PointInfo->setPlgBasicPointRate($data[0]);
            // 端数計算方法
            $PointInfo->setPlgRoundType($data[1]);

            // 商品ごとポイント付与率
            $this->app['eccube.plugin.point.repository.pointproductrate']->savePointProductRate($data[2], $Product);
            // 商品価格
            $ProductClasses[0]->setPrice02($data[3]);
            $ProductClasses[1]->setPrice02($data[4]);

            $point = $calculater->getAddPointByProduct($Product);

            // min
            $this->expected = $data[5];
            $this->actual = $point['min'];
            $this->verify('index ' . $i . ' min failed.');

            // max
            $this->expected = $data[6];
            $this->actual = $point['max'];
            $this->verify('index ' . $i . ' max failed.');
        }
    }

    /**
     * ポイントを利用していたが、支払い方法の変更によりマイナスが発生したので、キャンセル処理が行われた
     */
    public function testCalculateTotalDiscountOnChangeConditions()
    {
        $Customer = $this->createCustomer();
        $Order = $this->createOrder($Customer);

        // 支払い金額が1300円で、1200ptを利用する
        $Order->setSubtotal(1000);
        $Order->setCharge(300);
        $Order->setDiscount(1200);
        $Order->setDeliveryFeeTotal(0);
        $this->app['orm.em']->flush();

        $PointInfo = $this->app['eccube.plugin.point.repository.pointinfo']->getLastInsertData();
        $this->createPreUsePoint($PointInfo, $Customer, $Order, -1200); // 1200ptを利用

        $calculater = $this->app['eccube.plugin.point.calculate.helper.factory'];
        $calculater->addEntity('Order', $Order);
        $calculater->addEntity('Customer', $Customer);

        $this->expected = false;
        $this->actual = $calculater->calculateTotalDiscountOnChangeConditions();
        $this->verify('支払い金額がプラスの場合は false');

        $this->expected = 100;
        $this->actual = $Order->getTotalPrice();
        $this->verify('お支払い金額は '.$this->actual.' 円');

        // 支払い方法を変更したことで、手数料が300円から0円になり、支払い金額にマイナスが発生した
        $Order->setCharge(0);
        $this->app['orm.em']->flush();

        // ポイントの打ち消しと、値引きの戻しが実行されているはず。
        $this->expected = true;
        $this->actual = $calculater->calculateTotalDiscountOnChangeConditions();
        $this->verify('支払い金額がマイナスの場合は true');

        // 支払い金額は手数料とポイント利用の値引きがなくなるので1000円になる
        $this->expected = 1000;
        $this->actual = $Order->getTotalPrice();
        $this->verify('お支払い金額は '.$this->actual.' 円');

        // 値引きはキャンセルされ、0円になる
        $this->expected = 0;
        $this->actual = $Order->getDiscount();
        $this->verify('値引きは '.$this->actual.' 円');

        // 利用ポイントは打ち消され、0ptになる
        $this->expected = 0;
        $this->actual = $this->app['eccube.plugin.point.repository.point']->getLatestPreUsePoint($Order);
        $this->verify('利用ポイントは '.$this->actual.' 円');
    }

    /**
     * 10ポイント利用しようとしたが、お支払い金額がマイナスになっている場合
     */
    public function testCalculateTotalDiscountOnChangeConditionsWithUsePoint()
    {
        $Customer = $this->createCustomer();
        $Order = $this->createOrder($Customer);

        // ポイント利用以外のプラグインで、お支払い金額がマイナスになった場合
        $totalAmount = $Order->getTotalPrice();
        $this->app['eccube.service.shopping']->setDiscount($Order, $totalAmount + 1); // 支払い金額 + 1円を値引きする
        $this->app['orm.em']->flush();

        $calculater = $this->app['eccube.plugin.point.calculate.helper.factory'];
        $calculater->addEntity('Order', $Order);
        $calculater->addEntity('Customer', $Customer);

        $PointInfo = $this->app['eccube.plugin.point.repository.pointinfo']->getLastInsertData();
         // 10ポイント利用する
        $this->createPreUsePoint($PointInfo, $Customer, $Order, 10);

        $this->expected = true;
        $this->actual = $calculater->calculateTotalDiscountOnChangeConditions();
        $this->verify('ポイント利用以外のプラグインで、お支払い金額がマイナスになった場合は true');

        $this->expected = -11;
        $this->actual = $Order->getTotalPrice();
        $this->verify('お支払い金額は '.$this->actual.' 円');

        // 保有ポイントは 0 になっているはず
        $orderIds = $this->app['eccube.plugin.point.repository.pointstatus']->selectOrderIdsWithFixedByCustomer(
            $Customer->getId()
        );
        $this->actual = $this->app['eccube.plugin.point.repository.point']->calcCurrentPoint(
            $Customer->getId(),
            $orderIds
        );

        $this->expected = 0;
        $this->verify('保有ポイントは '.$this->actual);
    }

    public function testCalculateTotalDiscountOnChangeConditionsWithAmountPlus()
    {
        $Customer = $this->createCustomer();
        $Order = $this->createOrder($Customer);

        // ポイント利用以外のプラグインで、お支払い金額が 0 になった場合
        $totalAmount = $Order->getTotalPrice();
        $this->app['eccube.service.shopping']->setDiscount($Order, $totalAmount); // 支払い金額分を値引きする
        $this->app['orm.em']->flush();

        $calculater = $this->app['eccube.plugin.point.calculate.helper.factory'];
        $calculater->addEntity('Order', $Order);
        $calculater->addEntity('Customer', $Customer);

        $this->expected = false;
        $this->actual = $calculater->calculateTotalDiscountOnChangeConditions();
        $this->verify('ポイント利用以外のプラグインで、お支払い金額が 0 になった場合は false');

        $this->expected = 0;
        $this->actual = $Order->getTotalPrice();
        $this->verify('お支払い金額は '.$this->actual.' 円');
    }

    public function testCalculateTotalDiscountOnChangeConditionsWithException()
    {
        try {
            $calculater = $this->app['eccube.plugin.point.calculate.helper.factory'];
            $calculater->calculateTotalDiscountOnChangeConditions();
            $this->fail('Throwable to \LogicException');
        } catch (\LogicException $e) {
            $this->assertEquals('Order not found.', $e->getMessage());
        }

        $Customer = $this->createCustomer();
        $Order = $this->createOrder($Customer);
        try {
            $calculater = $this->app['eccube.plugin.point.calculate.helper.factory'];
            $calculater->addEntity('Order', $Order);
            $calculater->calculateTotalDiscountOnChangeConditions();
            $this->fail('Throwable to \LogicException');
        } catch (\LogicException $e) {
            $this->assertEquals('Customer not found.', $e->getMessage());
        }
    }

    public function testCalculateTotalDiscountOnChangeConditionsWithPointInfoNotfound()
    {
        // PointInfo が削除される. イレギュラー.
        $PointInfos = $this->app['eccube.plugin.point.repository.pointinfo']->findAll();
        foreach ($PointInfos as $PointInfo) {
            $this->app['orm.em']->remove($PointInfo);
            $this->app['orm.em']->flush($PointInfo);
        }
        $Customer = $this->createCustomer();
        $Order = $this->createOrder($Customer);

        try {
            $calculater = $this->app['eccube.plugin.point.calculate.helper.factory'];
            $calculater->addEntity('Order', $Order);
            $calculater->addEntity('Customer', $Customer);
            $calculater->calculateTotalDiscountOnChangeConditions();
            $this->fail('Throwable to \LogicException');
        } catch (\LogicException $e) {
            $this->assertEquals('PointInfo not found.', $e->getMessage());
        }
    }

    public function testSetUsePoint()
    {
        $calculater = $this->app['eccube.plugin.point.calculate.helper.factory'];

        $this->expected = false;
        $this->actual = $calculater->setUsePoint(-1);
        $this->verify();

        $this->expected = true;
        $this->actual = $calculater->setUsePoint(0);
        $this->verify();

        $this->expected = true;
        $this->actual = $calculater->setUsePoint(1);
        $this->verify();
    }

    public function testGetConversionPoint()
    {
        $Customer = $this->createCustomer();
        $Order = $this->createOrder($Customer);

        $calculater = $this->app['eccube.plugin.point.calculate.helper.factory'];
        $calculater->addEntity('Order', $Order);
        $calculater->addEntity('Customer', $Customer);
        $calculater->setUsePoint(200);

        $this->expected = 200;
        $this->actual = $calculater->getConversionPoint();
        $this->verify();
    }

    public function testSetDiscount()
    {
        $Customer = $this->createCustomer();
        $Order = $this->createOrder($Customer);
        $Order->setDiscount(90); // ポイント値引き10円 + その他値引き90円

        $calculater = $this->app['eccube.plugin.point.calculate.helper.factory'];
        $calculater->addEntity('Order', $Order);
        $calculater->addEntity('Customer', $Customer);
        $calculater->setUsePoint(10); // ポイント利用10pt

        $this->expected = true;
        $this->actual = $calculater->setDiscount(0);
        $this->verify('10pt 利用しているかどうか');

        $this->expected = 100;
        $this->actual = $Order->getDiscount();
        $this->verify('値引き額が正しいかどうか');
    }

    public function testSetDiscount2()
    {
        $Customer = $this->createCustomer();
        $Order = $this->createOrder($Customer);
        $Order->setDiscount(10); // その他値引き10円

        $calculater = $this->app['eccube.plugin.point.calculate.helper.factory'];
        $calculater->addEntity('Order', $Order);
        $calculater->addEntity('Customer', $Customer);
        $calculater->setUsePoint(90); // ポイント利用90pt

        $this->expected = true;
        $this->actual = $calculater->setDiscount(0);
        $this->verify('同一受注の前回利用ポイントは 0');

        $this->expected = 100;
        $this->actual = $Order->getDiscount();
        $this->verify('値引き額が正しいかどうか');
    }

    /**
     * 仮利用ポイントの履歴を含むテストケース
     */
    public function testSetDiscount3()
    {
        $previousUsePoint = 100; // 前回入力したポイント100
        $usePoint = 10;         // 今回利用ポイント10
        $otherDiscount = 5;     // その他の割引5円
        $Customer = $this->createCustomer();
        $Order = $this->createOrder($Customer);

         // その他値引き5円 + 前回入力したポイント値引き分100円
        $Order->setDiscount($otherDiscount + $previousUsePoint);

        // 仮利用ポイントの履歴を作成する
        $this->app['eccube.plugin.point.history.service']->addEntity($Order);
        $this->app['eccube.plugin.point.history.service']->addEntity($Order->getCustomer());
        $this->app['eccube.plugin.point.history.service']->savePreUsePoint($previousUsePoint * -1); // 前回入力したポイントを履歴に設定

        $lastPreUsePoint = $this->app['eccube.plugin.point.repository.point']->getLatestPreUsePoint($Order);
        $lastPreUsePoint = abs($lastPreUsePoint);

        $this->expected = $previousUsePoint;
        $this->actual = $lastPreUsePoint;
        $this->verify('前回入力したポイントは '.$this->expected.' pt');

        $calculater = $this->app['eccube.plugin.point.calculate.helper.factory'];
        $calculater->addEntity('Order', $Order);
        $calculater->addEntity('Customer', $Customer);
        $calculater->setUsePoint($usePoint); // ポイント利用10pt

        $this->expected = true;
        $this->actual = $calculater->setDiscount($lastPreUsePoint); // 同一受注でポイントを入力した履歴があるかどうか
        $this->verify('同一受注の利用ポイント履歴あり');

        $this->expected = $usePoint + $otherDiscount;
        $this->actual = $Order->getDiscount();
        $this->verify('値引き額が正しいかどうか');
    }

    /**
     * discount に負の整数を入力するケース
     */
    public function testSetDiscount4()
    {
        $previousUsePoint = 100; // 前回入力したポイント100
        $usePoint = 100;         // 今回利用ポイント100
        $otherDiscount = -5;     // その他の割引-5円(5円加算)
        $Customer = $this->createCustomer();
        $Order = $this->createOrder($Customer);

         // その他値引き-5円 + 前回入力したポイント値引き分100円
        $Order->setDiscount($otherDiscount + $previousUsePoint);

        // 仮利用ポイントの履歴を作成する
        $this->app['eccube.plugin.point.history.service']->addEntity($Order);
        $this->app['eccube.plugin.point.history.service']->addEntity($Order->getCustomer());
        $this->app['eccube.plugin.point.history.service']->savePreUsePoint($previousUsePoint * -1); // 前回入力したポイントを履歴に設定

        $lastPreUsePoint = $this->app['eccube.plugin.point.repository.point']->getLatestPreUsePoint($Order);
        $lastPreUsePoint = abs($lastPreUsePoint);

        $this->expected = $previousUsePoint;
        $this->actual = $lastPreUsePoint;
        $this->verify('前回入力したポイントは '.$this->expected.' pt');

        $calculater = $this->app['eccube.plugin.point.calculate.helper.factory'];
        $calculater->addEntity('Order', $Order);
        $calculater->addEntity('Customer', $Customer);
        $calculater->setUsePoint($usePoint); // ポイント利用100pt

        $this->expected = true;
        $this->actual = $calculater->setDiscount($lastPreUsePoint); // 同一受注でポイントを入力した履歴があるかどうか
        $this->verify('同一受注の利用ポイント履歴あり');

        $this->expected = $usePoint + $otherDiscount;
        $this->actual = $Order->getDiscount();
        $this->verify('値引き額が正しいかどうか');
    }

    /**
     * 仮利用ポイントの登録
     * @param Customer $customer
     * @param Order $order
     * @param int $pointValue
     * @return Point
     */
    private function createPreUsePoint($PointInfo, $Customer, $Order, $pointValue = -10)
    {
        $Point = new Point();
        $Point
            ->setCustomer($Customer)
            ->setPlgDynamicPoint($pointValue)
            ->setPlgPointType(PointHistoryHelper::STATE_PRE_USE)
            ->setPointInfo($PointInfo)
            ->setOrder($Order);

        $this->app['orm.em']->persist($Point);
        $this->app['orm.em']->flush();
        return $Point;
    }
}
