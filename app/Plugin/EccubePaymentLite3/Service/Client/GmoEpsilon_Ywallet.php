<?php

namespace Plugin\EccubePaymentLite3\Service\Client;

use Eccube\Application;

/**
 * 決済モジュール 決済処理：Yahoo!ウォレット決済サービス
 */
class GmoEpsilon_Ywallet extends GmoEpsilon_Base
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
        return array('contract_code', 'trans_code', 'order_number', 'user_id', 'state', 'payment_code');
    }

}
