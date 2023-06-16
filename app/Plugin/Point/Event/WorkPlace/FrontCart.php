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

namespace Plugin\Point\Event\WorkPlace;

use Eccube\Event\TemplateEvent;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * フックポイント汎用処理具象クラス
 *  - 拡張元 : カート
 *  - 拡張項目 : 画面表示
 * Class FrontCart
 * @package Plugin\Point\Event\WorkPlace
 */
class FrontCart extends AbstractWorkPlace
{
    /**
     * カートページにポイント情報を表示
     *
     * @param TemplateEvent $event
     * @return bool
     */
    public function createTwig(TemplateEvent $event)
    {
        // ポイント情報基本設定を取得
        $PointInfo = $this->app['eccube.plugin.point.repository.pointinfo']->getLastInsertData();
        $pointRate = $PointInfo->getPlgPointConversionRate();

        $point = array();
        $point['rate'] = $pointRate;

        if ($this->app->isGranted('ROLE_USER')) {
            $calculator = $this->app['eccube.plugin.point.calculate.helper.factory'];
            $Customer = $this->app->user();
            $parameters = $event->getParameters();
            $calculator->addEntity('Customer', $Customer);
            $calculator->addEntity('Cart', $parameters['Cart']);

            // 現在の保有ポイント
            $currentPoint = $calculator->getPoint();
            // カートの加算ポイント
            $addPoint = $calculator->getAddPointByCart();
            // getPointはnullを返す場合がある.
            $point['current'] = is_null($currentPoint) ? 0 : $currentPoint;
            $point['add'] = $addPoint;

            $template = 'Point/Resource/template/default/Event/Cart/point_box.twig';
        } else {
            $template = 'Point/Resource/template/default/Event/Cart/point_box_no_customer.twig';
        }

        $snippet = $this->app->renderView($template, array('point' => $point));

        $search = '<div id="cart_item_list"';
        $this->replaceView($event, $snippet, $search);
    }
}
