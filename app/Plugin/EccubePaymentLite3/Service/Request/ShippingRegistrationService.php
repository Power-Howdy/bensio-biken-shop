<?php

namespace Plugin\EccubePaymentLite3\Service\Request;

use Eccube\Application;
use Eccube\Entity\Order;
use Eccube\Entity\Shipping;
use Plugin\EccubePaymentLite3\Entity\Extension\DeliveryExtension;
use Plugin\EccubePaymentLite3\Entity\Extension\OrderExtension;
use Plugin\EccubePaymentLite3\Entity\Extension\ShippingExtension;
use Plugin\EccubePaymentLite3\Entity\Master\DeliveryCompany;
use Plugin\EccubePaymentLite3\Service\Client\GmoEpsilon_Base;
use Plugin\EccubePaymentLite3\Util\PluginUtil;

class ShippingRegistrationService
{
    /**
     * @var Application
     */
    private $app;

    /**
     * @var array
     */
    private $const;

    /**
     * @var GmoEpsilon_Base
     */
    private $gmoEpsilonBaseService;

    /**
     * constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->const = $app['config']['EccubePaymentLite3']['const'];
        $this->gmoEpsilonBaseService = $app['eccube.plugin.epsilon.service.base'];
    }

    /**
     * Handle
     *
     * @param Order $Order
     * @return array
     */
    public function handle($Order)
    {
        // Write Log
        $this->app['monolog.gmoepsilon']->addInfo('【ShippingRegistrationService】-【Start】');

        $status = 'NG';

        /** @var OrderExtension $OrderExtension */
        $OrderExtension = $this->app['eccube.plugin.epsilon.repository.order_extension']->find($Order->getId());

        // gmo_epsilon_order_noのチェック
        if (!($OrderExtension instanceof OrderExtension) || is_null($OrderExtension->getGmoEpsilonOrderNo())) {
            return array(
                'result' => $this->const['receive_parameters']['result']['ng'],
                'err_code' => '',
                'message' => '受注ID: '.$Order->getId().' GMOイプシロンIDが未登録のため、イプシロン決済サービスとの同期処理をスキップしました',
                'status' => $status,
            );
        }

        // 決済種別のチェック
        // GMO後払いではない場合処理をスキップする
        if ($Order->getPaymentMethod() !== $this->const['PAY_NAME_DEFERRED']) {
            return array(
                'result' => $this->const['receive_parameters']['result']['ng'],
                'err_code' => '',
                'message' => '受注ID: '.$Order->getId().' 決済種別がGMO後払いではないため、イプシロン決済サービスとの同期処理をスキップしました',
                'status' => $status,
            );
        }

        /** @var Shipping $Shipping */
        $Shipping = $Order->getShippings()->first();
        /** @var ShippingExtension $ShippingExtension */
        $ShippingExtension = $this->app['eccube.plugin.epsilon.repository.shipping_extension']->find($Shipping->getId());
        $trackingNumber = $ShippingExtension ? $ShippingExtension->getTrackingNumber() : null;

        // trackingNumberのチェック
        if (empty($trackingNumber)) {
            return array(
                'result' => $this->const['receive_parameters']['result']['ng'],
                'err_code' => '',
                'message' => '受注ID: '.$Order->getId().' お問い合わせ番号が未登録のため、イプシロン決済サービスとの同期処理をスキップしました',
                'status' => $status,
            );
        }

        $Delivery = $Shipping->getDelivery();
        /** @var DeliveryExtension $DeliveryExtension */
        $DeliveryExtension = $this->app['eccube.plugin.epsilon.repository.delivery_extension']->find($Delivery->getId());
        /** @var DeliveryCompany $DeliveryCompany */
        $DeliveryCompany = $DeliveryExtension ? $DeliveryExtension->getDeliveryCompany() : null;

        // Make Request
        $objPlugin =& PluginUtil::getInstance($this->app);
        $parameters = array(
            'contract_code' => $objPlugin->getSubData('contract_code'),
            'order_number' => $OrderExtension->getGmoEpsilonOrderNo(),
            'delivery_com_code' => $DeliveryCompany ? $DeliveryCompany->getId() : '',
            'ship_no' => $trackingNumber,
        );
        $arrXML = $this->gmoEpsilonBaseService->sendData($objPlugin->getUrl('ship_request'), $parameters);

        // Write Log
        $this->app['monolog.gmoepsilon']->addInfo('Param: ' . print_r($parameters, true));
        $this->app['monolog.gmoepsilon']->addInfo('Result: ' . print_r($arrXML, true));

        $message = $this->gmoEpsilonBaseService->getXMLValue($arrXML, 'RESULT', 'ERR_DETAIL');
        $result = (int) $this->gmoEpsilonBaseService->getXMLValue($arrXML, 'RESULT', 'RESULT');

        if ($result === $this->const['receive_parameters']['result']['ok']) {
            $message = '受注ID: '.$Order->getId().' 出荷登録処理が完了しました。イプシロン決済システムの決済ステータスが「仮売上」→ 「出荷登録中」に変更されました。';
            $status = 'OK';
        }

        // Write Log
        $this->app['monolog.gmoepsilon']->addInfo('【ShippingRegistrationService】-【End】');

        return array(
            'result' => (int) $this->gmoEpsilonBaseService->getXMLValue($result, 'RESULT', 'RESULT'),
            'err_code' => (int) $this->gmoEpsilonBaseService->getXMLValue($result, 'RESULT', 'ERR_CODE'),
            'message' => $message,
            'status' => $status
        );
    }
}
