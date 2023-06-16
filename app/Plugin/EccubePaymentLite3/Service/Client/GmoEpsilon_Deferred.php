<?php

namespace Plugin\EccubePaymentLite3\Service\Client;

use Eccube\Application;
use Eccube\Entity\Order;
use Plugin\EccubePaymentLite3\Entity\Extension\OrderExtension;
use Plugin\EccubePaymentLite3\Entity\Extension\PaymentExtension;

/**
 * 決済モジュール 決済処理：GMO後払い
 */
class GmoEpsilon_Deferred extends GmoEpsilon_Base
{

    /**
     * コンストラクタ
     *
     * @return void
     */
    function __construct(Application $app)
    {
        parent::__construct($app);
        $this->app = $app;
        $this->const = $app['config']['EccubePaymentLite3']['const'];
    }

    /**
     * 受注情報を更新
     *
     * @param Order $Order
     * @param array $response
     */
    function updateOrder($Order, $response)
    {
        $OrderStatus = $this->app['eccube.repository.order_status']->find($this->app['config']['order_new']);
        $this->app['eccube.repository.order']->changeStatus($Order->getId(), $OrderStatus);

        // 在庫情報更新
        $this->app['eccube.service.order']->setStockUpdate($this->app['orm.em'], $Order);

        if ($this->app->isGranted('ROLE_USER')) {
            // 会員の場合、購入金額を更新
            $this->app['eccube.service.order']->setCustomerUpdate($this->app['orm.em'], $Order, $this->app->user());
        }

        // Get payment status
        $PaymentStatus = $this->app['eccube.plugin.epsilon.repository.payment_status']->find($response['state']);
        $OrderExtension = new OrderExtension();
        $OrderExtension->setId($Order->getId());
        $OrderExtension->setTransCode($response['trans_code']);
        $OrderExtension->setGmoEpsilonOrderNo($response['order_number']);
        $OrderExtension->setPaymentStatus($PaymentStatus);
        $Order->setPaymentDate(new \DateTime());
        $this->app['orm.em']->persist($Order);
        $this->app['orm.em']->persist($OrderExtension);
    }

    /**
     * リクエストパラメータを設定
     *
     * @param Order $Order
     * @param PaymentExtension
     * @return array
     */
    function setParameter($Order, $PaymentExtension)
    {

        // 共通のリクエストパラメータを取得
        $arrParameter = parent::setParameter($Order, $PaymentExtension);

        $arrShippings = $Order->getShippings();
        $Shipping = $arrShippings[0];

        // GMO後払い決済のリクエストパラメータを設定
        $arrDeferredParameter = array(
                    'delivery_code' => '99',
                    'consignee_postal' => $Shipping->getZip01().$Shipping->getZip02(),
                    'consignee_name' => $Shipping->getName01().$Shipping->getName02(),
                    'consignee_address' => $Shipping->getPref().$Shipping->getAddr01().$Shipping->getAddr02(),
                    'consignee_tel' => $Shipping->getTel01().$Shipping->getTel02().$Shipping->getTel03(),
                    'orderer_postal' => $Order->getZip01().$Order->getZip02(),
                    'orderer_name' => $Order->getName01().$Order->getName02(),
                    'orderer_address' => $Order->getPref().$Order->getAddr01().$Order->getAddr02(),
                    'orderer_tel' => $Order->getTel01().$Order->getTel02().$Order->getTel03(),
        );
        $arrParameter = array_merge($arrParameter, $arrDeferredParameter);

        return $arrParameter;
    }

    /**
     * チェックするレスポンスパラメータのキーを取得
     *
     * @return array
     */
    function getCheckParameter()
    {
        return array('trans_code', 'order_number', 'user_id', 'state', 'payment_code');
    }

}
