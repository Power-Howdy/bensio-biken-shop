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
use Eccube\Event\TemplateEvent;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * フックポイント汎用処理具象クラス
 *  - 拡張元 : メール通知
 * Class AdminOrderMail
 *
 * @package Plugin\Point\Event\WorkPlace
 */
class  AdminOrderMail extends AbstractWorkPlace
{

    /**
     * 加算ポイント表示
     *
     * @param TemplateEvent $event
     * @return bool
     */
    public function createTwig(TemplateEvent $event)
    {

        $args = $event->getParameters();

        if (array_key_exists('Order', $args)) {
            // 個別メール通知
            $Order = $args['Order'];

        } else {
            // メール一括通知
            $ids = $args['ids'];

            $tmp = explode(',', $ids);

            $Order = $this->app['eccube.repository.order']->find($tmp[0]);
        }

        $Customer = $Order->getCustomer();
        if (empty($Customer)) {
            return false;
        }

        $body = $args['body'];

        // 利用ポイント取得
        $usePoint = $this->app['eccube.plugin.point.repository.point']->getLatestUsePoint($Order);
        $usePoint = abs($usePoint);

        // 加算ポイント取得.
        $addPoint = $this->app['eccube.plugin.point.repository.point']->getLatestAddPointByOrder($Order);

        $body = $this->getBody($body, $usePoint, $addPoint);

        $args['body'] = $body;

        $event->setParameters($args);

    }


    /**
     * 加算ポイント表示
     *
     * @param EventArgs $event
     * @return bool
     */
    public function save(EventArgs $event)
    {

        $this->app['monolog.point.admin']->addInfo('save start');


        $MailHistories = array();
        if ($event->hasArgument('Order')) {
            // 個別メール通知
            $Order = $event->getArgument('Order');
            $MailHistory = $event->getArgument('MailHistory');

            $Customer = $Order->getCustomer();
            if (empty($Customer)) {
                return false;
            }

            $MailHistories[] = $MailHistory;

        } else {
            // メール一括通知

            $ids = $event->getRequest()->get('ids');

            $ids = explode(',', $ids);

            foreach ($ids as $value) {

                $Order = $this->app['eccube.repository.order']->find($value);
                $Customer = $Order->getCustomer();
                if (empty($Customer)) {
                    continue;
                }

                $MailHistory = $this->app['eccube.repository.mail_history']->findOneBy(array('Order' => $Order), array('id' => 'DESC'));

                if (!$MailHistory) {
                    continue;
                }

                $MailHistories[] = $MailHistory;

            }

        }


        foreach ($MailHistories as $MailHistory) {

            $body = $MailHistory->getMailBody();

            $Order = $MailHistory->getOrder();

            // 利用ポイント取得
            $usePoint = $this->app['eccube.plugin.point.repository.point']->getLatestUsePoint($Order);
            $usePoint = abs($usePoint);

            // 加算ポイント取得.
            $addPoint = $this->app['eccube.plugin.point.repository.point']->getLatestAddPointByOrder($Order);

            $body = $this->getBody($body, $usePoint, $addPoint);

            // メッセージにメールボディをセット
            $MailHistory->setMailBody($body);

            $this->app['orm.em']->flush($MailHistory);
        }


        $this->app['monolog.point.admin']->addInfo('save end');
    }


    /**
     * 本文を置換
     *
     * @param $body
     * @param $usePoint
     * @param $addPoint
     * @return mixed
     */
    private function getBody($body, $usePoint, $addPoint)
    {

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
        return preg_replace('/'.$search[0][0].'/u', $replace, $body);

    }

}
