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
 * Class FrontPointController
 *
 * @package Plugin\Point\Controller
 */
class FrontPointController
{
    /**
     * 利用ポイント入力画面
     *
     * @param Application $app
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function usePoint(Application $app, Request $request)
    {
        // ログイン済の会員のみポイントを利用できる
        if (!$app->isGranted('ROLE_USER')) {
            throw new HttpException\NotFoundHttpException;
        }

        $app['monolog.point']->addInfo('usePoint start');

        // カートが存在しない、カートがロックされていない時はエラー
        if (!$app['eccube.service.cart']->isLocked()) {
            return $app->redirect($app->url('cart'));
        }

        // 購入処理中の受注情報がない場合はエラー表示
        $Order = $app['eccube.service.shopping']->getOrder($app['config']['order_processing']);
        if (!$Order) {
            $app->addError('front.shopping.order.error');

            return $app->redirect($app->url('shopping_error'));
        }

        // ポイント換算レートの取得.
        $PointInfo = $app['eccube.plugin.point.repository.pointinfo']->getLastInsertData();
        $pointRate = $PointInfo->getPlgPointConversionRate();

        // 保有ポイントの取得.
        $Customer = $app->user();
        $currentPoint = $app['eccube.plugin.point.repository.pointcustomer']->getLastPointById($Customer->getId());

        // 利用中のポイントの取得.
        $lastPreUsePoint = $app['eccube.plugin.point.repository.point']->getLatestPreUsePoint($Order);
        $lastPreUsePoint = abs($lastPreUsePoint); // 画面上では正の値として表示する.

        // すべての値引きを除外した合計金額
        $totalPrice = $Order->getTotalPrice() + $Order->getDiscount();

        // ポイントによる値引きを除外した合計金額
        $totalPriceExcludePoint = $Order->getTotalPrice() + $lastPreUsePoint * $pointRate;

        // ポイントによる値引きを除外した合計金額を、換算レートで割戻し、利用できるポイントの上限値を取得する.
        $maxUsePoint = floor($totalPriceExcludePoint / $pointRate);

        $form = $app['form.factory']
            ->createBuilder('front_point_use',
                array(
                    'plg_use_point' => $lastPreUsePoint
                ),
                array(
                    'maxUsePoint' => $maxUsePoint,
                    'currentPoint' => $currentPoint
                )
            )
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $usePoint = $form['plg_use_point']->getData();

            $app['monolog.point']->addInfo(
                'usePoint data',
                array(
                    'customer_id' => $Order->getCustomer()->getId(),
                    'use point' => $usePoint,
                )
            );

            // 利用中のポイントと入力されたポイントに相違があれば保存.
            if ($lastPreUsePoint != $usePoint) {

                $calculator = $app['eccube.plugin.point.calculate.helper.factory'];
                $calculator->addEntity('Order', $Order);
                $calculator->addEntity('Customer', $Order->getCustomer());
                $calculator->setUsePoint($usePoint);

                // 受注情報に対し, 値引き金額の設定を行う
                if ($calculator->setDiscount($lastPreUsePoint)) {
                    // 受注情報に対し、合計金額を再計算し、設定する.
                    $newOrder = $app['eccube.service.shopping']->calculatePrice($Order);

                    // ユーザー入力値を保存
                    $app['eccube.plugin.point.history.service']->refreshEntity();
                    $app['eccube.plugin.point.history.service']->addEntity($Order);
                    $app['eccube.plugin.point.history.service']->addEntity($Order->getCustomer());
                    $app['eccube.plugin.point.history.service']->savePreUsePoint($usePoint * -1); // 登録時に負の値に変換

                    $app['orm.em']->persist($newOrder);
                    $app['orm.em']->flush($newOrder);
                }
            }

            $app['monolog.point']->addInfo('usePoint end');

            return $app->redirect($app->url('shopping'));
        }

        $app['monolog.point']->addInfo('usePoint end');

        return $app->render(
            'Point/Resource/template/default/point_use.twig',
            array(
                'form' => $form->createView(),  // フォーム
                'pointRate' => $pointRate,      // 換算レート
                'currentPoint' => $currentPoint,  // 保有ポイント
                // 利用ポイント上限. 保有ポイントが小さい場合は保有ポイントを上限値として表示する
                'maxUsePoint' => ($maxUsePoint < $currentPoint) ? $maxUsePoint : $currentPoint,
                'total' => $totalPrice, // すべての値引きを除外した合計金額
            )
        );
    }
}
