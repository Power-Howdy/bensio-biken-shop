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

namespace Plugin\Point\Event\WorkPlace;

use Eccube\Event\EventArgs;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * フックポイント汎用処理具象クラス
 *  - 拡張元 : 商品登録( 編集 )
 *  - 拡張項目 : 商品毎ポイント付与率( 編集 )
 * Class AdminProduct
 * @package Plugin\Point\Event\WorkPlace
 */
class  AdminProduct extends AbstractWorkPlace
{
    /**
     * 商品フォームポイント付与率項目追加
     *
     * @param EventArgs $event
     */
    public function createForm(EventArgs $event)
    {
        $builder = $event->getArgument('builder');
        $Product = $event->getArgument('Product');

        // 登録済み情報取得処理
        $lastPointProduct = null;
        if (!is_null($Product->getId())) {
            $lastPointProduct = $this->app['eccube.plugin.point.repository.pointproductrate']->getLastPointProductRateById(
                $Product->getId()
            );
        }

        // ポイント付与率項目拡張
        $builder
            ->add(
                'plg_point_product_rate',
                'text',
                array(
                    'label' => 'ポイント付与率',
                    'required' => false,
                    'mapped' => false,
                    'data' => $lastPointProduct,
                    'constraints' => array(
                        new Assert\Regex(
                            array(
                                'pattern' => "/^[+-]?([0-9]+\.?[0-9]*|\.[0-9]+)$/",
                                'message' => 'form.type.numeric.invalid',
                            )
                        ),
                        new Assert\Range(
                            array(
                                'min' => 0,
                                'max' => 500,
                            )
                        ),
                    ),
                )
            );
    }

    /**
     * 商品毎ポイント付与率保存
     * @param EventArgs $event
     * @return bool
     */
    public function save(EventArgs $event)
    {
        $this->app['monolog.point.admin']->addInfo('save start');

        // フォーム情報取得処理
        $form = $event->getArgument('form');

        // ポイント付与率取得
        $pointRate = $form->get('plg_point_product_rate')->getData();

        $Product = $event->getArgument('Product');

        // 前回入力値と比較
        $status = $this->app['eccube.plugin.point.repository.pointproductrate']
            ->isSamePoint($pointRate, $Product->getId());

        $this->app['monolog.point.admin']->addInfo('save add product point', array(
                'product_id' => $Product->getId(),
                'status' => $status,
                'add point' => $pointRate,
            )
        );

        // 前回入力値と同じ値であれば登録をキャンセル
        if ($status) {
            return true;
        }

        // ポイント付与保存処理
        $this->app['eccube.plugin.point.repository.pointproductrate']->savePointProductRate($pointRate, $Product);

        $this->app['monolog.point.admin']->addInfo('save end');
    }
}
