<?php

namespace Plugin\EccubePaymentLite3\Service\Request;

use Eccube\Application;
use Plugin\EccubePaymentLite3\Util\PluginUtil;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GetUserInfoService
{
    /** @var Application */
    public $app;

    public $const;

    /**
     * RequestGetUserInfoService constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->const = $app['config']['EccubePaymentLite3']['const'];
        $this->gmoEpsilonService = $app['eccube.plugin.epsilon.services'];
        $this->gmoEpsilonRequestService = $app['eccube.plugin.epsilon.request.services'];
    }

    public function handle()
    {
        $status = 'NG';
        $objPlugin =& PluginUtil::getInstance($this->app);
        $contract_code = $objPlugin->getSubData('contract_code');

        if (!$this->app->isGranted('ROLE_USER')) {
            return array(
                'result' => $this->const['receive_parameters']['result']['ng'],
                'err_code' => '',
                'message' => 'ログインしていません。',
                'status' => $status,
            );
        }
        $Customer = $this->app['user'];
        $responseXml = $this->gmoEpsilonRequestService->sendData(
            $this->gmoEpsilonService->getUrl('get_user_info'), array(
                'contract_code' => $contract_code,
                'user_id' => $Customer->getId(),
            )
        );

        $message = $this->gmoEpsilonRequestService->getXMLValue($responseXml, 'RESULT', 'ERR_DETAIL');
        $result = (int) $this->gmoEpsilonRequestService->getXMLValue($responseXml, 'RESULT', 'RESULT');

        $cardExpire = '';
        $cardNumberMask = '';
        // 正常にカード番号が取得出来た場合はカード情報を返却する
        if ($result === $this->const['receive_parameters']['result']['ok']) {
            $message = '正常終了';
            $status = 'OK';
            $cardExpire = $this->gmoEpsilonRequestService->getXMLValue($responseXml, 'RESULT', 'CARD_EXPIRE');
            $cardExpire = mb_substr($cardExpire, 0, 4).'/'.mb_substr($cardExpire, 4, 2);
            $cardNumberMask = explode('-', $this->gmoEpsilonRequestService->getXMLValue($responseXml, 'RESULT', 'CARD_NUMBER_MASK'))[3];
        }

        return array(
            'result' => (int) $this->gmoEpsilonRequestService->getXMLValue($responseXml, 'RESULT', 'RESULT'),
            'err_code' => (int) $this->gmoEpsilonRequestService->getXMLValue($responseXml, 'RESULT', 'ERR_CODE'),
            'message' => $message,
            'status' => $status,
            'cardBrand' => $this->gmoEpsilonRequestService->getXMLValue($responseXml, 'RESULT', 'CARD_BRAND'),
            'cardExpire' => $cardExpire,
            'cardNumberMask' => $cardNumberMask,
        );
    }
}
