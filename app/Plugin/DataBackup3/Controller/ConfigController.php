<?php

/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) EC-CUBE CO.,LTD. All Rights Reserved.
 *
 * http://www.ec-cube.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\DataBackup3\Controller;

use Eccube\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ConfigController
{
    /**
     * 設定画面
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Application $app, Request $request)
    {
        $form = $app['form.factory']->createBuilder('databackup3_config')->getForm();

        return $app->render('DataBackup3/Resource/template/admin/config.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * バックアップ実行
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function doBackup(Application $app, Request $request)
    {
        $form = $app['form.factory']->createBuilder('databackup3_config')->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $backupDir = __DIR__.'/../backup/'.date('YmdHis');
            if (!is_dir($backupDir)) {
                mkdir($backupDir, 0777, true);
            }
            $tables = $app['eccube.service.databackup3']->listTableNames();
            foreach ($tables as $table) {
                $app['eccube.service.databackup3']->dumpCSV($table, $backupDir);
            }

            $tarFile = $backupDir.'.tar';

            // tar.gzファイルに圧縮する.
            $phar = new \PharData($tarFile);
            $phar->buildFromDirectory($backupDir);
            $phar->compress(\Phar::GZ);

            return $app
                ->sendFile($tarFile.'.gz')
                ->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'backup_'.date('YmdHis').'.tar.gz');
        }

        return $app->redirect($app->url('plugin_DataBackup3_config'));
    }
}
