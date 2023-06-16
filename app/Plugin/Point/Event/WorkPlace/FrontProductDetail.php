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
 *  - 拡張元 : 商品詳細
 *  - 拡張項目 : 画面表示・付与ポイント計算
 * Class FrontProductDetail
 * @package Plugin\Point\Event\WorkPlace
 */
class FrontProductDetail extends AbstractWorkPlace
{
    /**
     * 商品詳細画面に付与ポイント表示
     * @param TemplateEvent $event
     * @return bool
     */
    public function createTwig(TemplateEvent $event)
    {
        // 商品を取得
        $parameters = $event->getParameters();
        $Product = $parameters['Product'];

        // 商品の加算ポイントを取得する
        $calculator = $this->app['eccube.plugin.point.calculate.helper.factory'];
        $point = $calculator->getAddPointByProduct($Product);

        $snippet = $this->app->renderView(
            'Point/Resource/template/default/Event/ProductDetail/detail_point.twig',
            array(
                'point' => $point,
            )
        );

        $search = '<p id="detail_description_box__item_range_code"';
        $this->replaceView($event, $snippet, $search);
    }
}
