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

use Eccube\Entity\Customer;
use Eccube\Entity\Order;
use Eccube\Event\EventArgs;
use Eccube\Event\TemplateEvent;
use Plugin\Point\Entity\PointAbuse;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * フックポイント汎用処理具象クラス
 *  - 拡張元 : 商品購入完了
 *  - 拡張項目 : メール内容
 * Class FrontShoppingComplete
 * @package Plugin\Point\Event\WorkPlace
 */
class FrontShoppingComplete extends AbstractWorkPlace
{
    /**
     * ポイントログの保存
     *  - 仮付与ポイント
     *  - 確定ポイント判定
     *  - スナップショット保存
     *  - メール送信
     * @param EventArgs $event
     * @return bool
     * @throws UndefinedFunctionException
     */
    public function save(EventArgs $event)
    {
        $this->app['monolog.point']->addInfo('save start');

        $Order = $event->getArgument('Order');

        // 利用ポイントを登録
        $usePoint = $this->app['eccube.plugin.point.repository.point']->getLatestPreUsePoint($Order);
        $this->app['eccube.plugin.point.history.service']->refreshEntity();
        $this->app['eccube.plugin.point.history.service']->addEntity($Order);
        $this->app['eccube.plugin.point.history.service']->addEntity($Order->getCustomer());
        $this->app['eccube.plugin.point.history.service']->saveUsePoint($usePoint);

        // 保有ポイントのマイナスチェック（保有ポイント以上にポイントを利用していないか？）
        $calculateCurrentPoint = $this->calculateCurrentPoint($Order->getCustomer());
        if ($calculateCurrentPoint < 0) {
            $this->app['monolog.point']->addInfo('save current point', array(
                    'current point' => $calculateCurrentPoint,
                )
            );
            // ポイントがマイナスの時はメール送信
            $this->app['eccube.plugin.point.mail.helper']->sendPointNotifyMail($Order, $calculateCurrentPoint, $usePoint);
            // 保有ポイント以上にポイントを利用した受注であるということを記録
            $pointAbuse = new PointAbuse($Order->getId());
            $this->app['orm.em']->persist($pointAbuse);
            $this->app['orm.em']->flush($pointAbuse);
        }

        // 加算ポイントを登録
        $addPoint = $this->calculateAddPoint($Order, $usePoint);
        $this->app['eccube.plugin.point.history.service']->refreshEntity();
        $this->app['eccube.plugin.point.history.service']->addEntity($Order);
        $this->app['eccube.plugin.point.history.service']->addEntity($Order->getCustomer());
        $this->app['eccube.plugin.point.history.service']->saveAddPoint($addPoint);
        $this->app['eccube.plugin.point.history.service']->savePointStatus();

        // 加算ポイントのステータスを変更（ポイント設定が確定ステータス＝新規受注の場合）
        $pointInfo = $this->app['eccube.plugin.point.repository.pointinfo']->getLastInsertData();
        if ($pointInfo->getPlgAddPointStatus() == $this->app['config']['order_new']) {
            $this->app['eccube.plugin.point.history.service']->fixPointStatus();
        }

        // 保有ポイントを再計算して、会員の保有ポイントを更新する
        $calculateCurrentPoint = $this->calculateCurrentPoint($Order->getCustomer());
        $this->app['eccube.plugin.point.repository.pointcustomer']->savePoint(
            $calculateCurrentPoint,
            $Order->getCustomer()
        );

        // ログ
        $this->app['monolog.point']->addInfo('save add point', array(
                'customer_id' => $Order->getCustomer()->getId(),
                'order_id' => $Order->getId(),
                'current point' => $calculateCurrentPoint,
                'add point' => $addPoint,
                'use point' => $usePoint,
            )
        );
        // ポイント保存用変数作成
        $point = array();
        $point['current'] = $calculateCurrentPoint;
        $point['use'] = $usePoint * -1;
        $point['add'] = $addPoint;
        $this->app['eccube.plugin.point.history.service']->refreshEntity();
        $this->app['eccube.plugin.point.history.service']->addEntity($Order);
        $this->app['eccube.plugin.point.history.service']->addEntity($Order->getCustomer());
        $this->app['eccube.plugin.point.history.service']->saveSnapShot($point);

        $this->app['monolog.point']->addInfo('save end');
    }
/**
     * payment integrate
     * @param Order $Order
     * @return bool
     * @throws UndefinedFunctionException
     */
    public function savefrompayment($Order)
    {
        
        $this->app['monolog.point']->addInfo('save start(savefrompayment)');

        // 利用ポイントを登録
        $usePoint = $this->app['eccube.plugin.point.repository.point']->getLatestPreUsePoint($Order);
        $this->app['eccube.plugin.point.history.service']->refreshEntity();
        $this->app['eccube.plugin.point.history.service']->addEntity($Order);
        $this->app['eccube.plugin.point.history.service']->addEntity($Order->getCustomer());
        $this->app['eccube.plugin.point.history.service']->saveUsePoint($usePoint);

        // 保有ポイントのマイナスチェック（保有ポイント以上にポイントを利用していないか？）
        $calculateCurrentPoint = $this->calculateCurrentPoint($Order->getCustomer());
        if ($calculateCurrentPoint < 0) {
            $this->app['monolog.point']->addInfo('save current point', array(
                    'current point' => $calculateCurrentPoint,
                )
            );
            // ポイントがマイナスの時はメール送信
            $this->app['eccube.plugin.point.mail.helper']->sendPointNotifyMail($Order, $calculateCurrentPoint, $usePoint);
            // 保有ポイント以上にポイントを利用した受注であるということを記録
            $pointAbuse = new PointAbuse($Order->getId());
            $this->app['orm.em']->persist($pointAbuse);
            $this->app['orm.em']->flush($pointAbuse);
        }
        // 加算ポイントを登録
        $addPoint = $this->calculateAddPoint($Order, $usePoint);
        $this->app['eccube.plugin.point.history.service']->refreshEntity();
        $this->app['eccube.plugin.point.history.service']->addEntity($Order);
        $this->app['eccube.plugin.point.history.service']->addEntity($Order->getCustomer());
        $this->app['eccube.plugin.point.history.service']->saveAddPoint($addPoint);
        $this->app['eccube.plugin.point.history.service']->savePointStatus();

        // 加算ポイントのステータスを変更（ポイント設定が確定ステータス＝新規受注の場合）
        $pointInfo = $this->app['eccube.plugin.point.repository.pointinfo']->getLastInsertData();
        // if ($pointInfo->getPlgAddPointStatus() == $this->app['config']['order_new']) {
            $this->app['eccube.plugin.point.history.service']->fixPointStatus();
        // }
        // 保有ポイントを再計算して、会員の保有ポイントを更新する
        $calculateCurrentPoint = $this->calculateCurrentPoint($Order->getCustomer());

        $this->app['eccube.plugin.point.repository.pointcustomer']->savePoint(
            $calculateCurrentPoint,
            $Order->getCustomer()
        );

        // ログ
        $this->app['monolog.point']->addInfo('save add point(savefrompayment)', array(
                'customer_id' => $Order->getCustomer()->getId(),
                'order_id' => $Order->getId(),
                'current point' => $calculateCurrentPoint,
                'add point' => $addPoint,
                'use point' => $usePoint,
            )
        );
        // ポイント保存用変数作成
        $point = array();
        $point['current'] = $calculateCurrentPoint;
        $point['use'] = $usePoint * -1;
        $point['add'] = $addPoint;
        $this->app['monolog.point']->addInfo('ポイント保存用変数作成(savefrompayment) >>> ', $point);
        $this->app['eccube.plugin.point.history.service']->refreshEntity();
        $this->app['eccube.plugin.point.history.service']->addEntity($Order);
        $this->app['eccube.plugin.point.history.service']->addEntity($Order->getCustomer());
        $this->app['eccube.plugin.point.history.service']->saveSnapShot($point);

        $this->app['monolog.point']->addInfo('save end(savefrompayment)');
	
	//add point calc of member @created by kastumoto
    }

