<?php

namespace Plugin\EccubePaymentLite3\Command;

use Plugin\EccubePaymentLite3\Util\PluginUtil;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * クレジットカード有効期限通知バッチ実行コマンド
 *
 * app/consoleに要追記
 * $console->add(new Plugin\EccubePaymentLite3\Command\CreditCardExpirationNoticeBatchCommand(new Eccube\Application()));
 *
 * crontab  ex. 0 0 * * * /usr/bin/php /var/www/html/eccube-3.0.5/app/console gmoepsilon:credit_card_expiration_notice_batch
 */
class CreditCardExpirationNoticeBatchCommand extends \Knp\Command\Command
{
    /**
     * @var \Eccube\Application
     */
    private $app;
    /**
     * Define URL for notify credit card expiration
     */
    const BASE_URL_BATCH_NOTIFY = 'https://site_url';

    /**
     * CreditCardExpirationNoticeBatchCommand constructor.
     * @param \Eccube\Application $app
     * @param null $name
     */
    public function __construct(\Eccube\Application $app, $name = null)
    {
        parent::__construct($name);
        $this->app = $app;

    }

    protected function configure()
    {
        $this->setName('gmoepsilon:credit_card_expiration_notice_batch')
             ->setDescription('Credit Card Expiration Notice');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->app->initialize();
        $this->app->initializePlugin();
        $this->app->boot();
        $date = new \DateTime();

        $this->app['monolog.gmoepsilon']->addInfo("=== Credit Card Expiration Notice Batch start ===");
        $output->writeln('=== Credit Card Expiration Notice Batch start ===');

        // Notify URL : https://SITE_URL/mypage/gmo_epsilon_credit_card
        $notifyUrl = CreditCardExpirationNoticeBatchCommand::BASE_URL_BATCH_NOTIFY.$this->app->path('paylite_mypage_credit_card_index');

        // Get list epsilon member has credit card expiration date is coming
        $EpsilonMemberList = $this->app['eccube.plugin.epsilon.service.get_customer_for_send_notice_mail']->getListEpsilonMember();
        if(count($EpsilonMemberList) > 0){
            foreach ($EpsilonMemberList as $EpsilonMember) {
                // Write log customer info
                $customerId = $EpsilonMember->getCustomer()->getId();
                $expirationDate = $EpsilonMember->getGmoEpsilonCreditCardExpirationDate()->format('Y/m/d');
                $this->app['eccube.plugin.epsilon.service.expiration_notice_mail']->sendMail($EpsilonMember->getCustomer(), $notifyUrl, $expirationDate);
                $this->app['monolog.gmoepsilon']->addInfo('***** Customer ID = ' . $customerId.' / Expiration Date '.$expirationDate.' *****');
                $output->writeln('***** Customer ID = '.$EpsilonMember->getCustomer()->getId().' / Expiration Date '.$expirationDate.' *****');

                // After send mail => update card_change_request_mail_send_date
                $EpsilonMember->setCardChangeRequestMailSendDate($date);
                $this->app['orm.em']->persist($EpsilonMember);
                $this->app['orm.em']->flush();
            }
        } else {
            $this->app['monolog.gmoepsilon']->addInfo('*** Credit Card Expiration Notice Batch not found target ***');
            $output->writeln('*** Credit Card Expiration Notice Batch not found target ***');
        }

        $this->app['monolog.gmoepsilon']->addInfo("=== Credit Card Expiration Notice Batch end ===");
        $output->writeln('=== Credit Card Expiration Notice Batch end ===');
    }
}
