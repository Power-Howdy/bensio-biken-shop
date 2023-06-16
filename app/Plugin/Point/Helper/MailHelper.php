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
namespace Plugin\Point\Helper;

use Eccube\Application;
use Eccube\Entity\Order;

class MailHelper
{

    /** @var \Eccube\Application */
    public $app;


    /** @var \Eccube\Entity\BaseInfo */
    public $BaseInfo;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->BaseInfo = $app['eccube.repository.base_info']->get();
    }


    /**
     * ポイントでマイナス発生時にメール通知する。
     *
     * @param Order $Order
     * @param int $currentPoint
     * @param int $usePoint
     */
    public function sendPointNotifyMail(Order $Order, $currentPoint = 0, $usePoint = 0)
    {

        $body = $this->app->renderView('Point/Resource/template/admin/Mail/point_notify.twig', array(
            'Order' => $Order,
            'currentPoint' => $currentPoint,
            'usePoint' => abs($usePoint), // DBから取得した利用ポイントはマイナス値なので、絶対値で表示する
        ));

        $message = \Swift_Message::newInstance()
            ->setSubject('['.$this->BaseInfo->getShopName().'] ポイント通知')
            ->setFrom(array($this->BaseInfo->getEmail01() => $this->BaseInfo->getShopName()))
            ->setTo(array($this->BaseInfo->getEmail01()))
            ->setBcc($this->BaseInfo->getEmail01())
            ->setReplyTo($this->BaseInfo->getEmail03())
            ->setReturnPath($this->BaseInfo->getEmail04())
            ->setBody($body);

        $this->app->mail($message);
    }

}
