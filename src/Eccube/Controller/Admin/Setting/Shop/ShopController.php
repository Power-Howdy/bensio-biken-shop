<?php
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) EC-CUBE CO.,LTD. All Rights Reserved.
 *
 * http://www.ec-cube.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */


namespace Eccube\Controller\Admin\Setting\Shop;

use Eccube\Application;
use Eccube\Controller\AbstractController;
use Eccube\Event\EccubeEvents;
use Eccube\Event\EventArgs;
use Symfony\Component\HttpFoundation\Request;

class ShopController extends AbstractController
{
    public function index(Application $app, Request $request)
    {
        $BaseInfo = $app['eccube.repository.base_info']->get();

        $builder = $app['form.factory']
            ->createBuilder('shop_master', $BaseInfo);

        $CloneInfo = clone $BaseInfo;
        $app['orm.em']->detach($CloneInfo);

        $event = new EventArgs(
            array(
                'builder' => $builder,
                'BaseInfo' => $BaseInfo,
            ),
            $request
        );
        $app['eccube.event.dispatcher']->dispatch(EccubeEvents::ADMIN_SETTING_SHOP_SHOP_INDEX_INITIALIZE, $event);

        $form = $builder->getForm();

        $receipt_logo = $BaseInfo->getReceiptLogo();
        $uploadFileName = '';
        if ($request->get('mode') == 'upload') {
            $uploadFileName = $this->upload($app, $request);
        }

        if ($app['request']->getMethod() === 'POST') {

            $form->handleRequest($app['request']);
            if ($form->isValid()) {
                if (!empty($uploadFileName)) {
                    $BaseInfo->setReceiptLogo($uploadFileName);
                    $receipt_logo = $uploadFileName;
                }else {
                    $BaseInfo->setReceiptLogo($receipt_logo);
                }
                $app['orm.em']->persist($BaseInfo);
                $app['orm.em']->flush();

                $event = new EventArgs(
                    array(
                        'form' => $form,
                        'BaseInfo' => $BaseInfo,
                    ),
                    $request
                );
                $app['eccube.event.dispatcher']->dispatch(EccubeEvents::ADMIN_SETTING_SHOP_SHOP_INDEX_COMPLETE, $event);

                $app->addSuccess('admin.shop.save.complete', 'admin');

                return $app->redirect($app->url('admin_setting_shop'));
            }
            $app->addError('admin.shop.save.error', 'admin');
        }

        $app['twig']->addGlobal('BaseInfo', $CloneInfo);

        return $app->render('Setting/Shop/shop_master.twig', array(
            'form' => $form->createView(),
            'receipt_logo' => $receipt_logo,
        ));
    }

    protected function normalizePath($path)
    {
        return str_replace('\\', '/', realpath($path));
    }

    public function upload(Application $app, Request $request)
    {        
        $uploadFile = $_FILES['shop_master'];
        // print_r($uploadFile);
        // print_r('<br>');
        $fileName = $uploadFile['name']['receipt_logo'];
        if (empty($fileName)) {
            return;
        }        

        $saveDir = $this->normalizePath($app['config']['image_save_realdir']);
        move_uploaded_file($uploadFile['tmp_name']['receipt_logo'], $saveDir.'/'.$fileName);

        return $fileName;

        // $form = $app['form.factory']->createBuilder('form')
        //     ->add('shop_master', 'shop_master')
        //     ->getForm();
            
        // $form->handleRequest($request);

        // if ($form->isValid()) {
        //     print_r("OK!!!");die;
        //     $data = $form->getData();
        //     print_r($data);die;
        //     if (empty($data['receipt_logo'])) {
        //         $this->error = array('message' => 'ファイルが選択されていません。');
        //     } else {
        //         $topDir = $app['config']['user_data_realdir'];
        //         if ($this->checkDir($request->get('now_dir'), $topDir)) {
        //             $filename = $this->convertStrToServer($data['file']->getClientOriginalName());
        //             $data['file']->move($request->get('now_dir'), $filename);
        //         }
        //     }
        // }
    }
}
