<?php
/*
 * This file is part of the Sales Report plugin
 *
 * Copyright (C) 2016 LOCKON CO.,LTD. All Rights Reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\SalesReport\ServiceProvider;

use Silex\Application as BaseApplication;
use Silex\ServiceProviderInterface;
use Plugin\SalesReport\Service\SalesReportService;
use Plugin\SalesReport\Form\Type\SalesReportType;
use Eccube\Common\Constant;

// include log functions (for 3.0.0 - 3.0.11)
require_once __DIR__.'/../log.php';

/**
 * Class SalesReportServiceProvider.
 */
class SalesReportServiceProvider implements ServiceProviderInterface
{
    /**
     * register.
     *
     * @param BaseApplication $app
     */
    public function register(BaseApplication $app)
    {
        // 管理画面定義
        $admin = $app['controllers_factory'];
        // 強制SSL
        if ($app['config']['force_ssl'] == Constant::ENABLED) {
            $admin->requireHttps();
        }
        // Routingを追加
        $admin->match('/plugin/sales_report/term', '\\Plugin\\SalesReport\\Controller\\SalesReportController::term')
            ->bind('admin_plugin_sales_report_term');

        $admin->match('/plugin/sales_report/age', '\\Plugin\\SalesReport\\Controller\\SalesReportController::age')
            ->bind('admin_plugin_sales_report_age');

        $admin->match('/plugin/sales_report/product', '\\Plugin\\SalesReport\\Controller\\SalesReportController::product')
            ->bind('admin_plugin_sales_report_product');

        $admin->post('/plugin/sales_report/export/{type}', '\\Plugin\\SalesReport\\Controller\\SalesReportController::export')
            ->bind('admin_plugin_sales_report_export');

        $app->mount('/'.trim($app['config']['admin_route'], '/').'/', $admin);

        // Formの定義
        $app['form.types'] = $app->share($app->extend('form.types', function ($types) use ($app) {
            $types[] = new SalesReportType($app);

            return $types;
        }));

        // Serviceの定義
        $app['salesreport.service.sales_report'] = $app->share(function () use ($app) {
            return new SalesReportService($app);
        });

        // initialize logger (for 3.0.0 - 3.0.8)
        if (!method_exists('Eccube\Application', 'getInstance')) {
            eccube_log_init($app);
        }

        // メッセージ登録
        $file = __DIR__.'/../Resource/locale/message.'.$app['locale'].'.yml';
        if (file_exists($file)) {
            $app['translator']->addResource('yaml', $file, $app['locale']);
        }

        // サブナビの拡張
        $app['config'] = $app->share($app->extend('config', function ($config) {
            $nav = array(
                'id' => 'admin_plugin_sales_report',
                'name' => '売上集計',
                'has_child' => 'true',
                'icon' => 'cb-chart',
                'child' => array(
                    array(
                        'id' => 'admin_plugin_sales_report_term',
                        'url' => 'admin_plugin_sales_report_term',
                        'name' => '期間別集計',
                    ),
                    array(
                        'id' => 'admin_plugin_sales_report_product',
                        'url' => 'admin_plugin_sales_report_product',
                        'name' => '商品別集計',
                    ),
                    array(
                        'id' => 'admin_plugin_sales_report_age',
                        'url' => 'admin_plugin_sales_report_age',
                        'name' => '年代別集計',
                    ),
                ),
            );

            $config['nav'][] = $nav;

            return $config;
        }));
    }

    /**
     * boot.
     *
     * @param BaseApplication $app
     */
    public function boot(BaseApplication $app)
    {
    }
}
