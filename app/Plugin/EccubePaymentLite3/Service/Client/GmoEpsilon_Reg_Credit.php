<?php

namespace Plugin\EccubePaymentLite3\Service\Client;

use Eccube\Application;
use Eccube\Entity\Order;
use Plugin\EccubePaymentLite3\Entity\Extension\PaymentExtension;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * 決済モジュール 決済処理：登録済みのクレジットカードで決済
 */
class GmoEpsilon_Reg_Credit extends GmoEpsilon_Base
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
     * Check Ip Black List
     *
     * @return bool
     */
    function checkIpBlackList() {
        return $this->app['eccube.plugin.epsilon.service.ip_black_list']->handle();
    }

    /**
     * 決済処理
     *
     * @param Order $Order
     * @param PaymentExtension $PaymentExtension
     * @return RedirectResponse
     */
    function payProcess($Order, $PaymentExtension)
    {
        // 不正アクセスブロック処理を行う
        $error_page_flg = $this->accessBlockProcess();

        // ブロック対象の場合エラーを表示し、処理を中断
        if($error_page_flg){
            $error_title = '購入エラー';
            $error_message = '購入処理でエラーが発生しました。';
            return $this->app['view']->render('error.twig', compact('error_title', 'error_message'));
        }

        if ($this->checkIpBlackList()) {
            $error_title = '購入エラー';
            $error_message = '購入処理でエラーが発生しました。';
            return $this->app['view']->render('error.twig', compact('error_title', 'error_message'));
        }
        return parent::payProcess($Order, $PaymentExtension);
    }

    /**
     * チェックするレスポンスパラメータのキーを取得
     *
     * @return array
     */
    function getCheckParameter()
    {
        return array('trans_code', 'user_id', 'result', 'order_number');
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

        $arrParameter['user_id'] = $arrParameter['user_id'] == 'non_customer' ? '' : $arrParameter['user_id'];
        // 処理区分(登録済み課金)
        $arrParameter['process_code'] = "2";
        $Shipping = $Order->getShippings()[0];
        // Start specific params of 3ds 2.0
        $arr3DS2Parameter = array(
            'tds_flag'=>'21', // 3DS2.0フラ グ
            'billAddrCity' => $Order->getPref()->getName(), // 請求先住所(都市)
            'billAddrCountry' => 392, // 請求先住所(国番号) =>  set default is Japan
            'billAddrLine1' => $Order->getAddr01(), // 請求先住所(区域部分_1行目)
            'billAddrLine2' => $Order->getAddr02(), // 請求先住所(区域部分_2行目)
            'billAddrLine3' => '', // 請求先住所(区域部分_3行目)
            'billAddrPostCode' => $Order->getZip01().$Order->getZip02(), // 請求先住所(郵便番号)
            'billAddrState' => $Order->getPref()->getId(), // 請求先住所 (州または都道府県番号)
            'shipAddrCity' => $Shipping->getPref()->getName(), // 送り先住所(都市)
            'shipAddrCountry' => 392, // 送り先住所(国番号) => set default is Japan
            'shipAddrLine1' => $Shipping->getAddr01(), // 送り先住所(区域部分_1行目)
            'shipAddrLine2' => $Shipping->getAddr02(), // 送り先住所(区域部分_2行目)
            'shipAddrLine3' => '', // 送り先住所(区域部分_3行目)
            'shipAddrPostCode' => $Shipping->getZip01().$Shipping->getZip02(), // 送り先住所(郵便番号)
            'shipAddrState' => $Shipping->getPref()->getId(), // 送り先住所 (州または都道府県番号)
            'threeDSReqAuthMethod' => '02', // ログイ ン認証方法
            'challengeInd' => '04', // チャレンジ要求
        );
        // End sample specific params of 3ds 2.0
        return  array_merge($arrParameter, $arr3DS2Parameter);

    }

}
