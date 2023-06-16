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
 *  - 拡張元 : 受注メール
 *  - 拡張項目 : メール内容
 * Class ServiceMail
 *
 * @package Plugin\Point\Event\WorkPlace
 */
class ServiceMail extends AbstractWorkPlace
{

    /**
     * メール本文の置き換え
     *
     * @param EventArgs $event
     * @return bool
     */
    public function save(EventArgs $event)
    {

        $this->app['monolog.point']->addInfo('save start(Service Mail)');

        // 基本情報の取得
        $message = $event->getArgument('message');
        $order = $event->getArgument('Order');

        // 必要情報判定
        if (empty($message) || empty($order)) {
            return false;
        }

        $customer = $order->getCustomer();
        if (empty($customer)) {
            return false;
        }


        // 計算ヘルパーの取得
        $calculator = $this->app['eccube.plugin.point.calculate.helper.factory'];

        // 利用ポイントの取得と設定
        $usePoint = $this->app['eccube.plugin.point.repository.point']->getLatestUsePoint($order);
        $usePoint = abs($usePoint);

        $calculator->setUsePoint($usePoint);
        // 計算に必要なエンティティの設定
        $calculator->addEntity('Order', $order);
        $calculator->addEntity('Customer', $customer);

        // 計算値取得
        $addPoint = $this->app['eccube.plugin.point.repository.point']->getLatestAddPointByOrder($order);

        $this->app['monolog.point']->addInfo('save add point(Service Mail)', array(
                'customer_id' => $customer->getId(),
                'order_id' => $order->getId(),
                'add point' => $addPoint,
                'use point' => $usePoint,
            )
        );

        // メールボディ取得
        $body = $message->getBody();

        // 情報置換用のキーを取得
        $search = array();
        preg_match_all('/合　計.*\\n/u', $body, $search);

        // メール本文置換
        $snippet = PHP_EOL;
        $snippet .= PHP_EOL;
        $snippet .= '***********************************************'.PHP_EOL;
        $snippet .= '　ポイント情報                                 '.PHP_EOL;
        $snippet .= '***********************************************'.PHP_EOL;
        $snippet .= PHP_EOL;
        $snippet .= '利用ポイント：'.number_format($usePoint).' pt'.PHP_EOL;
        $snippet .= '加算ポイント：'.number_format($addPoint).' pt'.PHP_EOL;
        $snippet .= PHP_EOL;
        $replace = $search[0][0].$snippet;
        $body = preg_replace('/'.$search[0][0].'/u', $replace, $body);

        // メッセージにメールボディをセット
        $message->setBody($body);

        $this->app['monolog.point']->addInfo('save end(Service Mail)');

    }
}
