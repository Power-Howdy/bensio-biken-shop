<?php

namespace Plugin\Point\Tests\Util;

/**
 * ポイントテストケースのユーティリティ.
 *
 * 何故か abstract class を作るとテストに失敗するため、汎用的なメソッドを static で提供する.
 *
 * @author Kentaro Ohkouchi
 */
class PointTestUtil {

    /**
     * 会員の保有ポイントを返す.
     *
     * @see Plugin\Point\Event\WorkPlace\FrontShoppingComplete::calculateCurrentPoint()
     */
    public static function calculateCurrentPoint($Customer, $app)
    {
        $orderIds = $app['eccube.plugin.point.repository.pointstatus']->selectOrderIdsWithFixedByCustomer(
            $Customer->getId()
        );
        $calculateCurrentPoint = $app['eccube.plugin.point.repository.point']->calcCurrentPoint(
            $Customer->getId(),
            $orderIds
        );
        return $calculateCurrentPoint;
    }

    /**
     * 会員の保有ポイントを設定する.
     */
    public static function saveCustomerPoint($Customer, $currentPoint, $app)
    {
        // 手動設定ポイントを登録
        $app['eccube.plugin.point.history.service']->refreshEntity();
        $app['eccube.plugin.point.history.service']->addEntity($Customer);
        $app['eccube.plugin.point.history.service']->saveManualpoint($currentPoint);
        $point = array();
        $point['current'] = $currentPoint;
        $point['use'] = 0;
        $point['add'] = $currentPoint;

        // 手動設定ポイントのスナップショット登録
        $app['eccube.plugin.point.history.service']->refreshEntity();
        $app['eccube.plugin.point.history.service']->addEntity($Customer);
        $app['eccube.plugin.point.history.service']->saveSnapShot($point);
        // 保有ポイントを登録
        $app['eccube.plugin.point.repository.pointcustomer']->savePoint(
            $currentPoint,
            $Customer
        );
    }
}
