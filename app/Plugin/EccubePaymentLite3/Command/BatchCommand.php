<?php

namespace Plugin\EccubePaymentLite3\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

/**
 * 定期受注バッチ実行コマンド
 *
 * app/consoleに要追記
 * $console->add(new Plugin\EccubePaymentLite3\Command\BatchCommand(new Eccube\Application()));
 *
 * crontab  ex. 0 0 * * * /usr/bin/php /var/www/html/eccube-3.0.5/app/console gmoepsilon:batch
 */
class BatchCommand extends \Knp\Command\Command
{

    private $app;

    public function __construct(\Eccube\Application $app, $name = null)
    {
        parent::__construct($name);
        $this->app = $app;
    }

    protected function configure()
    {
        $this->setName('gmoepsilon:batch')
             ->setDescription('定期受注バッチ処理');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->app->initialize();
        $this->app->initializePlugin();
        $this->app->boot();

        $softDeleteFilter = $this->app['orm.em']->getFilters()->getFilter('soft_delete');
        $softDeleteFilter->setExcludes(array(
            'Eccube\Entity\Order'
        ));

        $this->app['monolog.gmoepsilon']->addInfo('RegularOrder Batch start.');
        // 対象の定期受注を取得
        $targetRegularOrders = $this->app['eccube.plugin.epsilon.repository.regular_order']->getTargetRegularOrderId();
        if (empty($targetRegularOrders)) {
            $this->app['monolog.gmoepsilon']->addInfo('RegularOrder Batch not found target.');
        } else {
            // 受注作成
            foreach ($targetRegularOrders as $RegularOrder) {
                $this->app['eccube.plugin.epsilon.service.regular']->registOrder($RegularOrder->getId());
                $this->app['monolog.gmoepsilon']->addInfo('RegularOrder Batch create order by regular_order_id = ' . $RegularOrder->getId());
            }
        }

        $this->app['monolog.gmoepsilon']->addInfo('RegularOrder Batch end.');
    }
}
