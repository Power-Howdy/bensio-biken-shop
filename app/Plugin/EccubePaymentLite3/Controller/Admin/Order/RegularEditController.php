<?php

namespace Plugin\EccubePaymentLite3\Controller\Admin\Order;

use Doctrine\Common\Collections\ArrayCollection;
use Eccube\Application;
use Eccube\Common\Constant;
use Eccube\Controller\AbstractController;
use Eccube\Entity\ShipmentItem;
use Plugin\EccubePaymentLite3\Entity\RegularOrder;
use Plugin\EccubePaymentLite3\Entity\RegularShipmentItem;
use Plugin\EccubePaymentLite3\Entity\RegularShipping;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RegularEditController extends AbstractController
{
    public function index(Application $app, Request $request, $id)
    {
        $softDeleteFilter = $app['orm.em']->getFilters()->getFilter('soft_delete');
        $softDeleteFilter->setExcludes(array(
            'Eccube\Entity\Order'
        ));

        $TargetRegularOrder = null;
        $OriginRegularOrder = null;

        $TargetRegularOrder = $app['eccube.plugin.epsilon.repository.regular_order']->find($id);
        if (is_null($TargetRegularOrder)) {
            throw new NotFoundHttpException();
        }

        // 編集前の受注情報を保持
        $OriginRegularOrder = clone $TargetRegularOrder;
        $OriginalRegularOrderDetails = new ArrayCollection();

        foreach ($TargetRegularOrder->getRegularOrderDetails() as $RegularOrderDetail) {
            $OriginalRegularOrderDetails->add($RegularOrderDetail);
        }

        $builder = $app['form.factory']
            ->createBuilder('epsilon_regular_order', $TargetRegularOrder);
        $form = $builder->getForm();

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            // 入力情報にもとづいて再計算.
            $this->calculate($app, $TargetRegularOrder);

            // 登録ボタン押下
            switch ($request->get('mode')) {
                case 'register':
                    if ($TargetRegularOrder->getTotal() > $app['config']['max_total_fee']) {
                        $form['charge']->addError(new FormError('合計金額の上限を超えております。'));
                    } elseif ($form->isValid()) {
                        $BaseInfo = $app['eccube.repository.base_info']->get();

                        // お支払い方法の更新
                        $TargetRegularOrder->setPaymentMethod($TargetRegularOrder->getPayment()->getMethod());

                        // 配送業者・お届け時間の更新
                        $RegularShippings = $TargetRegularOrder->getRegularShippings();
                        foreach ($RegularShippings as $RegularShipping) {
                            $RegularShipping->setShippingDeliveryName($RegularShipping->getDelivery()->getName());
                            if (!is_null($RegularShipping->getDeliveryTime())) {
                                $RegularShipping->setShippingDeliveryTime($RegularShipping->getDeliveryTime()->getDeliveryTime());
                            } else {
                                $RegularShipping->setShippingDeliveryTime(null);
                            }
                        }

                        // 受注明細で削除されているものをremove
                        foreach ($OriginalRegularOrderDetails as $RegularOrderDetail) {
                            if (false === $TargetRegularOrder->getRegularOrderDetails()->contains($RegularOrderDetail)) {
                                $app['orm.em']->remove($RegularOrderDetail);
                            }
                        }

                        // 複数配送が有効
                        if ($BaseInfo->getOptionMultipleShipping() == Constant::ENABLED) {
                            foreach ($TargetRegularOrder->getRegularOrderDetails() as $RegularOrderDetail) {
                                /** @var $OrderDetail \Eccube\Entity\OrderDetail */
                                $RegularOrderDetail->setRegularOrder($TargetRegularOrder);
                            }

                            /** @var \Eccube\Entity\Shipping $Shipping */
                            foreach ($RegularShippings as $RegularShipping) {
                                $regularShipmentItems = $RegularShipping->getRegularShipmentItems();
                                /** @var \Eccube\Entity\ShipmentItem $ShipmentItem */
                                foreach ($regularShipmentItems as $RegularShipmentItem) {
                                    $RegularShipmentItem->setRegularOrder($TargetRegularOrder);
                                    $RegularShipmentItem->setRegularShipping($RegularShipping);
                                    $app['orm.em']->persist($RegularShipmentItem);
                                }
                                $RegularShipping->setRegularOrder($TargetRegularOrder);
                                $app['orm.em']->persist($RegularShipping);
                            }
                        // 複数配送が無効
                        } else {
                            $NewRegularShipmentItems = new ArrayCollection();
                            foreach ($TargetRegularOrder->getRegularOrderDetails() as $RegularOrderDetail) {
                                /** @var $OrderDetail \Eccube\Entity\OrderDetail */
                                $RegularOrderDetail->setRegularOrder($TargetRegularOrder);

                                $NewRegularShipmentItem = new RegularShipmentItem();
                                $NewRegularShipmentItem
                                    ->setProduct($RegularOrderDetail->getProduct())
                                    ->setProductClass($RegularOrderDetail->getProductClass())
                                    ->setProductName($RegularOrderDetail->getProduct()->getName())
                                    ->setProductCode($RegularOrderDetail->getProductClass()->getCode())
                                    ->setClassCategoryName1($RegularOrderDetail->getClassCategoryName1())
                                    ->setClassCategoryName2($RegularOrderDetail->getClassCategoryName2())
                                    ->setClassName1($RegularOrderDetail->getClassName1())
                                    ->setClassName2($RegularOrderDetail->getClassName2())
                                    ->setPrice($RegularOrderDetail->getPrice())
                                    ->setQuantity($RegularOrderDetail->getQuantity())
                                    ->setRegularOrder($TargetRegularOrder);
                                $NewRegularShipmentItems[] = $NewRegularShipmentItem;
                            }
                            // 配送商品の更新. delete/insert.
                            $RegularShippings = $TargetRegularOrder->getRegularShippings();
                            foreach ($RegularShippings as $RegularShipping) {
                                $RegularShipmentItems = $RegularShipping->getRegularShipmentItems();
                                foreach ($RegularShipmentItems as $RegularShipmentItem) {
                                    $app['orm.em']->remove($RegularShipmentItem);
                                }
                                $RegularShipmentItems->clear();
                                foreach ($NewRegularShipmentItems as $NewRegularShipmentItem) {
                                    $NewRegularShipmentItem->setRegularShipping($RegularShipping);
                                    $RegularShipmentItems->add($NewRegularShipmentItem);
                                }
                            }
                        }

                        $app['orm.em']->persist($TargetRegularOrder);
                        $app['orm.em']->flush();

                        $app->addSuccess('admin.order.save.complete', 'admin');

                        return $app->redirect($app->url('paylite_regular_order_edit', array('id' => $TargetRegularOrder->getId())));
                    }
                    break;
                case 'add_delivery':
                    // お届け先情報の新規追加
                    $form = $builder->getForm();
                    $RegularShipping = new RegularShipping();
                    $RegularShipping->setDelFlg(Constant::DISABLED);
                    $TargetRegularOrder->addRegularShipping($RegularShipping);
                    $RegularShipping->setRegularOrder($TargetRegularOrder);
                    $form->setData($TargetRegularOrder);

                    break;
                default:
                    break;
            }
        }

        // 会員検索フォーム
        $searchCustomerModalForm = $app['form.factory']
            ->createBuilder('admin_search_customer')
            ->getForm();

        // 商品検索フォーム
        $searchProductModalForm = $app['form.factory']
            ->createBuilder('admin_search_regular_product')
            ->getForm();

        // 配送業者のお届け時間
        $times = array();
        $deliveries = $app['eccube.repository.delivery']->findAll();
        foreach ($deliveries as $Delivery) {
            $deliveryTiems = $Delivery->getDeliveryTimes();
            foreach ($deliveryTiems as $DeliveryTime) {
                $times[$Delivery->getId()][$DeliveryTime->getId()] = $DeliveryTime->getDeliveryTime();
            }
        }

        // 定期履歴
        $OrderHistory = $app['eccube.plugin.epsilon.repository.order_extension']->getOrderByRegularOrderId($id);

        return $app->render('EccubePaymentLite3/Twig/admin/Order/regular_edit.twig', array(
            'form' => $form->createView(),
            'searchCustomerModalForm' => $searchCustomerModalForm->createView(),
            'searchProductModalForm' => $searchProductModalForm->createView(),
            'RegularOrder' => $TargetRegularOrder,
            'OrderHistory' => $OrderHistory,
            'id' => $id,
            'shippingDeliveryTimes' => $app['serializer']->serialize($times, 'json'),
        ));
    }


    /**
     * 定期購入商品を検索する.
     *
     * @param Application $app
     * @param Request $request
     * @return
     */
    public function searchProduct(Application $app, Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $app['monolog']->addDebug('search product start.');

            $searchData = array(
                'multi' => $request->get('multi'),
            );
            if ($categoryId = $request->get('category_id')) {
                $Category = $app['eccube.repository.category']->find($categoryId);
                $searchData['category_id'] = $Category;
            }

            $Products = $app['eccube.plugin.epsilon.repository.regular_product']->getRegularProduct($searchData);

            if (empty($Products)) {
                $app['monolog']->addDebug('search product not found.');
            }

            $forms = array();
            foreach ($Products as $Product) {
                $builder = $app['form.factory']->createNamedBuilder('', 'add_cart', null, array(
                    'product' => $Product,
                ));
                $addCartForm = $builder->getForm();
                $forms[$Product->getId()] = $addCartForm->createView();
            }

            return $app->render('EccubePaymentLite3/Twig/admin/Order/search_regular_product.twig', array(
                'forms' => $forms,
                'Products' => $Products,
            ));
        }
    }


    /**
     * フォームからの入直内容に基づいて、受注情報の再計算を行う
     *
     * @param $app
     * @param $Order
     */
    protected function calculate($app, RegularOrder $RegularOrder)
    {
        $taxtotal = 0;
        $subtotal = 0;

        // 受注明細データの税・小計を再計算
        /** @var $OrderDetails \Eccube\Entity\OrderDetail[] */
        $RegularOrderDetails = $RegularOrder->getRegularOrderDetails();
        foreach ($RegularOrderDetails as $RegularOrderDetail) {
            // 新規登録の場合は, 入力されたproduct_id/produc_class_idから明細にセットする.
            // todo 別メソッドに切り出す
            if (!$RegularOrderDetail->getId()) {

                $TaxRule = $app['eccube.repository.tax_rule']->getByRule($RegularOrderDetail->getProduct(),
                    $RegularOrderDetail->getProductClass());
                $RegularOrderDetail->setTaxRule($TaxRule->getCalcRule()->getId());
                $RegularOrderDetail->setProductName($RegularOrderDetail->getProduct()->getName());
                $RegularOrderDetail->setProductCode($RegularOrderDetail->getProductClass()->getCode());
                $RegularOrderDetail->setClassName1($RegularOrderDetail->getProductClass()->hasClassCategory1()
                    ? $RegularOrderDetail->getProductClass()->getClassCategory1()->getClassName()->getName()
                    : null);
                $RegularOrderDetail->setClassName2($RegularOrderDetail->getProductClass()->hasClassCategory2()
                    ? $RegularOrderDetail->getProductClass()->getClassCategory2()->getClassName()->getName()
                    : null);
                $RegularOrderDetail->setClassCategoryName1($RegularOrderDetail->getProductClass()->hasClassCategory1()
                    ? $RegularOrderDetail->getProductClass()->getClassCategory1()->getName()
                    : null);
                $RegularOrderDetail->setClassCategoryName2($RegularOrderDetail->getProductClass()->hasClassCategory2()
                    ? $RegularOrderDetail->getProductClass()->getClassCategory2()->getName()
                    : null);
            }

            // 税
            $tax = $app['eccube.service.tax_rule']
                ->calcTax($RegularOrderDetail->getPrice(), $RegularOrderDetail->getTaxRate(), $RegularOrderDetail->getTaxRule());
            $RegularOrderDetail->setPriceIncTax($RegularOrderDetail->getPrice() + $tax);

            $taxtotal += $tax;

            // 小計
            $subtotal += $RegularOrderDetail->getTotalPrice();
        }


        $regularShippings = $RegularOrder->getRegularShippings();
        /** @var \Eccube\Entity\Shipping $Shipping */
        foreach ($regularShippings as $RegularShipping) {
            $regularShipmentItems = $RegularShipping->getRegularShipmentItems();
            $RegularShipping->setDelFlg(Constant::DISABLED);
            /** @var \Eccube\Entity\ShipmentItem $ShipmentItem */
            foreach ($regularShipmentItems as $RegularShipmentItem) {
                $RegularShipmentItem->setProductName($RegularShipmentItem->getProduct()->getName());
                $RegularShipmentItem->setProductCode($RegularShipmentItem->getProductClass()->getCode());
                $RegularShipmentItem->setClassName1($RegularShipmentItem->getProductClass()->hasClassCategory1()
                    ? $RegularShipmentItem->getProductClass()->getClassCategory1()->getClassName()->getName()
                    : null);
                $RegularShipmentItem->setClassName2($RegularShipmentItem->getProductClass()->hasClassCategory2()
                    ? $RegularShipmentItem->getProductClass()->getClassCategory2()->getClassName()->getName()
                    : null);
                $RegularShipmentItem->setClassCategoryName1($RegularShipmentItem->getProductClass()->hasClassCategory1()
                    ? $RegularShipmentItem->getProductClass()->getClassCategory1()->getName()
                    : null);
                $RegularShipmentItem->setClassCategoryName2($RegularShipmentItem->getProductClass()->hasClassCategory2()
                    ? $RegularShipmentItem->getProductClass()->getClassCategory2()->getName()
                    : null);
            }
        }

        // 受注データの税・小計・合計を再計算
        $RegularOrder->setTax($taxtotal);
        $RegularOrder->setSubtotal($subtotal);
        $RegularOrder->setTotal($subtotal + $RegularOrder->getCharge() + $RegularOrder->getDeliveryFeeTotal() - $RegularOrder->getDiscount());
        // お支払い合計は、totalと同一金額(2系ではtotal - point)
        $RegularOrder->setPaymentTotal($RegularOrder->getTotal());
    }

}
