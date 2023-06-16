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
namespace Plugin\Point\Controller;

use Eccube\Application;
use Plugin\Point\Form\Type;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception as HttpException;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ポイント設定画面用コントローラー
 * Class AdminPointController
 * @package Plugin\Point\Controller
 */
class AdminPointController
{
    /**
     * AdminPointController constructor.
     */
    public function __construct()
    {
    }

    /**
     * ポイント基本情報管理設定画面
     * @param Application $app
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function index(Application $app, Request $request)
    {
        $app['monolog.point.admin']->addInfo('index start');

        // 最終保存のポイント設定情報取得
        $PointInfo = $app['eccube.plugin.point.repository.pointinfo']->getLastInsertData();

        $form = $app['form.factory']
            ->createBuilder('admin_point_info', $PointInfo)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $PointInfo = $form->getData();
            $app['eccube.plugin.point.repository.pointinfo']->save($PointInfo);

            $app->addSuccess('admin.point.save.complete', 'admin');

            $app['monolog.point.admin']->addInfo(
                'index save',
                array(
                    'saveData' => $app['serializer']->serialize($PointInfo, 'json'),
                )
            );

            $app['monolog.point.admin']->addInfo('index end');

            return $app->redirect($app->url('point_info'));
        }

        $app['monolog.point.admin']->addInfo('index end');

        return $app->render(
            'Point/Resource/template/admin/pointinfo.twig',
            array(
                'form' => $form->createView(),
                'Point' => $PointInfo,
            )
        );
    }
}
