<?php
/*
* This file is part of EC-CUBE
*
* Copyright(c) EC-CUBE CO.,LTD. All Rights Reserved.
* https://www.ec-cube.co.jp/
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Plugin\MailMagazine\ServiceProvider;

use Eccube\Common\Constant;
use Plugin\MailMagazine\Event\MailMagazine;
use Plugin\MailMagazine\Event\MailMagazineLegacy;
use Plugin\MailMagazine\Form\Extension\CustomerMailMagazineTypeExtension;
use Plugin\MailMagazine\Form\Extension\EntryMailMagazineTypeExtension;
use Plugin\MailMagazine\Repository\MailMagazineCustomerRepository;
use Silex\Application as BaseApplication;
use Silex\ServiceProviderInterface;

// include log functions (for 3.0.0 - 3.0.11)
require_once __DIR__.'/../log.php';

class MailMagazineServiceProvider implements ServiceProviderInterface
{
    public function register(BaseApplication $app)
    {
        // メルマガテンプレート用リポジトリ
        $app['eccube.plugin.mail_magazine.repository.mail_magazine'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Plugin\MailMagazine\Entity\MailMagazineTemplate');
        });

        // 配信履歴用リポジトリ
        $app['eccube.plugin.mail_magazine.repository.mail_magazine_history'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Plugin\MailMagazine\Entity\MailMagazineSendHistory');
        });

        // Customer用リポジトリ
        $app['eccube.plugin.mail_magazine.repository.mail_magazine_customer'] = $app->share(function () use ($app) {
            return new MailMagazineCustomerRepository($app['orm.em'], $app['orm.em']->getMetadataFactory()->getMetadataFor('Eccube\Entity\Customer'));
        });

        // 新規会員登録/Myページ
        $app['eccube.plugin.mail_magazine.repository.mail_magazine_mailmaga_customer'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Plugin\MailMagazine\Entity\MailmagaCustomer');
        });

        // イベント
        $app['eccube.plugin.mail_magazine.event.mail_magazine'] = $app->share(function () use ($app) {
            return new MailMagazine($app);
        });
        $app['eccube.plugin.mail_magazine.event.mail_magazine_legacy'] = $app->share(function () use ($app) {
            return new MailMagazineLegacy($app);
        });

        // 管理画面定義
        $admin = $app['controllers_factory'];
        // 強制SSL
        if ($app['config']['force_ssl'] == Constant::ENABLED) {
            $admin->requireHttps();
        }

        // ===========================================
        // 配信内容設定
        // ===========================================
        // 配信設定検索・一覧
        $admin->match('/plugin/mail_magazine', '\\Plugin\\MailMagazine\\Controller\\MailMagazineController::index')
            ->value('id', null)->assert('id', '\d+|')
            ->bind('plugin_mail_magazine');

        // 配信内容設定(テンプレ選択)
        $admin->match('/plugin/mail_magazine/select/{id}', '\\Plugin\\MailMagazine\\Controller\\MailMagazineController::select')
            ->value('id', null)->assert('id', '\d+|')
            ->bind('plugin_mail_magazine_select');

        // 配信内容確認
        $admin->match('/plugin/mail_magazine/confirm/{id}', '\\Plugin\\MailMagazine\\Controller\\MailMagazineController::confirm')
            ->value('id', null)->assert('id', '\d+|')
            ->bind('plugin_mail_magazine_confirm');

        // テスト送信
        $admin->match('/plugin/mail_magazine/test', '\\Plugin\\MailMagazine\\Controller\\MailMagazineController::sendTest')
            ->bind('plugin_mail_magazine_test');

        // 配信内容配信
        $admin->match('/plugin/mail_magazine/prepare', '\\Plugin\\MailMagazine\\Controller\\MailMagazineController::prepare')
            ->bind('plugin_mail_magazine_prepare');

        $admin->match('/plugin/mail_magazine/commit', '\\Plugin\\MailMagazine\\Controller\\MailMagazineController::commit')
            ->bind('plugin_mail_magazine_commit');

        // ===========================================
        // テンプレート設定
        // ===========================================
        // テンプレ一覧
        $admin->match('/plugin/mail_magazine/template', '\\Plugin\\MailMagazine\\Controller\\MailMagazineTemplateController::index')
            ->value('id', null)->assert('id', '\d+|')
            ->bind('plugin_mail_magazine_template');

        // テンプレ編集
        $admin->match('/plugin/mail_magazine/template/{id}/edit', '\\Plugin\\MailMagazine\\Controller\\MailMagazineTemplateController::edit')
            ->value('id', null)->assert('id', '\d+|')
            ->bind('plugin_mail_magazine_template_edit');

        // テンプレ登録
        $admin->match('/plugin/mail_magazine/template/regist', '\\Plugin\\MailMagazine\\Controller\\MailMagazineTemplateController::regist')
            ->bind('plugin_mail_magazine_template_regist');

        // テンプレ編集確定
        $admin->match('/plugin/mail_magazine/template/commit/{id}', '\\Plugin\\MailMagazine\\Controller\\MailMagazineTemplateController::commit')
            ->value('id', null)->assert('id', '\d+|')
            ->bind('plugin_mail_magazine_template_commit');

        // テンプレ削除
        $admin->match('/plugin/mail_magazine/template/{id}/delete', '\\Plugin\\MailMagazine\\Controller\\MailMagazineTemplateController::delete')
            ->value('id', null)->assert('id', '\d+|')
            ->bind('plugin_mail_magazine_template_delete');

        // テンプレプレビュー
        $admin->match('/plugin/mail_magazine/template/{id}/preview', '\\Plugin\\MailMagazine\\Controller\\MailMagazineTemplateController::preview')
            ->value('id', null)->assert('id', '\d+|')
            ->bind('plugin_mail_magazine_template_preview');

        // ===========================================
        // 配信履歴
        // ===========================================
        // 配信履歴一覧
        $admin->match('/plugin/mail_magazine/history', '\\Plugin\\MailMagazine\\Controller\\MailMagazineHistoryController::index')
            ->value('id', null)->assert('id', '\d+|')
            ->bind('plugin_mail_magazine_history');

        // 配信履歴一覧プレビュー
        $admin->match('/plugin/mail_magazine/history/{id}/preview', '\\Plugin\\MailMagazine\\Controller\\MailMagazineHistoryController::preview')
            ->value('id', null)->assert('id', '\d+|')
            ->bind('plugin_mail_magazine_history_preview');

        // 配信履歴一覧(配信条件)
        $admin->match('/plugin/mail_magazine/history/{id}/condition', '\\Plugin\\MailMagazine\\Controller\\MailMagazineHistoryController::condition')
            ->value('id', null)->assert('id', '\d+|')
            ->bind('plugin_mail_magazine_history_condition');

        // 配信履歴一覧削除
        $admin->match('/plugin/mail_magazine/history/{id}/delete', '\\Plugin\\MailMagazine\\Controller\\MailMagazineHistoryController::delete')
            ->value('id', null)->assert('id', '\d+|')
            ->bind('plugin_mail_magazine_history_delete');

        // 配信履歴結果確認
        $admin->match('/plugin/mail_magazine/history/result/{id}', '\\Plugin\\MailMagazine\\Controller\\MailMagazineHistoryController::result')
            ->value('id', null)->assert('id', '\d+|')
            ->bind('plugin_mail_magazine_history_result');

        // 配信履歴再試行
        $admin->match('/plugin/mail_magazine/history/retry', '\\Plugin\\MailMagazine\\Controller\\MailMagazineHistoryController::retry')
            ->bind('plugin_mail_magazine_history_retry');

        $app->mount('/'.trim($app['config']['admin_route'], '/').'/', $admin);

        // 型登録
        $app['form.types'] = $app->share($app->extend('form.types', function ($types) use ($app) {
            // テンプレート設定
            $types[] = new \Plugin\MailMagazine\Form\Type\MailMagazineTemplateEditType($app);
            $types[] = new \Plugin\MailMagazine\Form\Type\MailMagazineTemplateType($app);

            // 配信内容設定
            $types[] = new \Plugin\MailMagazine\Form\Type\MailMagazineType($app);

            return $types;
        }));

        // Form Extension
        $app['form.type.extensions'] = $app->share($app->extend('form.type.extensions', function ($extensions) use ($app) {
            $extensions[] = new EntryMailMagazineTypeExtension($app);
            $extensions[] = new CustomerMailMagazineTypeExtension($app);

            return $extensions;
        }));

        // -----------------------------
        // サービス
        // -----------------------------
        $app['eccube.plugin.mail_magazine.service.mail'] = $app->share(function () use ($app) {
            return new \Plugin\MailMagazine\Service\MailMagazineService($app);
        });

        // -----------------------------
        // メッセージ登録
        // -----------------------------
        $file = __DIR__.'/../Resource/locale/message.'.$app['locale'].'.yml';
        $app['translator']->addResource('yaml', $file, $app['locale']);

        // メニュー登録
        $app['config'] = $app->share($app->extend('config', function ($config) {
            $addNavi = array(
                'id' => 'mailmagazine',
                'name' => 'メルマガ管理',
                'has_child' => true,
                'icon' => 'cb-comment',
                'child' => array(
                    array(
                        'id' => 'mailmagazine',
                        'name' => '配信',
                        'url' => 'plugin_mail_magazine',
                    ),
                    array(
                        'id' => 'mailmagazine_template',
                        'name' => 'テンプレート設定',
                        'url' => 'plugin_mail_magazine_template',
                    ),
                    array(
                        'id' => 'mailmagazine_history',
                        'name' => '配信履歴',
                        'url' => 'plugin_mail_magazine_history',
                    ),
                ),
            );

            $nav = $config['nav'];
            foreach ($nav as $key => $val) {
                if ('setting' == $val['id']) {
                    array_splice($nav, $key, 0, array($addNavi));
                    break;
                }
            }
            $config['nav'] = $nav;

            return $config;
        }));

        // initialize logger (for 3.0.0 - 3.0.8)
        if (!method_exists('Eccube\Application', 'getInstance')) {
            eccube_log_init($app);
        }
    }

    public function boot(BaseApplication $app)
    {
    }
}
