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
 *  - 拡張元 : 商品購入確認
 *  - 拡張項目 : 合計金額・ポイント
 * Class FrontShopping
 * @package Plugin\Point\Event\WorkPlace
 */
class FrontShopping extends AbstractWorkPlace
{
    /**
     * フロント商品購入確認画面
     * - ポイント計算/購入金額合計計算
     * @param TemplateEvent $event
     * @return bool
     */
    public function createTwig(TemplateEvent $event)
    {
        $args = $event->getParameters();

        $Order = $args['Order'];
        $Customer = $Order->getCustomer();

        // ポイント利用画面で入力された利用ポイントを取得
        $usePoint = $this->app['eccube.plugin.point.repository.point']->getLatestPreUsePoint($Order);
        $usePoint = abs($usePoint);

        // 加算ポイントの取得
        $calculator = $this->app['eccube.plugin.point.calculate.helper.factory'];
        $calculator->setUsePoint($usePoint); // calculatorに渡す際は絶対値
        $calculator->addEntity('Order', $Order);
        $calculator->addEntity('Customer', $Customer);
        $addPoint = $calculator->getAddPointByOrder();

        if ($usePoint>0){
            $pointInfo = $this->app['eccube.plugin.point.repository.pointinfo']->getLastInsertData();

            $addPoint = $addPoint - intval($usePoint*($pointInfo->getPlgBasicPointRate())/100);
            if ($addPoint<0) $addPoint = 0;
        }

        // 受注明細がない場合にnullが返る. 通常では発生し得ないため. その場合は表示を行わない
        if (is_null($addPoint)) {
            return true;
        }

        // 現在の保有ポイント取得
        $currentPoint = $calculator->getPoint();

        // 会員のポイントテーブルにレコードがない場合はnullを返す. その場合は0で表示する
        if (is_null($currentPoint)) {
            $currentPoint = 0;
        }

        // ポイント基本情報を取得
        $PointInfo = $this->app['eccube.plugin.point.repository.pointinfo']->getLastInsertData();

        // ポイント表示用変数作成
        $point = array();
        $point['current'] = $currentPoint;
        $point['use'] = $usePoint;
        $point['add'] = $addPoint;
        $point['rate'] = $PointInfo->getPlgPointConversionRate();

        // 加算ポイント/利用ポイントを表示する
        $snippet = $this->app->renderView(
            'Point/Resource/template/default/Event/ShoppingConfirm/point_summary.twig',
            array(
                'point' => $point,
            )
        );
        $search = '<p id="summary_box__total_amount"';
        $this->replaceView($event, $snippet, $search);

        // ポイント利用画面へのボタンを表示する
        $snippet = $this->app->renderView(
            'Point/Resource/template/default/Event/ShoppingConfirm/use_point_button.twig',
            array(
                'point' => $point,
            )
        );
        $search = '<h2 class="heading02">お問い合わせ欄</h2>';
        $this->replaceView($event, $snippet, $search);
    }
}
