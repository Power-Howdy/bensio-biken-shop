<?php

namespace Plugin\EccubePaymentLite3\Service\Request;

use Eccube\Application;
use Eccube\Common\Constant;
use Eccube\Entity\Customer;
use Eccube\Entity\Order;
use Eccube\Repository\PluginRepository;
use Plugin\EccubePaymentLite3\Service\Client\GmoEpsilon_Base;
use Plugin\EccubePaymentLite3\Service\GmoEpsilonService;
use Plugin\EccubePaymentLite3\Util\PluginUtil;

class ReceiveOrderService
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
     * @var GmoEpsilonService
     */
    private $gmoEpsilonService;

    /**
     * @var PluginRepository
     */
    private $pluginRepository;

    /**
     * constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->const = $app['config']['EccubePaymentLite3']['const'];
        $this->gmoEpsilonBaseService = $app['eccube.plugin.epsilon.service.base'];
        $this->gmoEpsilonService = $app['eccube.plugin.epsilon.services'];
        $this->pluginRepository = $app['eccube.repository.plugin'];
    }

    /**
     * @param Customer $Customer
     * @param int $processCode
     * @param string $route
     * @param Order $Order
     * @return array
     */
    public function handle($Customer, $processCode, $route, $Order = null)
    {
        // Write Log
        $this->app['monolog.gmoepsilon']->addInfo('【ReceiveOrderService】-【Start】');

        $status = 'NG';
        $objPlugin =& PluginUtil::getInstance($this->app);

        $pluginVersion = $this->pluginRepository->findOneBy(array('code' => 'EccubePaymentLite3'))->getVersion();

        // Init params
        $parameters = array(
            'contract_code' => $objPlugin->getSubData('contract_code'),
            'user_id' => $Customer->getId(),
            'user_name' => $Customer->getName01().' '.$Customer->getName02(),
            'user_mail_add' => $Customer->getEmail(),
            'st_code' => '11000-0000-00000-00000-00000-00000-00000',
            'process_code' => $processCode,
            'memo1' => $route,
            'memo2' => 'EC-CUBE_' . Constant::VERSION . '_' . $pluginVersion . "_" . date('YmdHis'),
            'xml' => 1,
            'version' => 1,
        );

        if ($processCode === 2) {
            $itemInformation = $this->gmoEpsilonService->getProductInfo($Order);

            $parameters['item_code'] = $itemInformation['item_code'];
            $parameters['item_name'] = $itemInformation['item_name'];
            $parameters['order_number'] = $Order->getId();
            $parameters['mission_code'] = 1;
            $parameters['item_price'] = (int) $Order->getPaymentTotal();
        }

        // Make Request
        $arrXML = $this->gmoEpsilonBaseService->sendData($objPlugin->getUrl('receive_order3'), $parameters);

        // Write Log
        $this->app['monolog.gmoepsilon']->addInfo('Param: ' . print_r($parameters, true));
        $this->app['monolog.gmoepsilon']->addInfo('Result: ' . print_r($arrXML, true));

        $message = $this->gmoEpsilonBaseService->getXMLValue($arrXML, 'RESULT', 'ERR_DETAIL');
        $result = (int) $this->gmoEpsilonBaseService->getXMLValue($arrXML, 'RESULT', 'RESULT');

        if ($result === $this->const['receive_parameters']['result']['ok']) {
            $message = '正常終了';
            $status = 'OK';
        }

        // Write Log
        $this->app['monolog.gmoepsilon']->addInfo('【ReceiveOrderService】-【End】');

        return array(
            'result' => (int) $this->gmoEpsilonBaseService->getXMLValue($arrXML, 'RESULT', 'RESULT'),
            'err_code' => (int) $this->gmoEpsilonBaseService->getXMLValue($arrXML, 'RESULT', 'ERR_CODE'),
            'message' => $message,
            'status' => $status,
            'url' => $this->gmoEpsilonBaseService->getXMLValue($arrXML, 'RESULT', 'REDIRECT'),
        );
    }
}
