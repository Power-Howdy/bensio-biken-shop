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
namespace Eccube\Tests\Helper\PointHistoryHelper;

use Eccube\Application;
use Eccube\Tests\EccubeTestCase;
use Plugin\Point\Entity\Point;
use Plugin\Point\Entity\PointInfo;
use Plugin\Point\Helper\PointHistoryHelper\PointHistoryHelper;

/**
 * Class PointHistoryHelperTest
 *
 * @package Eccube\Tests\Helper\PointHistoryHelper
 */
class PointHistoryHelperTest extends EccubeTestCase
{

    public function setUp()
    {
        parent::setUp();
        $this->Customer = $this->createCustomer();
        $this->Order = $this->createOrder($this->Customer);
    }

    /**
     * PointStatus のレコードが存在しない状態で fixPointStatus() をコールするテスト.
     */
    public function testFixPointStatusWithInitialOrder()
    {
        $this->app['eccube.plugin.point.history.service']->addEntity($this->Order);
        $this->app['eccube.plugin.point.history.service']->addEntity($this->Order->getCustomer());
        $this->app['eccube.plugin.point.history.service']->fixPointStatus();

        $pointStatus = $this->app['eccube.plugin.point.repository.pointstatus']->findOneBy(
            array('order_id' => $this->Order->getId())
        );

        $this->expected = $this->Customer->getId();
        $this->actual = $pointStatus->getCustomerId();
        $this->verify();

        $this->expected = $this->app['eccube.plugin.point.repository.pointstatus']->getFixStatusValue();
        $this->actual = $pointStatus->getStatus();
        $this->verify();
    }
}
