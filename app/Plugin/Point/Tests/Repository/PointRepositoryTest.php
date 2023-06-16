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
namespace Eccube\Tests\Repository;

use Eccube\Application;
use Eccube\Entity\Customer;
use Eccube\Entity\Order;
use Eccube\Tests\EccubeTestCase;
use Plugin\Point\Entity\Point;
use Plugin\Point\Entity\PointInfo;
use Plugin\Point\Helper\PointHistoryHelper\PointHistoryHelper;

/**
 * Class PointInfoRepositoryTest
 *
 * @package Eccube\Tests\Repository
 */
class PointRepositoryTest extends EccubeTestCase
{
    /**
     *  int テストで使用する加算ポイント
     */
    const POINT_VALUE = 37;
    /**
     *  int テストで使用する手動編集ポイント
     */
    const POINT_MANUAL_VALUE = 173;
    /**
     *  int テストで使用する利用ポイント
     */
    const POINT_USE_VALUE = -7;
    /**
     *  int テストで使用する仮利用ポイント
     */
    const POINT_PRE_USE_VALUE = -17;

    private  $pointInfo;

    public function setUp()
    {
        parent::setUp();

        $this->pointInfo = $this->createPointInfo();
    }

    public function testCalcCurrentPoint()
    {
        $customer = $this->createCustomer();
        $orderIds = array();

        // 準備：加算ポイントの履歴追加
        $point = $this->createAddPoint($customer);
        $orderIds[] = $point->getOrder()->getId();

        // 検証：現在ポイントの計算
        $sumPoint = $this->app['eccube.plugin.point.repository.point']->calcCurrentPoint(
            $point->getCustomer()->getId(),
            $orderIds
        );
        $this->expected = self::POINT_VALUE;
        $this->actual = $sumPoint;
        $this->verify();
    }

    public function testCalcCurrentPointWithMultiOrder()
    {
        $customer = $this->createCustomer();
        $orderIds = array();

        // 準備：加算ポイントの履歴追加
        $orderCount = 3;
        for ($i = 0; $i < $orderCount; $i++) {
            $Point = $this->createAddPoint($customer);
            $orderIds[] = $Point->getOrder()->getId();
        }

        // 検証：現在ポイントの計算
        $sumPoint = $this->app['eccube.plugin.point.repository.point']->calcCurrentPoint(
            $customer->getId(),
            $orderIds
        );
        $this->expected = self::POINT_VALUE * $orderCount;
        $this->actual = $sumPoint;
        $this->verify();
    }

    public function testCalcCurrentPointWithAddPointAndManualPoint()
    {
        $customer = $this->createCustomer();
        $no_calc_customer = $this->createCustomer();
        $orderIds = array();

        // 準備：加算ポイント/保有ポイント手動変更の履歴追加
        $orderIds[] = $this->createAddPoint($customer)->getOrder()->getId();
        $this->createManualPoint($customer);

        // 準備：集計対象としない会員のデータを追加する
        $this->createAddPoint($no_calc_customer);
        $this->createManualPoint($no_calc_customer);

        // 検証：現在ポイントの計算
        $sumPoint = $this->app['eccube.plugin.point.repository.point']->calcCurrentPoint(
            $customer->getId(),
            $orderIds
        );
        $this->expected = self::POINT_VALUE + self::POINT_MANUAL_VALUE;
        $this->actual = $sumPoint;
        $this->verify();
    }

    public function testCalcCurrentPointWithAddPointAndUsePoint()
    {
        $customer = $this->createCustomer();
        $orderIds = array();

        // 準備：加算ポイント/利用ポイント手動変更の履歴追加
        $point = $this->createAddPoint($customer);
        $this->createUsePoint($customer, $point->getOrder());
        $orderIds[] = $point->getOrder()->getId();

        // 検証：現在ポイントの計算
        $sumPoint = $this->app['eccube.plugin.point.repository.point']->calcCurrentPoint(
            $point->getCustomer()->getId(),
            $orderIds
        );
        $this->expected = self::POINT_VALUE + self::POINT_USE_VALUE;
        $this->actual = $sumPoint;
        $this->verify();
    }

    public function testCalcProvisionalAddPoint()
    {
        $customer = $this->createCustomer();
        $orderIds = array();

        // 準備：加算ポイントの履歴追加
        $point = $this->createAddPoint($customer);
        $orderIds[] = $point->getOrder()->getId();

        // 検証：現在の仮ポイントの計算
        $sumPoint = $this->app['eccube.plugin.point.repository.point']->calcProvisionalAddPoint(
            $orderIds
        );
        $this->expected = self::POINT_VALUE;
        $this->actual = $sumPoint;
        $this->verify();
    }

