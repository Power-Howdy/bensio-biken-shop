<?php

namespace Eccube\Tests\Repository;

use Eccube\Application;
use Eccube\Entity\Customer;
use Eccube\Entity\Order;
use Eccube\Tests\EccubeTestCase;
use Plugin\Point\Entity\PointStatus;

/**
 * Class PointStatusRepositoryTest
 *
 * @package Eccube\Tests\Repository
 */
class PointStatusRepositoryTest extends EccubeTestCase
{
    public function testSelectOrderIdsWithUnfixedByCustomer()
    {
        $customer = $this->createCustomer();
        $order = $this->createOrder($customer);

        // 準備：ポイントステータスの追加
        $this->addStatus($customer, $order);

        // 検証
        $orderIds = $this->app['eccube.plugin.point.repository.pointstatus']->selectOrderIdsWithUnfixedByCustomer(
            $customer->getId()
        );
        $this->expected = array($order->getId());
        $this->actual = $orderIds;
        $this->verify();
    }

    public function testSelectOrderIdsWithUnfixedByCustomerWithMultiOrder()
    {
        $addOrderIds = array();
        $customer = $this->createCustomer();

        // 準備：ポイントステータスの追加
        for ($i = 0; $i < 3; $i++) {
            $order = $this->createOrder($customer);
            $this->addStatus($customer, $order);
            $addOrderIds[] = $order->getId();
        }

        // 検証
        $orderIds = $this->app['eccube.plugin.point.repository.pointstatus']->selectOrderIdsWithUnfixedByCustomer(
            $customer->getId()
        );
        $this->expected = $addOrderIds;
        $this->actual = $orderIds;
        $this->verify();
    }

    public function testSelectOrderIdsWithUnfixedByCustomerWithOtherCustomer()
    {
        $addOrderIds = array();

        // 準備：テスト対象会員のレコード
        $customer = $this->createCustomer();
        $order = $this->createOrder($customer);
        $this->addStatus($customer, $order);
        $addOrderIds[] = $order->getId();

        // 準備：テスト対象でない会員のレコード
        $noTargetCustomer = $this->createCustomer();
        $noTargetOrder = $this->createOrder($noTargetCustomer);
        $this->addStatus($noTargetCustomer, $noTargetOrder);

        // 検証
        $orderIds = $this->app['eccube.plugin.point.repository.pointstatus']->selectOrderIdsWithUnfixedByCustomer(
            $customer->getId()
        );
        $this->expected = $addOrderIds;
        $this->actual = $orderIds;
        $this->verify();
    }

    public function testSelectOrderIdsWithUnfixedByCustomerWithDelFlg()
    {
        $addOrderIds = array();

        // 準備：有効なレコード
        $customer = $this->createCustomer();
        for ($i = 0; $i < 3; $i++) {
            $order = $this->createOrder($customer);
            $this->addStatus($customer, $order);
            $addOrderIds[] = $order->getId();
        }

        // 準備：無効なレコード
        $delOrderId = $addOrderIds[1];
        $this->deleteStatus($delOrderId);
        // 無効化したレコードを期待結果から削除
        unset($addOrderIds[1]);
        $addOrderIds = array_merge($addOrderIds);

        // 検証
        $orderIds = $this->app['eccube.plugin.point.repository.pointstatus']->selectOrderIdsWithUnfixedByCustomer(
            $customer->getId()
        );
        $this->expected = $addOrderIds;
        $this->actual = $orderIds;
        $this->verify();
    }

    public function testSelectOrderIdsWithFixedByCustomer()
    {
        $customer = $this->createCustomer();
        $order = $this->createOrder($customer);

        // 準備：ポイントステータスの追加
        $this->addStatus($customer, $order);
        $this->fixStatus($order->getId());

        // 検証
        $orderIds = $this->app['eccube.plugin.point.repository.pointstatus']->selectOrderIdsWithFixedByCustomer(
            $customer->getId()
        );
        $this->expected = array($order->getId());
        $this->actual = $orderIds;
        $this->verify();
    }

