<?php

namespace Plugin\EccubePaymentLite3\Service\Request;

use Eccube\Application;
use Eccube\Entity\Order;
use Eccube\Entity\OrderDetail;
use Plugin\EccubePaymentLite3\Entity\Extension\OrderExtension;
use Plugin\EccubePaymentLite3\Service\Client\GmoEpsilon_Base;
use Plugin\EccubePaymentLite3\Util\PluginUtil;

class ChangePaymentAmountService
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

        $paymentMethods = array(
            $this->const['PAY_NAME_CREDIT'],
            $this->const['PAY_NAME_REG_CREDIT'],
            $this->const['PAY_NAME_YWALLET'],
        );
        if (!in_array($Order->getPaymentMethod(), $paymentMethods)) {
            return array(
                'result' => $this->const['receive_parameters']['result']['ok'],
                'err_code' => '',
                'message' => '受注ID: '.$Order->getId().' 決済種別'.$Order->getPaymentMethod().'は、金額変更に対応していないため、イプシロン決済サービスとの同期処理をスキップしました',
                'status' => $status,
            );
        }

        /** @var OrderDetail $OrderDetail */
        $OrderDetail = $Order->getOrderDetails()->first();
        $productCode = $OrderDetail->getProductCode();

        // Make Request
        $objPlugin =& PluginUtil::getInstance($this->app);
        $arrXML = $this->gmoEpsilonBaseService->sendData($objPlugin->getUrl('change_amount_payment'), array(
            'contract_code' => $objPlugin->getSubData('contract_code'),
            'mission_code' => 1, // TODO マジックナンバー
            'order_number' => $OrderExtension->getGmoEpsilonOrderNo(),
            'user_id' => $Order->getCustomer()->getId(),
            'item_code' => $productCode,
            'new_item_price' => $Order->getPaymentTotal(),
        ));

        $message = $this->gmoEpsilonBaseService->getXMLValue($arrXML, 'RESULT', 'ERR_DETAIL');
        $result = (int) $this->gmoEpsilonBaseService->getXMLValue($arrXML, 'RESULT', 'RESULT');

        if ($result === $this->const['receive_parameters']['result']['ok']) {
            $message = '受注ID: '.$Order->getId().' イプシロン決済システムの金額が変更されました';
            $status = 'OK';
        }

        return array(
            'result' => $result,
            'err_code' => (int) $this->gmoEpsilonBaseService->getXMLValue($arrXML, 'RESULT', 'ERR_CODE'),
            'message' => $message,
            'status' => $status,
        );
    }
}
