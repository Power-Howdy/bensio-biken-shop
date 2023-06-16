<?php

namespace Plugin\EccubePaymentLite3\Service\Request;

use Eccube\Application;
use Eccube\Entity\Order;
use Plugin\EccubePaymentLite3\Entity\Extension\OrderExtension;
use Plugin\EccubePaymentLite3\Service\Client\GmoEpsilon_Base;
use Plugin\EccubePaymentLite3\Util\PluginUtil;

/**
 * イプシロン決済サービスの取引の実売上APIを利用するためのクラス
 */
class SalesPaymentService
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
        $this->app['monolog.gmoepsilon']->addInfo('【SalesPaymentService】-【Start】');

        $status = 'NG';

        /** @var OrderExtension $OrderExtension */
        $OrderExtension = $this->app['eccube.plugin.epsilon.repository.order_extension']->find($Order->getId());

        // gmo_epsilon_order_noのチェック
        if (!($OrderExtension instanceof OrderExtension) || is_null($OrderExtension->getGmoEpsilonOrderNo())) {
            return array(
                'result' => $this->const['receive_parameters']['result']['ng'],
                'message' => '受注ID: '.$Order->getId().' GMOイプシロンIDが未登録のため、イプシロン決済サービスとの同期処理をスキップしました',
                'status' => $status,
                'route' => '',
            );
        }

        // 実売上処理を行う決済方法は
        // クレジットカード決済、登録済みのクレジットカード決済、Yahoo!ウォレット決済、スマホキャリア決済、paypay
        $paymentMethods = array(
            $this->const['PAY_NAME_CREDIT'],
            $this->const['PAY_NAME_REG_CREDIT'],
            $this->const['PAY_NAME_YWALLET'],
            $this->const['PAY_NAME_SPHONE'],
            $this->const['PAY_NAME_PAYPAY'],
        );
        if (!in_array($Order->getPaymentMethod(), $paymentMethods)) {
            return array(
                'result' => $this->const['receive_parameters']['result']['ok'],
                'err_code' => '',
                'message' => '受注ID: '.$Order->getId().' '.$Order->getPaymentMethod().'はイプシロン決済サービスとのステータス同期を行いません',
                'status' => $status,
                'route' => '',
            );
        }

        // Make Request
        $objPlugin =& PluginUtil::getInstance($this->app);
        $parameters = array(
            'contract_code' => $objPlugin->getSubData('contract_code'),
            'order_number' => $OrderExtension->getGmoEpsilonOrderNo(),
        );
        $arrXML = $this->gmoEpsilonBaseService->sendData($objPlugin->getUrl('sales_payment'), $parameters);

        // Write Log
        $this->app['monolog.gmoepsilon']->addInfo('Param: ' . print_r($parameters, true));
        $this->app['monolog.gmoepsilon']->addInfo('Result: ' . print_r($arrXML, true));

        $message = $this->gmoEpsilonBaseService->getXMLValue($arrXML, 'RESULT', 'ERR_DETAIL');
        $result = (int) $this->gmoEpsilonBaseService->getXMLValue($arrXML, 'RESULT', 'RESULT');

        if ($result === $this->const['receive_parameters']['result']['ok']) {
            $message = '受注ID: '.$Order->getId().' 実売上処理が完了しました。イプシロン決済システムの決済ステータスが「仮売上」→ 「課金済み」に変更されました。';
            $status = 'OK';
        }

        // Write Log
        $this->app['monolog.gmoepsilon']->addInfo('【SalesPaymentService】-【End】');

        return array(
            'result' => (int) $this->gmoEpsilonBaseService->getXMLValue($arrXML, 'RESULT', 'RESULT'),
            'err_code' => (int) $this->gmoEpsilonBaseService->getXMLValue($arrXML, 'RESULT', 'ERR_CODE'),
            'message' => $message,
            'status' => $status,
            'route' => $this->gmoEpsilonBaseService->getXMLValue($arrXML, 'RESULT', 'MEMO1'),
        );
    }
}
