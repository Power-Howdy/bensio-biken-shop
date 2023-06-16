<?php

namespace Plugin\EccubePaymentLite3\Service\Client;

use Eccube\Application;
use Eccube\Entity\Order;
use Plugin\EccubePaymentLite3\Entity\Extension\PaymentExtension;

/**
 * 決済モジュール 決済処理：バーチャル口座
 */
class GmoEpsilon_Virtual_Account extends GmoEpsilon_Base
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
     * チェックするレスポンスパラメータのキーを取得
     *
     * @return array
     */
    function getCheckParameter()
    {
        return array(
            'trans_code',
            'user_id',
            'result',
            'order_number',
            );
    }

    /**
     * リクエストパラメータを設定
     *
     * @param Order $Order
     * @param PaymentExtension
     * @return array
     */
    function setParameter($Order, $PaymentExtension) {
        $arrParameter = parent::setParameter($Order, $PaymentExtension);
        $arrParameter['version'] = '2';

        return $arrParameter;
    }
}
