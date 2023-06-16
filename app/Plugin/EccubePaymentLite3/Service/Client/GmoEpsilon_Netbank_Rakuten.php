<?php

namespace Plugin\EccubePaymentLite3\Service\Client;

use Eccube\Application;

/**
 * 決済モジュール 決済処理：ネット銀行決済(楽天銀行)
 */
class GmoEpsilon_Netbank_Rakuten extends GmoEpsilon_Base
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
        return array('trans_code', 'order_number', 'user_id', 'state', 'payment_code');
    }

}