    public function testCalcProvisionalAddPointWithMultiOrder()
    {
        $customer = $this->createCustomer();
        $orderIds = array();

        // 準備：加算ポイントの履歴追加
        $orderCount = 3;
        for ($i = 0; $i < $orderCount; $i++) {
            $Point = $this->createAddPoint($customer);
            $orderIds[] = $Point->getOrder()->getId();
        }

        // 検証：現在の仮ポイントの計算
        $sumPoint = $this->app['eccube.plugin.point.repository.point']->calcProvisionalAddPoint(
            $orderIds
        );
        $this->expected = self::POINT_VALUE * $orderCount;
        $this->actual = $sumPoint;
        $this->verify();
    }

    public function testCalcProvisionalAddPointWithAddPointAndManualPoint()
    {
        $customer = $this->createCustomer();
        $no_calc_customer = $this->createCustomer();
        $orderIds = array();

        // 準備：加算ポイント/保有ポイント手動変更の履歴追加
        $orderIds[] = $this->createAddPoint($customer)->getOrder()->getId();
        $this->createManualPoint($customer);

        // 準備：集計対象としない会員のデータを追加する
        $this->createAddPoint($no_calc_customer);
        $this->createManualPoint($no_calc_customer);

        // 検証：現在の仮ポイントの計算
        $sumPoint = $this->app['eccube.plugin.point.repository.point']->calcProvisionalAddPoint(
            $orderIds
        );
        $this->expected = self::POINT_VALUE;
        $this->actual = $sumPoint;
        $this->verify();
    }

    public function testCalcProvisionalAddPointWithAddPointAndUsePoint()
    {
        $customer = $this->createCustomer();
        $orderIds = array();

        // 準備：加算ポイント/利用ポイント手動変更の履歴追加
        $point = $this->createAddPoint($customer);
        $this->createUsePoint($customer, $point->getOrder());
        $orderIds[] = $point->getOrder()->getId();

        // 検証：現在の仮ポイントの計算
        $sumPoint = $this->app['eccube.plugin.point.repository.point']->calcProvisionalAddPoint(
            $orderIds
        );
        $this->expected = self::POINT_VALUE;
        $this->actual = $sumPoint;
        $this->verify();
    }

    public function testCalcCurrentPointWithManualPointOnly()
    {
        $customer = $this->createCustomer();
        $orderIds = array();

        // 準備：保有ポイント手動変更の履歴のみを追加
        $this->createManualPoint($customer);

        // 検証：現在の保有ポイントの計算
        $sumPoint = $this->app['eccube.plugin.point.repository.point']->calcCurrentPoint(
            $customer->getId(),
            $orderIds
        );
        $this->expected = self::POINT_MANUAL_VALUE;
        $this->actual = $sumPoint;
        $this->verify();
    }

    public function testGetLatestAddPointByOrder()
    {
        $customer = $this->createCustomer();
        $order = $this->createOrder($customer);

        $latestValue = 123;

        // 準備：加算ポイント/利用ポイント手動変更の履歴追加
        $this->createAddPoint($customer, $order);   // dummy
        $this->createUsePoint($customer, $order);   // dummy
        $this->createManualPoint($customer);        // dummy
        $this->createAddPoint($customer, $order, $latestValue); // これが期待する値
        $this->createUsePoint($customer, $order);   // dummy
        $this->createManualPoint($customer);        // dummy
        $this->createPreUsePoint($customer, $order);   // dummy

        // 検証：最後に追加した加算ポイントの取得
        $value = $this->app['eccube.plugin.point.repository.point']->getLatestAddPointByOrder(
            $order
        );
        $this->expected = $latestValue;
        $this->actual = $value;
        $this->verify();
    }

    public function testGetLatestUsePoint()
    {
        $customer = $this->createCustomer();
        $order = $this->createOrder($customer);

        $latestUseValue = 123;

        // 準備：加算ポイント/利用ポイント手動変更の履歴追加
        $this->createAddPoint($customer, $order);   // dummy
        $this->createUsePoint($customer, $order);   // dummy
        $this->createManualPoint($customer);        // dummy
        $this->createUsePoint($customer, $order, $latestUseValue);   // これが期待する値
        $this->createAddPoint($customer, $order);   // dummy
        $this->createManualPoint($customer);        // dummy
        $this->createPreUsePoint($customer, $order);   // dummy

        // 検証：最後に追加した加算ポイントの取得
        $value = $this->app['eccube.plugin.point.repository.point']->getLatestUsePoint(
            $order
        );
        $this->expected = $latestUseValue;
        $this->actual = $value;
        $this->verify();
    }