    /**
     * Twig拡張処理
     * @param TemplateEvent $event
     * @return void
     */
    public function createTwig(TemplateEvent $event)
    {
        // 不適切な受注記録に、今回の受注が含まれているか？
        $parameters = $event->getParameters();
        $orderId = $parameters['orderId'];
        $result = $this->app['eccube.plugin.point.repository.pointabuse']->findBy(array('order_id' => $orderId));
        if (empty($result)) {
            return;
        }

        // エラーメッセージの挿入
        $search = '{% endblock %}';
        $script = <<<__EOL__
{% block javascript %}
            <script>
            $(function() {
                $("#deliveradd_input_box__message").children("h2.heading01").remove();
                $("#deliveradd_input_box__message").prepend('<div class="message"><p class="errormsg bg-danger">ご注文中に問題が発生した可能性があります。お手数ですがお問い合わせをお願いします。(受注番号：{{ orderId }})</p></div>');
            });
            </script>
{% endblock %}
__EOL__;

        $replace = $search.$script;
        $source = str_replace($search, $replace, $event->getSource());
        $event->setSource($source);
    }

    /**
     * 会員の保有ポイントを計算する.
     *
     * TODO: 他のクラスでも同様の処理をしているので共通化したほうが良い
     * @param Customer $Customer
     * @return int
     */
    private function calculateCurrentPoint($Customer)
    {
        $orderIds = $this->app['eccube.plugin.point.repository.pointstatus']->selectOrderIdsWithFixedByCustomer(
            $Customer->getId()
        );
        $calculateCurrentPoint = $this->app['eccube.plugin.point.repository.point']->calcCurrentPoint(
            $Customer->getId(),
            $orderIds
        );

        return $calculateCurrentPoint;
    }

    /**
     * 加算ポイントを算出する.
     *
     * @param Order $Order
     * @param int $usePoint
     * @return int
     */
    private function calculateAddPoint($Order, $usePoint)
    {
        $calculator = $this->app['eccube.plugin.point.calculate.helper.factory'];
        $calculator->addEntity('Order', $Order);
        $calculator->addEntity('Customer', $Order->getCustomer());
        $calculator->setUsePoint($usePoint * -1);

        $addPoint = $calculator->getAddPointByOrder();
        if (is_null($addPoint)) {
            $addPoint = 0;
        }

		$usePoint = abs($usePoint);
	    if ($usePoint>0){
            $pointInfo = $this->app['eccube.plugin.point.repository.pointinfo']->getLastInsertData();
            $pointInfo->getPlgBasicPointRate();
            $addPoint = $addPoint - intval($usePoint*($pointInfo->getPlgBasicPointRate())/100);
			
            if ($addPoint<0) $addPoint = 0;
        }

        return $addPoint;
    }
}