    public function testSelectOrderIdsWithFixedByCustomerWithMultiOrder()
    {
        $addOrderIds = array();
        $customer = $this->createCustomer();

        // 準備：ポイントステータスの追加
        for ($i = 0; $i < 3; $i++) {
            $order = $this->createOrder($customer);
            $this->addStatus($customer, $order);
            $this->fixStatus($order->getId());
            $addOrderIds[] = $order->getId();
        }

        // 検証
        $orderIds = $this->app['eccube.plugin.point.repository.pointstatus']->selectOrderIdsWithFixedByCustomer(
            $customer->getId()
        );
        $this->expected = $addOrderIds;
        $this->actual = $orderIds;
        $this->verify();
    }

    public function testSelectOrderIdsWithFixedByCustomerWithOtherCustomer()
    {
        $addOrderIds = array();

        // 準備：テスト対象会員のレコード
        $customer = $this->createCustomer();
        $order = $this->createOrder($customer);
        $this->addStatus($customer, $order);
        $this->fixStatus($order->getId());
        $addOrderIds[] = $order->getId();

        // 準備：テスト対象でない会員のレコード
        $noTargetCustomer = $this->createCustomer();
        $noTargetOrder = $this->createOrder($noTargetCustomer);
        $this->addStatus($noTargetCustomer, $noTargetOrder);
        $this->fixStatus($noTargetOrder->getId());

        // 検証
        $orderIds = $this->app['eccube.plugin.point.repository.pointstatus']->selectOrderIdsWithFixedByCustomer(
            $customer->getId()
        );
        $this->expected = $addOrderIds;
        $this->actual = $orderIds;
        $this->verify();
    }

    public function testSelectOrderIdsWithFixedByCustomerWithDelFlg()
    {
        $addOrderIds = array();

        // 準備：有効なレコード
        $customer = $this->createCustomer();
        for ($i = 0; $i < 3; $i++) {
            $order = $this->createOrder($customer);
            $this->addStatus($customer, $order);
            $this->fixStatus($order->getId());
            $addOrderIds[] = $order->getId();
        }

        // 準備：無効なレコード
        $delOrderId = $addOrderIds[1];
        $this->deleteStatus($delOrderId);
        // 無効化したレコードを期待結果から削除
        unset($addOrderIds[1]);
        $addOrderIds = array_merge($addOrderIds);

        // 検証
        $orderIds = $this->app['eccube.plugin.point.repository.pointstatus']->selectOrderIdsWithFixedByCustomer(
            $customer->getId()
        );
        $this->expected = $addOrderIds;
        $this->actual = $orderIds;
        $this->verify();
    }

    public function testIsFixStatusOnUnfixed()
    {
        $customer = $this->createCustomer();
        $order = $this->createOrder($customer);

        // 準備：ポイントステータスの追加
        $this->addStatus($customer, $order);

        // 検証
        $this->assertFalse(
            $this->app['eccube.plugin.point.repository.pointstatus']->isFixedStatus(
                $order
            )
        );
    }

    public function testIsFixStatusOnFixed()
    {
        $customer = $this->createCustomer();
        $order = $this->createOrder($customer);

        // 準備：ポイントステータスの追加
        $this->addStatus($customer, $order);
        $this->fixStatus($order->getId());

        // 検証
        $this->assertTrue(
            $this->app['eccube.plugin.point.repository.pointstatus']->isFixedStatus(
                $order
            )
        );
    }

    /**
     * ポイントステータスのレコードを追加する
     * @param Customer $customer
     * @param Order $order
     */
    private function addStatus($customer, $order)
    {
        $pointStatus = new PointStatus();
        $pointStatus
            ->setOrderId($order->getId())
            ->setCustomerId($customer->getId())
            ->setStatus(0)
            ->setDelFlg(0);

        $this->app['orm.em']->persist($pointStatus);
        $this->app['orm.em']->flush();
    }

    /**
     * 削除フラグをONにする
     * @param int $delOrderId 削除フラグをONにする対象の受注ID
     */
    private function deleteStatus($delOrderId)
    {
        /** @var PointStatus $status */
        $status = $this->app['eccube.plugin.point.repository.pointstatus']->findOneBy(array('order_id' => $delOrderId));
        $status->setDelFlg(1);
        $this->app['orm.em']->flush();
    }

    /**
     * 確定ステータスにする
     * @param int $orderId 確定ステータスにする対象の受注ID
     */
    private function fixStatus($orderId)
    {
        /** @var PointStatus $status */
        $status = $this->app['eccube.plugin.point.repository.pointstatus']->findOneBy(array('order_id' => $orderId));
        $status->setStatus(1);
        $this->app['orm.em']->flush();
    }
}

