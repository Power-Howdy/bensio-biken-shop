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
use Eccube\Tests\EccubeTestCase;

/**
 * Class PointCustomerRepositoryTest
 *
 * @package Eccube\Tests\Repository
 */
class PointCustomerRepositoryTest extends EccubeTestCase
{
    public function testSavePoint(){
        $Customer = $this->createCustomer();
        $PointCustomer = $this->app['eccube.plugin.point.repository.pointcustomer']->savePoint(100, $Customer);
        $this->expected = 100;
        $this->actual = $PointCustomer->getPlgPointCurrent();
        $this->verify();
    }

    public function testGetLastPointById(){
        $Customer = $this->createCustomer();
        $PointCustomer = $this->app['eccube.plugin.point.repository.pointcustomer']->savePoint(101, $Customer);
        $point = $this->app['eccube.plugin.point.repository.pointcustomer']->getLastPointById($Customer->getId());
        $this->expected = 101;
        $this->actual = $point;
        $this->verify();
    }

    public function testGetLastPointByIdNoResults(){
        $Customer = $this->createCustomer();
        $point = $this->app['eccube.plugin.point.repository.pointcustomer']->getLastPointById($Customer->getId());
        $this->expected = 0;
        $this->actual = $point;
        $this->verify();
    }

    public function testGetLastPointByIdException(){

        try {
            $this->app['eccube.plugin.point.repository.pointcustomer']->getLastPointById(null);
            $this->fail('Throwable to \InvalidArgumentException');
        } catch (\InvalidArgumentException $e) {
            $this->assertEquals('customer_id is empty.', $e->getMessage());
        }
    }
}

