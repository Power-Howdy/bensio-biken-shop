<?php

namespace Plugin\EccubePaymentLite3\Service\Request;

use Eccube\Application;
use Eccube\Entity\Order;
use Plugin\EccubePaymentLite3\Entity\Extension\OrderExtension;
use Plugin\EccubePaymentLite3\Service\Client\GmoEpsilon_Base;
use Plugin\EccubePaymentLite3\Util\PluginUtil;

/**
 * イプシロン決済サービスの取引の取消APIを利用するためのクラス
 */
class CancelPaymentService
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

        // 決済方法が
        // クレジットカード決済、Yahoo!ウォレット決済、PayPal決済、スマホキャリア決済、GMO後払い
        // 以外の場合はリクエストを行わない
        $paymentMethods = array(
            $this->const['PAY_NAME_CREDIT'],
            $this->const['PAY_NAME_REG_CREDIT'],
            $this->const['PAY_NAME_YWALLET'],
            $this->const['PAY_NAME_PAYPAL'],
            $this->const['PAY_NAME_SPHONE'],
            $this->const['PAY_NAME_DEFERRED'],
        );
        if (!in_array($Order->getPaymentMethod(), $paymentMethods)) {
            return array(
                'result' => $this->const['receive_parameters']['result']['ok'],
                'err_code' => '',
                'message' => '受注ID: '.$Order->getId().' '.$Order->getPaymentMethod().'はイプシロン決済サービスとのステータス同期を行いません',
                'status' => $status,
            );
        }

        // Make Request
        $objPlugin =& PluginUtil::getInstance($this->app);
        $arrXML = $this->gmoEpsilonBaseService->sendData($objPlugin->getUrl('cancel_payment'), array(
            'contract_code' => $objPlugin->getSubData('contract_code'),
            'order_number' => $OrderExtension->getGmoEpsilonOrderNo(),
        ));

        $message = $this->gmoEpsilonBaseService->getXMLValue($arrXML, 'RESULT', 'ERR_DETAIL');
        $result = (int) $this->gmoEpsilonBaseService->getXMLValue($arrXML, 'RESULT', 'RESULT');

        if ($result === $this->const['receive_parameters']['result']['ok']) {
            $message = 'キャンセル処理が完了しました。イプシロン決済システムの決済ステータスが「キャンセル」に変更されました。';
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
