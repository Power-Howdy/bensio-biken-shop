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
use Plugin\Point\Entity\PointInfo;

/**
 * Class PointInfoRepositoryTest
 *
 * @package Eccube\Tests\Repository
 */
class PointInfoRepositoryTest extends EccubeTestCase
{

    public function testGetLastInsertData()
    {
        $PointInfo = $this->app['eccube.plugin.point.repository.pointinfo']->getLastInsertData();
        // インストール時に初期データが投入されるため, null ではなく オブジェクトが返却されることを確認する.
        $this->assertNotNull($PointInfo);;
    }

    public function testSave(){
        $PointInfo = $this->createPointInfo();
        $this->app['eccube.plugin.point.repository.pointinfo']->save($PointInfo);

        $PointInfo2 = $this->app['eccube.plugin.point.repository.pointinfo']->getLastInsertData();
        $this->assertEquals($PointInfo->getPlgAddPointStatus(), $PointInfo2->getPlgAddPointStatus());
        $this->assertEquals($PointInfo->getPlgBasicPointRate(), $PointInfo2->getPlgBasicPointRate());
        $this->assertEquals($PointInfo->getPlgCalculationType(), $PointInfo2->getPlgCalculationType());
        $this->assertEquals($PointInfo->getPlgPointConversionRate(), $PointInfo2->getPlgPointConversionRate());
        $this->assertEquals($PointInfo->getPlgRoundType(), $PointInfo2->getPlgRoundType());
    }

    public function createPointInfo(){
        $PointInfo = new PointInfo();
        $PointInfo
            ->setPlgAddPointStatus(100)
            ->setPlgBasicPointRate(100)
            ->setPlgCalculationType(100)
            ->setPlgPointConversionRate(100)
            ->setPlgRoundType(100);
        return $PointInfo;
    }
}

