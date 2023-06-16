<?php

namespace Plugin\Point;

use Eccube\Entity\Master\DeviceType;
use Eccube\Entity\PageLayout;
use Eccube\Plugin\AbstractPluginManager;
use Plugin\Point\Entity\PointInfo;

/**
 * インストールハンドラー
 * Class PluginManager
 * @package Plugin\Point
 */
class PluginManager extends AbstractPluginManager
{
    /**
     * PluginManager constructor.
     */
    public function __construct()
    {
    }

    /**
     * インストール時に実行
     * @param $config
     * @param $app
     */
    public function install($config, $app)
    {
    }

    /**
     * アンインストール時に実行
     * @param $config
     * @param $app
     */
    public function uninstall($config, $app)
    {
        $this->migrationSchema($app, __DIR__.'/Resource/doctrine/migration', $config['code'], 0);
    }

    /**
     * プラグイン有効化時に実行
     * @param $config
     * @param $app
     */
    public function enable($config, $app)
    {
        $this->migrationSchema($app, __DIR__.'/Resource/doctrine/migration', $config['code']);

        // ポイント基本設定のデフォルト値を登録
        $PointInfo = $app['orm.em']
            ->getRepository('Plugin\Point\Entity\PointInfo')
            ->getLastInsertData();
        if (is_null($PointInfo)) {
            $PointInfo = new PointInfo();
            $PointInfo
                ->setPlgAddPointStatus($app['config']['order_deliv'])   // ポイントの確定ステータス：発送済み
                ->setPlgBasicPointRate(1)
                ->setPlgPointConversionRate(1)
                ->setPlgRoundType(PointInfo::POINT_ROUND_CEIL) // 切り上げ
                ->setPlgCalculationType(PointInfo::POINT_CALCULATE_NORMAL); // 減算なし

            $app['orm.em']->persist($PointInfo);
            $app['orm.em']->flush($PointInfo);
        }

        // ページレイアウトにプラグイン使用時の値を代入
        $deviceType = $app['eccube.repository.master.device_type']->findOneById(DeviceType::DEVICE_TYPE_PC);
        $pageLayout = new PageLayout();
        $pageLayout->setDeviceType($deviceType);
        $pageLayout->setFileName('../../Plugin/Point/Resource/template/default/point_use');
        $pageLayout->setEditFlg(PageLayout::EDIT_FLG_DEFAULT);
        $pageLayout->setMetaRobots('noindex');
        $pageLayout->setUrl('point_use');
        $pageLayout->setName('商品購入/利用ポイント');
        $app['orm.em']->persist($pageLayout);
        $app['orm.em']->flush($pageLayout);
    }

    /**
     * プラグイン無効化時実行
     * @param $config
     * @param $app
     */
    public function disable($config, $app)
    {
        // ページ情報の削除
        $pageLayout = $app['eccube.repository.page_layout']->findByUrl('point_use');
        foreach ($pageLayout as $deleteNode) {
            $app['orm.em']->remove($deleteNode);
            $app['orm.em']->flush($deleteNode);
        }
    }

    /**
     * アップデート時に行う処理
     * @param $config
     * @param $app
     */
    public function update($config, $app)
    {
    }
}
