<?php
/*
 * This file is part of Receipt Pdf plugin
 *
 * Copyright (C) 2018 NinePoint Co. LTD. All Rights Reserved.
 *
 * Copyright (C) 2016 LOCKON CO.,LTD. All Rights Reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\ReceiptPdf\ServiceProvider;

use Eccube\Common\Constant;
use Plugin\ReceiptPdf\Event\ReceiptPdf;
use Plugin\ReceiptPdf\Event\ReceiptPdfLegacy;
use Plugin\ReceiptPdf\Form\Type\ReceiptPdfType;
use Plugin\ReceiptPdf\Service\ReceiptPdfService;
use Plugin\ReceiptPdf\Util\Version;
use Silex\Application as BaseApplication;
use Silex\ServiceProviderInterface;

// include log functions (for 3.0.0 - 3.0.11)
require_once __DIR__.'/../log.php';

/**
 * Class ReceiptPdfServiceProvider.
 */
class ReceiptPdfServiceProvider implements ServiceProviderInterface
{
    /**
     * Register service function.
     *
     * @param BaseApplication $app
     */
    public function register(BaseApplication $app)
    {
        // Repository
        $app['ReceiptPdf.repository.receipt_pdf'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Plugin\ReceiptPdf\Entity\ReceiptPdf');
        });

        // Order pdf event
        $app['ReceiptPdf.event.receipt_pdf'] = $app->share(function () use ($app) {
            return new ReceiptPdf($app);
        });

        // Order pdf legacy event
        $app['ReceiptPdf.event.receipt_pdf_legacy'] = $app->share(function () use ($app) {
            return new ReceiptPdfLegacy($app);
        });

        // ============================================================
        // コントローラの登録
        // ============================================================
        // 管理画面定義
        $admin = $app['controllers_factory'];
        // 強制SSL
        if ($app['config']['force_ssl'] == Constant::ENABLED) {
            $admin->requireHttps();
        }
        // 帳票の作成
        $admin->match('/plugin/Receipt-pdf', '\\Plugin\\ReceiptPdf\\Controller\\ReceiptPdfController::index')
            ->bind('plugin_admin_receipt_pdf');

        // PDFファイルダウンロード
        $admin->post('/plugin/Receipt-pdf/download', '\\Plugin\\ReceiptPdf\\Controller\\ReceiptPdfController::download')
            ->bind('plugin_admin_receipt_pdf_download');

        $app->mount('/'.trim($app['config']['admin_route'], '/').'/', $admin);

        // ============================================================
        // Formの登録
        // ============================================================
        // 型登録
        $app['form.types'] = $app->share($app->extend('form.types', function ($types) use ($app) {
            $types[] = new ReceiptPdfType($app);

            return $types;
        }));

        // -----------------------------
        // サービスの登録
        // -----------------------------
        // 帳票作成
        $app['ReceiptPdf.service.receipt_pdf'] = $app->share(function () use ($app) {
            return new ReceiptPdfService($app);
        });

        // ============================================================
        // メッセージ登録
        // ============================================================
        $file = __DIR__.'/../Resource/locale/message.'.$app['locale'].'.yml';
        if (file_exists($file)) {
            $app['translator']->addResource('yaml', $file, $app['locale']);
        }

        // initialize logger (for 3.0.0 - 3.0.8)
        if (!Version::isSupportMethod()) {
            eccube_log_init($app);
        }
        $app['monolog.logger.ReceiptPdf'] = $app->share(function ($app) {
            $config = array(
                'name' => 'ReceiptPdf',
                'filename' => 'ReceiptPdfLog',
                'delimiter' => '_',
                'dateformat' => 'Y-m-d',
                'log_level' => 'INFO',
                'action_level' => 'ERROR',
                'passthru_level' => 'INFO',
                'max_files' => '50',
                'log_dateformat' => 'Y-m-d H:i:s,u',
                'log_format' => '[%datetime%] %channel%.%level_name% [%session_id%] [%uid%] [%user_id%] [%class%:%function%:%line%] - %message% %context% %extra% [%method%, %url%, %ip%, %referrer%, %user_agent%]',
            );
            return $app['eccube.monolog.factory']($config);
        });
    }

    /**
     * Boot function.
     *
     * @param BaseApplication $app
     */
    public function boot(BaseApplication $app)
    {
    }

}
