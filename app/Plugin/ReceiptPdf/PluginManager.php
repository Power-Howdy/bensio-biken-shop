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

namespace Plugin\ReceiptPdf;

use Eccube\Application;
use Eccube\Plugin\AbstractPluginManager;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class PluginManager.
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
     * Install.
     *
     * @param array       $config
     * @param Application $app
     */
    public function install($config, $app)
    {
        $this->copyFile($app['config'], $config['code'], $config['const']['logo_file']);
        $this->copyFile($app['config'], $config['code'], $config['const']['pdf_file']);
        $this->copyFile($app['config'], $config['code'], $config['const']['pdf_file2']);
    }

    /**
     * Uninstall.
     *
     * @param array       $config
     * @param Application $app
     */
    public function uninstall($config, $app)
    {
        // Remove temp
        $this->removeLogo($app['config'], $config['code'], $config['const']['logo_file']);
        $this->removeLogo($app['config'], $config['code'], $config['const']['pdf_file']);
        $this->removeLogo($app['config'], $config['code'], $config['const']['pdf_file2']);

        $this->migrationSchema($app, __DIR__.'/Resource/doctrine/migration', $config['code'], 0);
    }

    /**
     * Enable.
     *
     * @param array       $config
     * @param Application $app
     */
    public function enable($config, $app)
    {
        $this->migrationSchema($app, __DIR__.'/Resource/doctrine/migration', $config['code']);
    }

    /**
     * Disable.
     *
     * @param array       $config
     * @param Application $app
     */
    public function disable($config, $app)
    {
    }

    /**
     * Update.
     *
     * @param array       $config
     * @param Application $app
     */
    public function update($config, $app)
    {
        $this->copyFile($app['config'], $config['code'], $config['const']['logo_file']);
        $this->copyFile($app['config'], $config['code'], $config['const']['pdf_file']);
        $this->copyFile($app['config'], $config['code'], $config['const']['pdf_file2']);

        // Update
        $this->migrationSchema($app, __DIR__.'/Resource/doctrine/migration', $config['code']);
    }

    /**
     * ファイルをapp/templateにコピーする.
     *
     * @param array  $config
     * @param string $pluginCode
     * @param string $fileName
     */
    private function copyFile($config, $pluginCode, $fileName)
    {
        $src = $this->getPluginTemplateDir().'/'.$fileName;
        $target = $this->getAppTemplateDir($config).'/'.$pluginCode.'/'.$fileName;

        // コピー先にすでにファイルが存在する場合は、ユーザーが変更したロゴ画像を残すために上書きをしない
        if (file_exists($target) || !file_exists($src)) {
            return;
        }

        $file = new Filesystem();
        $file->copy($src, $target, true);
    }

    /**
     * インストール時app/templateにコピーしたファイルを削除する.
     *
     * @param array  $config
     * @param string $pluginCode
     * @param string $fileName
     */
    private function removeLogo($config, $pluginCode, $fileName)
    {
        $target = $this->getAppTemplateDir($config).'/'.$pluginCode.'/'.$fileName;

        if (!file_exists($target)) {
            return;
        }

        $file = new Filesystem();
        $file->remove($target);
    }

    /**
     * Plugin内のテンプレートディレクトリのパスを取得する.
     *
     * @return string
     */
    private function getPluginTemplateDir()
    {
        return __DIR__.'/Resource/template';
    }

    /**
     * app/template内のテンプレートディレクトリのパスを取得する.
     *
     * @param array $config
     *
     * @return string
     */
    private function getAppTemplateDir($config)
    {
        return $config['template_realdir'].'/../admin';
    }
}
