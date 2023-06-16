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
namespace Plugin\Point\ServiceProvider;

use Eccube\Application;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\FingersCrossed\ErrorLevelActivationStrategy;
use Monolog\Handler\FingersCrossedHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\ProcessIdProcessor;
use Monolog\Processor\WebProcessor;
use Plugin\Point\Helper\MailHelper;
use Plugin\Point\Helper\PointCalculateHelper\PointCalculateHelper;
use Plugin\Point\Helper\PointHistoryHelper\PointHistoryHelper;
use Silex\Application as BaseApplication;
use Silex\ServiceProviderInterface;
use Symfony\Bridge\Monolog\Logger;

/**
 * Class PointServiceProvider
 * @package Plugin\Point\ServiceProvider
 */
class PointServiceProvider implements ServiceProviderInterface
{
    /**
     * サービス登録処理
     * @param BaseApplication $app
     */
    public function register(BaseApplication $app)
    {
        /**
         * ルーティング登録
         * 管理画面 > 設定 > 基本情報設定 > ポイント基本情報設定画面
         */
        $app->match(
            '/'.$app['config']['admin_route'].'/point/setting',
            'Plugin\Point\Controller\AdminPointController::index'
        )->bind('point_info');

        /**
         * ルーティング登録
         * フロント画面 > 商品購入確認画面
         */
        $app->match(
            '/shopping/use_point',
            'Plugin\Point\Controller\FrontPointController::usePoint'
        )->bind('point_use');

        /**
         * レポジトリ登録
         */
        $app['eccube.plugin.point.repository.point'] = $app->share(
            function () use ($app) {
                return $app['orm.em']->getRepository('Plugin\Point\Entity\Point');
            }
        );

        /** ポイントステータステーブル用リポジトリ */
        $app['eccube.plugin.point.repository.pointstatus'] = $app->share(
            function () use ($app) {
                return $app['orm.em']->getRepository('Plugin\Point\Entity\PointStatus');
            }
        );

        /** 不適切な受注記録テーブル用リポジトリ */
        $app['eccube.plugin.point.repository.pointabuse'] = $app->share(
            function () use ($app) {
                return $app['orm.em']->getRepository('Plugin\Point\Entity\PointAbuse');
            }
        );

        /** ポイント機能基本情報テーブル用リポジトリ */
        $app['eccube.plugin.point.repository.pointinfo'] = $app->share(
            function () use ($app) {
                return $app['orm.em']->getRepository('Plugin\Point\Entity\PointInfo');
            }
        );

        /** ポイント会員情報テーブル */
        $app['eccube.plugin.point.repository.pointcustomer'] = $app->share(
            function () use ($app) {
                return $app['orm.em']->getRepository('Plugin\Point\Entity\PointCustomer');
            }
        );

        /** ポイント機能商品付与率テーブル */
        $app['eccube.plugin.point.repository.pointproductrate'] = $app->share(
            function () use ($app) {
                return $app['orm.em']->getRepository('Plugin\Point\Entity\PointProductRate');
            }
        );

        /** ポイント機能スナップショットテーブル */
        $app['eccube.plugin.point.repository.pointsnapshot'] = $app->share(
            function () use ($app) {
                return $app['orm.em']->getRepository('Plugin\Point\Entity\PointSnapshot');
            }
        );

        /**
         * フォームタイプ登録
         */
        $app['form.types'] = $app->share($app->extend('form.types', function ($types) use ($app) {
            $types[] = new \Plugin\Point\Form\Type\PointInfoType($app);
            $types[] = new \Plugin\Point\Form\Type\PointUseType($app);
            return $types;
        })
        );

        /**
         * メニュー登録
         */
        $app['config'] = $app->share(
            $app->extend(
                'config',
                function ($config) {
                    $addNavi['id'] = "point_info";
                    $addNavi['name'] = "ポイント設定";
                    $addNavi['url'] = "point_info";
                    $nav = $config['nav'];
                    foreach ($nav as $key => $val) {
                        if ("setting" == $val["id"]) {
                            $nav[$key]['child'][0]['child'][] = $addNavi;
                        }
                    }
                    $config['nav'] = $nav;

                    return $config;
                }
            )
        );

        /**
         * ポイント計算処理サービスファクトリー登録
         */
        $app['eccube.plugin.point.calculate.helper.factory'] = $app->share(
            function () use ($app) {
                return new PointCalculateHelper($app);
            }
        );

        /**
         * ポイント履歴ヘルパー登録
         */
        $app['eccube.plugin.point.history.service'] = $app->share(
            function () use ($app) {
                return new PointHistoryHelper($app);
            }
        );

        /**
         * メール送信ヘルパー登録
         */
        $app['eccube.plugin.point.mail.helper'] = $app->share(
            function () use ($app) {
                return new MailHelper($app);
            }
        );

        /**
         * メッセージ登録
         */
        $app['translator'] = $app->share(
            $app->extend(
                'translator',
                function ($translator, \Silex\Application $app) {
                    $translator->addLoader('yaml', new \Symfony\Component\Translation\Loader\YamlFileLoader());
                    $file = __DIR__.'/../Resource/locale/message.'.$app['locale'].'.yml';
                    if (file_exists($file)) {
                        $translator->addResource('yaml', $file, $app['locale']);
                    }

                    return $translator;
                }
            )
        );

        // ログファイル設定
        $app['monolog.point'] = $this->initLogger($app, 'point');

        // ログファイル管理画面用設定
        $app['monolog.point.admin'] = $this->initLogger($app, 'point_admin');

    }

    /**
     * 初期化時処理
     *  - 本クラスでは使用せず
     * @param BaseApplication $app
     */
    public function boot(BaseApplication $app)
    {
    }

    /**
     * ポイントプラグイン用ログファイルの初期設定
     *
     * @param BaseApplication $app
     * @param $logFileName
     * @return \Closure
     */
    protected function initLogger(BaseApplication $app, $logFileName)
    {

        return $app->share(function ($app) use ($logFileName) {
            $logger = new $app['monolog.logger.class']('plugin.point');
            $file = $app['config']['root_dir'].'/app/log/'.$logFileName.'.log';
            $RotateHandler = new RotatingFileHandler($file, $app['config']['log']['max_files'], Logger::INFO);
            $RotateHandler->setFilenameFormat(
                $logFileName.'_{date}',
                'Y-m-d'
            );

            $token = substr($app['session']->getId(), 0, 8);
            $format = "[%datetime%] [".$token."] %channel%.%level_name%: %message% %context% %extra%\n";
            // $RotateHandler->setFormatter(new LineFormatter($format, null, false, true));
            $RotateHandler->setFormatter(new LineFormatter($format));

            $logger->pushHandler(
                new FingersCrossedHandler(
                    $RotateHandler,
                    new ErrorLevelActivationStrategy(Logger::INFO)
                )
            );

            $logger->pushProcessor(function ($record) {
                // 出力ログからファイル名を削除し、lineを最終項目にセットしなおす
                unset($record['extra']['file']);
                $line = $record['extra']['line'];
                unset($record['extra']['line']);
                $record['extra']['line'] = $line;

                return $record;
            });

            $ip = new IntrospectionProcessor();
            $logger->pushProcessor($ip);

            $web = new WebProcessor();
            $logger->pushProcessor($web);

            // $uid = new UidProcessor(8);
            // $logger->pushProcessor($uid);

            $process = new ProcessIdProcessor();
            $logger->pushProcessor($process);


            return $logger;
        });

    }


}