    public function testGetLatestPreUsePoint()
    {
        $customer = $this->createCustomer();
        $order = $this->createOrder($customer);

        $latestPreUseValue = -123;

        // 準備：加算ポイント/利用ポイント手動変更の履歴追加
        $this->createAddPoint($customer, $order);   // dummy
        $this->createUsePoint($customer, $order);   // dummy
        $this->createPreUsePoint($customer, $order);   // dummy
        $this->createManualPoint($customer);        // dummy
        $this->createPreUsePoint($customer, $order, $latestPreUseValue);   // これが期待する値
        $this->createUsePoint($customer, $order);   // dummy
        $this->createAddPoint($customer, $order);   // dummy
        $this->createManualPoint($customer);        // dummy

        // 検証：最後に追加した加算ポイントの取得
        $value = $this->app['eccube.plugin.point.repository.point']->getLatestPreUsePoint(
            $order
        );
        $this->expected = $latestPreUseValue;
        $this->actual = $value;
        $this->verify();
    }

    /**
     * 保有ポイント集計、および未確定の加算ポイント集計で、仮利用ポイントが除外できているかどうかを確認する
     *
     * https://github.com/EC-CUBE/point-plugin/issues/108
     */
    public function testCalcPointWithPreUsePoint()
    {
        $customer = $this->createCustomer();
        $order = $this->createOrder($customer);

        // 準備：加算ポイント/利用ポイント手動変更の履歴追加
        $this->createManualPoint($customer, 1000);
        $this->createPreUsePoint($customer, $order, -50);
        $this->createUsePoint($customer, $order, -50);
        $this->createAddPoint($customer, $order, 50);

        // 検証：保有ポイント集計で、仮利用ポイントは集計対象がら除外される
        $value = $this->app['eccube.plugin.point.repository.point']->calcCurrentPoint(
            $customer->getId(),
            array($order->getId())
        );

        $this->expected = 1000;
        $this->actual = $value;
        $this->verify();

        // 検証：未確定の加算ポイント集計で、仮利用ポイントは集計対象がら除外される
        $value = $this->app['eccube.plugin.point.repository.point']->calcProvisionalAddPoint(
            array($order->getId())
        );

        $this->expected = 50;
        $this->actual = $value;
        $this->verify();
    }

    /**
     * 加算ポイントの登録
     * @param Customer $customer
     * @param Order $order
     * @param int $pointValue
     * @return Point
     */
    private function createAddPoint($customer, $order = null, $pointValue = self::POINT_VALUE)
    {
        if (empty($order)) {
            $order = $this->createOrder($customer);
        }

        $Point = new Point();
        $Point
            ->setCustomer($customer)
            ->setPlgDynamicPoint($pointValue)
            ->setPlgPointType(PointHistoryHelper::STATE_ADD)
            ->setPointInfo($this->pointInfo)
            ->setOrder($order);

        $this->app['orm.em']->persist($Point);
        $this->app['orm.em']->flush();
        return $Point;
    }

    // PointoInfoの作成
    private function createPointInfo(){
        $PointInfo = new PointInfo();
        $PointInfo
            ->setPlgAddPointStatus(1)
            ->setPlgBasicPointRate(1)
            ->setPlgCalculationType(1)
            ->setPlgPointConversionRate(1)
            ->setPlgRoundType(1);

        $this->app['orm.em']->persist($PointInfo);
        $this->app['orm.em']->flush();

        return $PointInfo;
    }

    /**
     * 手動編集ポイントの登録
     * @param Customer $customer
     * @return Point
     */
    private function createManualPoint($customer, $pointValue = self::POINT_MANUAL_VALUE)
    {
        $Point = new Point();
        $Point
            ->setCustomer($customer)
            ->setPlgDynamicPoint($pointValue)
            ->setPlgPointType(PointHistoryHelper::STATE_CURRENT)
            ->setPointInfo($this->pointInfo)
            ->setOrder(null);

        $this->app['orm.em']->persist($Point);
        $this->app['orm.em']->flush();
        return $Point;
    }

    /**
     * 利用ポイントの登録
     * @param Customer $customer
     * @param Order $order
     * @param int $pointValue
     * @return Point
     */
    private function createUsePoint($customer, $order, $pointValue = self::POINT_USE_VALUE)
    {
        $Point = new Point();
        $Point
            ->setCustomer($customer)
            ->setPlgDynamicPoint($pointValue)
            ->setPlgPointType(PointHistoryHelper::STATE_USE)
            ->setPointInfo($this->pointInfo)
            ->setOrder($order);

        $this->app['orm.em']->persist($Point);
        $this->app['orm.em']->flush();
        return $Point;
    }

    /**
     * 仮利用ポイントの登録
     * @param Customer $customer
     * @param Order $order
     * @param int $pointValue
     * @return Point
     */
    private function createPreUsePoint($customer, $order, $pointValue = self::POINT_PRE_USE_VALUE)
    {
        $Point = new Point();
        $Point
            ->setCustomer($customer)
            ->setPlgDynamicPoint($pointValue)
            ->setPlgPointType(PointHistoryHelper::STATE_PRE_USE)
            ->setPointInfo($this->pointInfo)
            ->setOrder($order);

        $this->app['orm.em']->persist($Point);
        $this->app['orm.em']->flush();
        return $Point;
    }
}

