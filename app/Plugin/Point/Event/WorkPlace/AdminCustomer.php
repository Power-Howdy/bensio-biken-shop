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
 *  - 拡張元 : 会員登録( 編集 )
 *  - 拡張項目 : 保有ポイント登録( 編集 )
 * Class AdminCustomer
 * @package Plugin\Point\Event\WorkPlace
 */
class  AdminCustomer extends AbstractWorkPlace
{
    /**
     * 会員保有ポイント追加
     *
     * @param EventArgs $event
     */
    public function createForm(EventArgs $event)
    {
        $builder = $event->getArgument('builder');
        $Customer = $event->getArgument('Customer');

        // 登録済み情報取得処理
        $lastPoint = null;
        if (!is_null($Customer->getId())) {
            $lastPoint = $this->app['eccube.plugin.point.repository.pointcustomer']->getLastPointById($Customer->getId());
        }

        $data = is_null($lastPoint) ? '' : $lastPoint;

        // 保有ポイント項目
        $builder
            ->add(
                'plg_point_current',
                'text',
                array(
                    'label' => '保有ポイント',
                    'required' => false,
                    'mapped' => false,
                    'empty_data' => null,
                    'data' => $data,
                    'attr' => array(
                        'placeholder' => '入力した値でカスタマーの保有ポイントを更新します ( pt )',
                    ),
                    'constraints' => array(
                        new Assert\Length(
                            array(
                                'max' => $this->app['config']['int_len'],
                            )
                        ),
                        new Assert\Regex(
                            array(
                                'pattern' => "/^\d+$/u",
                                'message' => 'form.type.numeric.invalid',
                            )
                        ),
                        new Assert\GreaterThanOrEqual(
                            array(
                                'value' => 0
                            )
                        ),
                    ),
                )
            );
    }

    /**
     * 保有ポイント保存
     * @param EventArgs $event
     * @return bool
     */
    public function save(EventArgs $event)
    {

        $this->app['monolog.point.admin']->addInfo('save start');

        // フォーム情報取得処理
        $form = $event->getArgument('form');

        if (empty($form)) {
            return false;
        }

        // 保有ポイント
        $pointCurrent = $form->get('plg_point_current')->getData();

        if (empty($pointCurrent) && $pointCurrent != 0) {
            return false;
        }

        // 会員ID取得
        $customerId = $form->getData()->getId();

        if (empty($customerId)) {
            return false;
        }

        // 前回入力値と比較
        $status = false;
        $status = $this->app['eccube.plugin.point.repository.pointcustomer']->isSamePoint($pointCurrent, $customerId);

        // 前回入力値と同じ値であれば登録をキャンセル
        if ($status) {
            return true;
        }

        // プロダクトエンティティを取得
        $customer = $event->getArgument('Customer');

        if (empty($customer)) {
            return false;
        }

        // ポイント付与保存処理
        $saveEntity = $this->app['eccube.plugin.point.repository.pointcustomer']->savePoint($pointCurrent, $customer);

        // 現在の保持ポイントを減算して登録（ゼロリセットする）
        $orderIds = $this->app['eccube.plugin.point.repository.pointstatus']->selectOrderIdsWithFixedByCustomer(
            $customer->getId()
        );
        $calculateCurrentPoint = $this->app['eccube.plugin.point.repository.point']->calcCurrentPoint(
            $customer->getId(),
            $orderIds
        );

        $this->app['monolog.point.admin']->addInfo('save add point', array(
                'customer_id' => $customer->getId(),
                'status' => $status,
                'current point' => $calculateCurrentPoint,
                'add point' => $pointCurrent,
            )
        );

        $this->app['eccube.plugin.point.history.service']->addEntity($customer);
        $this->app['eccube.plugin.point.history.service']->saveManualpoint($calculateCurrentPoint * -1);
        $this->app['eccube.plugin.point.history.service']->refreshEntity();
        
        // 新しいポイントを登録
        $this->app['eccube.plugin.point.history.service']->addEntity($customer);
        $this->app['eccube.plugin.point.history.service']->saveManualpoint($pointCurrent);

        $point = array();
        $point['current'] = $pointCurrent;
        $point['use'] = 0;
        $point['add'] = $pointCurrent;

        // 手動設定ポイントのスナップショット登録
        $this->app['eccube.plugin.point.history.service']->refreshEntity();
        $this->app['eccube.plugin.point.history.service']->addEntity($customer);
        $this->app['eccube.plugin.point.history.service']->saveSnapShot($point);

        $this->app['monolog.point.admin']->addInfo('save end');
    }
}
