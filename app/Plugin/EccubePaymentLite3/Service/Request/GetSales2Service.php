<?php

namespace Plugin\EccubePaymentLite3\Service\Request;

use Eccube\Application;
use Plugin\EccubePaymentLite3\Service\Client\GmoEpsilon_Base;
use Plugin\EccubePaymentLite3\Util\PluginUtil;

class GetSales2Service
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
     * @param null $transCode
     * @param null $orderNo
     * @return array
     */
    public function handle($transCode = null, $orderNo = null)
    {
        $status = 'NG';
        $objPlugin =& PluginUtil::getInstance($this->app);

        if (empty($transCode) && empty($orderNo)) {
            return array(
                'result' => $this->const['receive_parameters']['result']['ng'],
                'err_code' => 'trans_code、もしくはorder_numberいずれかのパラメータが必要です',
                'message' => '',
                'status' => $status,
                'order_number' => $orderNo,
                'payment_code' => '',
            );
        }

        // Init params
        $params = array('contract_code' => $objPlugin->getSubData('contract_code'));
        if (!empty($transCode)) {
            $params['trans_code'] = $transCode;
        } else {
            $params['order_number'] = $orderNo;
        }

        // Make Request
        $arrXML = $this->gmoEpsilonBaseService->sendData($objPlugin->getUrl('getsales'), $params);

        $message = $this->gmoEpsilonBaseService->getXMLValue($arrXML, 'RESULT', 'ERR_DETAIL');
        $result = (int) $this->gmoEpsilonBaseService->getXMLValue($arrXML, 'RESULT', 'RESULT');

        if ($result === 0) {
            $message = '正常終了';
            $status = 'OK';
        }

        return array(
            'result' => (int) $this->gmoEpsilonBaseService->getXMLValue($arrXML, 'RESULT', 'RESULT'),
            'err_code' => (int) $this->gmoEpsilonBaseService->getXMLValue($arrXML, 'RESULT', 'ERR_CODE'),
            'message' => $message,
            'status' => $status,
            'route' => $this->gmoEpsilonBaseService->getXMLValue($arrXML, 'RESULT', 'MEMO1'),
            'order_number' => (int) $this->gmoEpsilonBaseService->getXMLValue($arrXML, 'RESULT', 'ORDER_NUMBER'),
            'payment_code' => $this->gmoEpsilonBaseService->getXMLValue($arrXML, 'RESULT', 'PAYMENT_CODE'),
        );
    }
}
