<?php


namespace Plugin\EccubePaymentLite3\Util;

use Eccube\Application;

/**
 * 決済モジュール用 汎用関数クラス
 */
class PaymentUtil
{

    private $app;
    private $const;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->const = $app['config']['EccubePaymentLite3']['const'];
    }

    function getPaymentTypeConfig($paymentId)
    {
        $PaymentExtension = $this->app['eccube.plugin.epsilon.repository.payment_extension']->find($paymentId);
        if (empty($PaymentExtension)) {
            return false;
        }

        return $PaymentExtension;
    }


    /**
     * 決済モジュールで利用出来る決済方式の名前一覧を取得する
     *
     * @param integer $tokenOption : 1 = use token, 0 = use credit
     * @return array 支払方法
     */
    function getPaymentNames()
    {
        $payments =  array(
            $this->const['PAY_ID_CREDIT'] => $this->const['PAY_NAME_CREDIT'],
            $this->const['PAY_ID_REG_CREDIT'] => $this->const['PAY_NAME_REG_CREDIT'],
            $this->const['PAY_ID_CONVENI'] => $this->const['PAY_NAME_CONVENI'],
            $this->const['PAY_ID_NETBANK_JNB'] => $this->const['PAY_NAME_NETBANK_JNB'],
            $this->const['PAY_ID_NETBANK_RAKUTEN'] => $this->const['PAY_NAME_NETBANK_RAKUTEN'],
            $this->const['PAY_ID_SUMISHIN'] => $this->const['PAY_NAME_SUMISHIN'],
            $this->const['PAY_ID_PAYEASY'] => $this->const['PAY_NAME_PAYEASY'],
            $this->const['PAY_ID_WEBMONEY'] => $this->const['PAY_NAME_WEBMONEY'],
            $this->const['PAY_ID_YWALLET'] => $this->const['PAY_NAME_YWALLET'],
            $this->const['PAY_ID_PAYPAL'] => $this->const['PAY_NAME_PAYPAL'],
            $this->const['PAY_ID_BITCASH'] => $this->const['PAY_NAME_BITCASH'],
            $this->const['PAY_ID_CHOCOM'] => $this->const['PAY_NAME_CHOCOM'],
            $this->const['PAY_ID_SPHONE'] => $this->const['PAY_NAME_SPHONE'],
            $this->const['PAY_ID_JCB'] => $this->const['PAY_NAME_JCB'],
            $this->const['PAY_ID_DEFERRED'] => $this->const['PAY_NAME_DEFERRED'],
            $this->const['PAY_ID_VIRTUAL_ACCOUNT'] => $this->const['PAY_NAME_VIRTUAL_ACCOUNT'],
            $this->const['PAY_ID_PAYPAY'] => $this->const['PAY_NAME_PAYPAY'],
            $this->const['PAY_ID_MAIL'] => $this->const['PAY_NAME_MAIL'],
        );

        return $payments;
    }

    function getRegPaymentNames() {
        $payments = array(
            $this->const['PAY_ID_EVERY_MONTH'] => $this->const['PAY_NAME_EVERY_MONTH'],
            $this->const['PAY_ID_EVERY_OTHER_MONTH'] => $this->const['PAY_NAME_EVERY_OTHER_MONTH'],
            $this->const['PAY_ID_EVERY_THREE_MONTH'] => $this->const['PAY_NAME_EVERY_THREE_MONTH'],
            $this->const['PAY_ID_EVERY_SIX_MONTH'] => $this->const['PAY_NAME_EVERY_SIX_MONTH'],
            $this->const['PAY_ID_EVERY_YEAR'] => $this->const['PAY_NAME_EVERY_YEAR'],
        );

        return $payments;
    }

    function getConvenienceNames()
    {
        $conveniences =  array(
            $this->const['CONVENI_ID_SEVENELEVEN'] => $this->const['CONVENI_NAME_SEVENELEVEN'],
            $this->const['CONVENI_ID_FAMILYMART'] => $this->const['CONVENI_NAME_FAMILYMART'],
            $this->const['CONVENI_ID_LAWSON'] => $this->const['CONVENI_NAME_LAWSON'],
            $this->const['CONVENI_ID_SEICOMART'] => $this->const['CONVENI_NAME_SEICOMART'],
            $this->const['CONVENI_ID_MINISTOP'] => $this->const['CONVENI_NAME_MINISTOP'],
            // $this->const['EPSILON_CONVENIID_PAYEASY'] => $this->const['EPSILON_CONVENINAME_PAYEASY'],
        );

        return $conveniences;
    }

    /**
     * SSLバージョン情報の一覧を取得
     * @return array
     */
    function getSSLVersionName() {
    	$sslVersionNames = array(
    			$this->const['CURL_SSLVERSION_DEFAULT_NUMBER'] => $this->const['CURL_SSLVERSION_DEFAULT_NAME'],
    			$this->const['CURL_SSLVERSION_TLSv1_NUMBER'] => $this->const['CURL_SSLVERSION_TLSv1_NAME'],
    			$this->const['CURL_SSLVERSION_SSLv2_NUMBER'] => $this->const['CURL_SSLVERSION_SSLv2_NAME'],
    			$this->const['CURL_SSLVERSION_SSLv3_NUMBER'] => $this->const['CURL_SSLVERSION_SSLv3_NAME'],
    			$this->const['CURL_SSLVERSION_TLSv1_0_NUMBER'] => $this->const['CURL_SSLVERSION_TLSv1_0_NAME'],
    			$this->const['CURL_SSLVERSION_TLSv1_1_NUMBER'] => $this->const['CURL_SSLVERSION_TLSv1_1_NAME'],
    			$this->const['CURL_SSLVERSION_TLSv1_2_NUMBER'] => $this->const['CURL_SSLVERSION_TLSv1_2_NAME'],
    	);

    	return $sslVersionNames;
    }

    function getSSLVersionNumber() {
    	$sslVersionNumber = array(
    			$this->const['CURL_SSLVERSION_DEFAULT_NUMBER'] => $this->const['CURL_SSLVERSION_DEFAULT_NUMBER'],
    			$this->const['CURL_SSLVERSION_TLSv1_NUMBER'] => $this->const['CURL_SSLVERSION_TLSv1_NUMBER'],
    			$this->const['CURL_SSLVERSION_SSLv2_NUMBER'] => $this->const['CURL_SSLVERSION_SSLv2_NUMBER'],
    			$this->const['CURL_SSLVERSION_SSLv3_NUMBER'] => $this->const['CURL_SSLVERSION_SSLv3_NUMBER'],
    			$this->const['CURL_SSLVERSION_TLSv1_0_NUMBER'] => $this->const['CURL_SSLVERSION_TLSv1_0_NUMBER'],
    			$this->const['CURL_SSLVERSION_TLSv1_1_NUMBER'] => $this->const['CURL_SSLVERSION_TLSv1_1_NUMBER'],
    			$this->const['CURL_SSLVERSION_TLSv1_2_NUMBER'] => $this->const['CURL_SSLVERSION_TLSv1_2_NUMBER'],
    	);

    	return $sslVersionNumber;
    }
}
