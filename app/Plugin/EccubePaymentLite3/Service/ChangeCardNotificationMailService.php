<?php

namespace Plugin\EccubePaymentLite3\Service;

use Eccube\Application;
use Eccube\Entity\BaseInfo;
use Eccube\Entity\Customer;

class ChangeCardNotificationMailService
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
     * Init mailer for batch
     */
    public function initMailerBatch(){
        $paths = array();
        $paths[] = $this->app['config']['plugin_realdir'];
        $this->app['twig.loader']->addLoader(new \Twig_Loader_Filesystem($paths));
        $this->app['swiftmailer.use_spool'] = false;
    }

    /**
     * Send notify mail.
     * @param Customer $Customer
     * @param $notifyUrl
     * @param $expireDateTime
     * @return \Swift_Message
     */
    public function sendMail(Customer $Customer, $notifyUrl, $expireDateTime)
    {
        $this->initMailerBatch();
        $templateFile = 'EccubePaymentLite3/Twig/mail/expiration_notice_mail.twig';
        $mailTemplate = $this->app['eccube.repository.mail_template']->findOneBy( array(
                    'file_name' => $templateFile)
        );
        $body = $this->app['twig']->render($mailTemplate->getFileName(), array(
            'BaseInfo' => $this->BaseInfo,
            'Customer' => $Customer,
            'notifyUrl' => $notifyUrl,
            'expireDateTime' => $expireDateTime,
        ));

        $message = \Swift_Message::newInstance()
            ->setSubject('[' . $this->BaseInfo->getShopName() . '] ' . $mailTemplate->getSubject())
            ->setFrom(array($this->BaseInfo->getEmail01() => $this->BaseInfo->getShopName()))
            ->setTo(array($Customer->getEmail()))
            ->setBcc($this->BaseInfo->getEmail01())
            ->setReplyTo($this->BaseInfo->getEmail03())
            ->setReturnPath($this->BaseInfo->getEmail04())
            ->setBody($body);

        $count = $this->app->mail($message);
        log_info('受注メール送信完了', array('count' => $count));

        return $message;
    }

}
