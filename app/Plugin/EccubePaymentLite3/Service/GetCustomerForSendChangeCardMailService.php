<?php


namespace Plugin\EccubePaymentLite3\Service;


use Doctrine\ORM\EntityManagerInterface;
use Eccube\Application;
use Exception;
use Plugin\EccubePaymentLite3\Util\PluginUtil;


class GetCustomerForSendChangeCardMailService
{
    /** @var Application */
    public $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Get list Epsilon Member for send mail notify
     * @return mixed
     * @throws Exception
     */
    public function getListEpsilonMember()
    {
        // Get expiration date
        $objPlugin = PluginUtil::getInstance($this->app);
        $cardExpirationNotificationDays = $objPlugin->getSubData('card_expiration_notification_days');
        $lastDayOfThisMonth = new \DateTime('last day of this month 00:00:00');
        $expirationDate = $lastDayOfThisMonth->modify('- '.$cardExpirationNotificationDays.'day');
        $now = new \DateTime();
        // Get list epsilon member has credit card expiration date is coming
        $qb = $this->app['eccube.plugin.epsilon.repository.epsilon_member']->createQueryBuilder('em')->select('em');
        $qb
            ->where($qb->expr()->isNull('em.card_change_request_mail_send_date'))
            ->setParameter('now', $now)
            ->andWhere(':now > :expirationDate')
            ->setParameter('expirationDate', $expirationDate);
        return $qb->getQuery()->getResult();
    }
}
