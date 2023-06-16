<?php

namespace Plugin\EccubePaymentLite3\Service\Client;

use Eccube\Application;

/**
 * 決済モジュール 決済処理：WebMoney決済
 */
class GmoEpsilon_Webmoney extends GmoEpsilon_Base
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
        return array('trans_code','user_id','result','order_number');
    }

}
