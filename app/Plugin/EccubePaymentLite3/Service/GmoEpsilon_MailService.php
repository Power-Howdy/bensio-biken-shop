<?php

namespace Plugin\EccubePaymentLite3\Service;

use Eccube\Application;
use Eccube\Entity\BaseInfo;
use Eccube\Entity\Order;
use Swift_Message;

class GmoEpsilon_MailService
{
    /** @var Application */
    public $app;


    /** @var BaseInfo */
    public $BaseInfo;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->BaseInfo = $app['eccube.repository.base_info']->get();
    }

    /**
     * Send order mail.
     * @param Order $Order
     * @param $arrOther
     * @return Swift_Message
     */
    public function sendOrderMail(Order $Order, $arrOther)
    {
        $defaultMailTemplate = $this->app['eccube.repository.mail_template']->find(1);

        $body = $this->app->renderView('EccubePaymentLite3/Twig/mail/epsilon_order.twig', array(
            'header' => $defaultMailTemplate->getHeader(),
            'footer' => $defaultMailTemplate->getFooter(),
            'Order' => $Order,
            'arrOther' => $arrOther,
        ));

        $message = Swift_Message::newInstance()
            ->setSubject('[' . $this->BaseInfo->getShopName() . '] ' . $defaultMailTemplate->getSubject())
            ->setFrom(array($this->BaseInfo->getEmail01() => $this->BaseInfo->getShopName()))
            ->setTo(array($Order->getEmail()))
            ->setBcc($this->BaseInfo->getEmail01())
            ->setReplyTo($this->BaseInfo->getEmail03())
            ->setReturnPath($this->BaseInfo->getEmail04())
            ->setBody($body);

        $this->app->mail($message);

        return $message;
    }

}
