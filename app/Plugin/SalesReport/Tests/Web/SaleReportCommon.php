<?php
/*
 * This file is part of the Sales Report plugin
 *
 * Copyright (C) 2016 LOCKON CO.,LTD. All Rights Reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\SalesReport\Tests\Web;

use Eccube\Tests\Web\Admin\AbstractAdminWebTestCase;
use Eccube\Common\Constant;

/**
 * Class SaleReportCommon.
 */
class SaleReportCommon extends AbstractAdminWebTestCase
{
    /**
     * Set up function.
     */
    public function setUp()
    {
        parent::setUp();
        $this->deleteAllRows(array('dtb_order_detail'));
    }

    /**
     * createCustomerByNumber.
     *
     * @param int $number
     *
     * @return array
     */
    public function createCustomerByNumber($number = 5)
    {
        $arrCustomer = array();
        $current = new \DateTime();
        for ($i = 0; $i < $number; ++$i) {
            $email = 'customer0'.$i.'@mail.com';
            $age = rand(10, 50);
            $age = $current->modify("-$age years");
            $Customer = $this->createCustomer($email);
            $arrCustomer[] = $Customer->getId();
            $Customer->setBirth($age);
            $this->app['orm.em']->persist($Customer);
            $this->app['orm.em']->flush($Customer);
        }

        return $arrCustomer;
    }

    /**
     * createOrderByCustomer.
     *
     * @param int $number
     *
     * @return array $arrOrder
     */
    public function createOrderByCustomer($number = 5)
    {
        $arrCustomer = $this->createCustomerByNumber($number);
        $current = new \DateTime();
        $arrOrder = array();
        for ($i = 0; $i < count($arrCustomer); ++$i) {
            $Customer = $this->app['eccube.repository.customer']->find($arrCustomer[$i]);
            $Order = $this->createOrder($Customer);
            $Order->setOrderStatus($this->app['eccube.repository.order_status']->find($this->app['config']['order_new']));
            $Order->setOrderDate($current);
            $arrOrder[] = $Order;
            $this->app['orm.em']->persist($Order);
            $this->app['orm.em']->flush($Order);
        }

        return $arrOrder;
    }

    /**
     * delete product.
     *
     * @param \Eccube\Entity\Order $Order
     */
    public function deleteProduct($Order)
    {
        foreach ($Order->getOrderDetails() as $OrderDetail) {
            $Product = $OrderDetail->getProduct();
            $ProductClasses = $Product->getProductClasses();
            $Product->setDelFlg(Constant::ENABLED);
            foreach ($ProductClasses as $ProductClass) {
                $ProductClass->setDelFlg(Constant::ENABLED);
                $Product->removeProductClass($ProductClass);
                $this->app['orm.em']->persist($ProductClass);
                $this->app['orm.em']->flush($ProductClass);
            }
            $this->app['orm.em']->persist($Product);
            $this->app['orm.em']->flush($Product);
        }
    }

    /**
     * change order detail.
     *
     * @param array $Orders
     */
    public function changeOrderDetail($Orders)
    {
        foreach ($Orders as $Order) {
            foreach ($Order->getOrderDetails() as $OrderDetail) {
                /* @var \Eccube\Entity\OrderDetail $OrderDetail */
                $OrderDetail->setPrice(500);
                $OrderDetail->setQuantity(1);
                $this->app['orm.em']->persist($OrderDetail);
                $this->app['orm.em']->flush($OrderDetail);
            }
        }
    }
}
