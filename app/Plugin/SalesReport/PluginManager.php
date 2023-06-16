<?php
/*
 * This file is part of the Sales Report plugin
 *
 * Copyright (C) 2016 LOCKON CO.,LTD. All Rights Reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\SalesReport;

use Eccube\Plugin\AbstractPluginManager;
use Eccube\Application;

/**
 * Class PluginManager.
 */
class PluginManager extends AbstractPluginManager
{
    /**
     * プラグインインストール時の処理.
     *
     * @param array       $config
     * @param Application $app
     *
     * @throws \Exception
     */
    public function install($config, $app)
    {
    }

    /**
     * プラグイン削除時の処理.
     *
     * @param array       $config
     * @param Application $app
     */
    public function uninstall($config, $app)
    {
    }

    /**
     * プラグイン有効時の処理.
     *
     * @param array       $config
     * @param Application $app
     *
     * @throws \Exception
     */
    public function enable($config, $app)
    {
    }

    /**
     * プラグイン無効時の処理.
     *
     * @param array       $config
     * @param Application $app
     */
    public function disable($config, $app)
    {
    }

    /**
     * プラグイン更新時の処理.
     *
     *  @param array       $config
     * @param Application $app
     */
    public function update($config, $app)
    {
    }
}
