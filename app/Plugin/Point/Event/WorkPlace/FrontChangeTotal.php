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

use Eccube\Event\EventArgs;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * フックポイント汎用処理具象クラス
 *  - 拡張元 : 商品購入確認
 *  - 拡張項目 : 住所変更、配送業者変更、支払い方法変更時に、合計金額がマイナスになるケースを検知し、ハンドリングを行う
 * Class FrontPayment
 * @package Plugin\Point\Event\WorkPlace
 */
class FrontChangeTotal extends AbstractWorkPlace
{
    /**
     * 通常はデータの保存を行うが、本処理では、合計金額判定とエラー処理
     * @param EventArgs $event
     * @return bool
     */
    public function save(EventArgs $event)
    {

        $this->app['monolog.point']->addInfo('save start');

        if ($event->hasArgument('Order')) {
            $Order =  $event->getArgument('Order');
        } else {
            // front.shopping.shipping.edit.completeでは、Orderエンティティが取得できないため.
            $Order = $this->app['eccube.service.shopping']->getOrder($this->app['config']['order_processing']);
        }
        $Customer = $Order->getCustomer();

        $calculator = $this->app['eccube.plugin.point.calculate.helper.factory'];
        $calculator->addEntity('Order', $Order);
        $calculator->addEntity('Customer', $Customer);

        // 合計金額マイナス確認
        if ($calculator->calculateTotalDiscountOnChangeConditions()) {
            $this->app->addError('ポイント利用時の合計金額がマイナスになったため、ポイントの利用をキャンセルしました。', 'front.request');
        }

        $this->app['monolog.point']->addInfo('save end');
    }
}
