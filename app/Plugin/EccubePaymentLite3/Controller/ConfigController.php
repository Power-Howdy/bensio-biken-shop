<?php

namespace Plugin\EccubePaymentLite3\Controller;

use Eccube\Application;
use Eccube\Entity\Master\ProductType;
use Plugin\EccubePaymentLite3\Entity\GmoEpsilonPlugin;
use Plugin\EccubePaymentLite3\Util\PaymentUtil;
use Plugin\EccubePaymentLite3\Util\PluginUtil;
use Plugin\EccubePaymentLite3\Form\Type\Admin\ConfigType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;


/**
 * Controller to handle module setting screen
 */
class ConfigController
{

    private $app;
    private $const;

    public function index(Application $app, Request $request)
    {
        $this->app = $app;
        $this->const = $app['config']['EccubePaymentLite3']['const'];

        $objPlgUtil =& PluginUtil::getInstance($this->app);
        $objPayUtil = new PaymentUtil($this->app);
        $tpl_subtitle = $objPlgUtil->getName();

        $objPlgUtil->install();

        // Get module code from dtb_plugin
        $self = Yaml::parse(__DIR__ . '/../config.yml');
        $Plugin = $this->app['eccube.repository.plugin']->findOneBy(array('code' => $self['code']));

        if (is_null($Plugin)) {
            $error_title = 'エラー';
            $error_message = "例外エラー<br />プラグインが存在しません。";
            return $this->app['view']->render('error.twig', compact('error_title', 'error_message'));
        }

        $EpsilonPlugin = $this->app['eccube.plugin.epsilon.repository.epsilon_plugin']->findOneBy(array('code' => $Plugin->getCode()));

        if (is_null($EpsilonPlugin)) {
            $error_title = 'エラー';
            $error_message = "例外エラー<br />プラグインが存在しません。";
            return $this->app['view']->render('error.twig', compact('error_title', 'error_message'));
        }

        $subData = $objPlgUtil->getUserSettings();

        $Payments = $objPayUtil->getPaymentNames();
        $configFrom = new ConfigType($this->app, $subData);
        $form = $this->app['form.factory']->createBuilder($configFrom)->getForm();

        if ('POST' === $this->app['request']->getMethod()) {
            $form->handleRequest($this->app['request']);
            if ($form->isValid()) {
                $formData = $form->getData();
                // ssl対応判定
                if (!extension_loaded('openssl')) {
                    $form['environmental_setting']->addError(new FormError('※ このサーバはSSLに対応していません。'));
                }
                // 定期課金を利用する場合、クレジットカード決済が必須チェック
                if ($formData['regular'] == '1' && !in_array($this->const['PAY_ID_CREDIT'], $formData['use_payment'])) {
                    $form['use_payment']->addError(new FormError('※ 定期課金を利用する場合には、クレジットカード決済を有効にしてください。'));
                }

                $st_code = "";
                $st_code .= in_array($this->const['PAY_ID_CREDIT'], $formData['use_payment']) ? "1" : "0";
                $st_code .= "0"; // credit 2
                $st_code .= in_array($this->const['PAY_ID_CONVENI'], $formData['use_payment']) ? "1" : "0";
                $st_code .= in_array($this->const['PAY_ID_NETBANK_JNB'], $formData['use_payment']) ? "1" : "0";
                $st_code .= in_array($this->const['PAY_ID_NETBANK_RAKUTEN'], $formData['use_payment']) ? "1" : "0";
                $st_code .= "-0"; // "-" unused 6
                $st_code .= in_array($this->const['PAY_ID_PAYEASY'], $formData['use_payment']) ? "1" : "0";
                $st_code .= in_array($this->const['PAY_ID_WEBMONEY'], $formData['use_payment']) ? "1" : "0";
                $st_code .= in_array($this->const['PAY_ID_YWALLET'], $formData['use_payment']) ? "1" : "0";
                $st_code .= "-0"; // "-" unused 10
                $st_code .= in_array($this->const['PAY_ID_PAYPAL'], $formData['use_payment']) ? "1" : "0";
                $st_code .= in_array($this->const['PAY_ID_BITCASH'], $formData['use_payment']) ? "1" : "0";
                $st_code .= in_array($this->const['PAY_ID_CHOCOM'], $formData['use_payment']) ? "1" : "0";
                $st_code .= "0-"; // unused 14
                $st_code .= in_array($this->const['PAY_ID_SPHONE'], $formData['use_payment']) ? "1" : "0";
                $st_code .= in_array($this->const['PAY_ID_JCB'], $formData['use_payment']) ? "1" : "0";
                $st_code .= in_array($this->const['PAY_ID_SUMISHIN'], $formData['use_payment']) ? "1" : "0";
                $st_code .= in_array($this->const['PAY_ID_DEFERRED'], $formData['use_payment']) ? "1" : "0";
                $st_code .= '0-00';
                $st_code .= in_array($this->const['PAY_ID_VIRTUAL_ACCOUNT'], $formData['use_payment']) ? "1" : "0";
                $st_code .= '00-';
                $st_code .= in_array($this->const['PAY_ID_PAYPAY'], $formData['use_payment']) ? "1" : "0";
                $st_code .= '0000-00000';

                $arrParameter = array(
                    'contract_code' => $formData['contract_code'],
                    'user_id' => 'connect_test',
                    'user_name' => '接続テスト',
                    'user_mail_add' => 'test@test.co.jp',
                    'st_code' => $st_code,
                    'process_code' => '3',
                    'xml' => '1',
                );
                $destinationUrl = $app['eccube.plugin.epsilon.services']->getUrl('receive_order3', $formData['environmental_setting']);

                $arrXML = $this->app['eccube.plugin.epsilon.service.base']->sendData($destinationUrl, $arrParameter);
                if ($arrXML === false) {
                    $form['environmental_setting']->addError(new FormError('※ 接続できませんでした。'));
                } else {
                    $err_code = $this->app['eccube.plugin.epsilon.service.base']->getXMLValue($arrXML, 'RESULT', 'ERR_CODE');
                    switch ($err_code) {
                        case '':
                            break;
                        case '607':
                            $form['contract_code']->addError(new FormError('※ 契約コードが違います。'));
                            break;
                        default:
                            $form['contract_code']->addError(new FormError('※ '.$this->app['eccube.plugin.epsilon.service.base']->getXMLValue($arrXML, 'RESULT', 'ERR_DETAIL')));
                            break;
                    }
                }

                // 利用コンビニのエラーチェック
                if (in_array($this->const['PAY_ID_CONVENI'], $formData['use_payment']) && empty($formData['use_convenience'])) {
                    $form['use_convenience']->addError(new FormError('※ 利用コンビニが選択されていません。'));
                } else if (in_array($this->const['PAY_ID_CONVENI'], $formData['use_payment']) && !empty($formData['use_convenience'])) {
                    foreach($formData['use_convenience'] as $val){
                        // 送信データ生成
                        $arrParameter['conveni_code'] = $val;			// コンビニコード
                        $arrParameter['user_tel'] = "0300000000";		// ダミー電話番号
                        $arrParameter['user_name_kana'] = "送信テスト";	// ダミー氏名(カナ)
                        $arrParameter['haraikomi_mail'] = 0;	       // 払込メール(送信しない)

                        // データ送信
                        $arrXML = $this->app['eccube.plugin.epsilon.service.base']->sendData($destinationUrl, $arrParameter);

                        // エラーがあるかチェックする
                        $err_code = $this->app['eccube.plugin.epsilon.service.base']->getXMLValue($arrXML, 'RESULT', 'ERR_DETAIL');
                        if(!empty($err_code)) {
                            $form['use_convenience']->addError(new FormError('※ '.$this->app['eccube.plugin.epsilon.service.base']->getXMLValue($arrXML, 'RESULT', 'ERR_DETAIL')));
                            break;
                        }
                    }
                }

                if ($form->isValid()) {
                    $this->app['orm.em']->getConnection()->beginTransaction();
                    $this->savePaymentData($formData, $Payments);
                    $this->app['orm.em']->getConnection()->commit();

                    $this->app->addSuccess('admin.register.complete', 'admin');
                    return $this->app->redirect($this->app['url_generator']->generate('plugin_EccubePaymentLite3_config'));
                }
            }
        }

        return $this->app['view']->render('EccubePaymentLite3/Twig/admin/config.twig',
            array(
                'form' => $form->createView(),
                'tpl_subtitle' => $tpl_subtitle,
                'subData' => $subData,
            ));
    }

    /**
     * プラグイン設定情報、決済情報を登録
     *
     * @param array $data
     * @param array payment method name $Payments
     */
    public function savePaymentData($data, $Payments)
    {
        $objPlgUtil =& PluginUtil::getInstance($this->app);
        $objPayUtil = new PaymentUtil($this->app);

        // 設定値を登録
        $objPlgUtil->registerUserSettings($data);

        $PaymentExtensionRepo = $this->app['eccube.plugin.epsilon.repository.payment_extension'];
        $PaymentExtensionRepo->setConfig($this->const);
        $listId = $PaymentExtensionRepo->getPaymentByCode(true, $this->app);
        // チェックされた決済を登録
        $installedPayment = array();
        // 選択された利用決済を逆順にする
        $use_payment = array_reverse($data['use_payment'], true);
        foreach ($use_payment as $paymentTypeId) {
            //インストールされていなければ新規作成
            $arrDefault = $this->getDefaultPaymentConfig($paymentTypeId);
            $id = $this->savePayment($paymentTypeId, $Payments, $arrDefault);
            $this->saveExtensionPayment($id, $paymentTypeId, $Payments, $arrDefault);

            $installedPayment[] = $id;
        }

        // チェックされていない決済を削除
        if (!empty($listId)) {
            foreach ((array)$listId as $paymentId) {
                if (!in_array($paymentId["id"], $installedPayment)) {
                    $removePayment = $this->app['eccube.repository.payment']->find($paymentId["id"]);
                    if (!empty($removePayment)){
                        $removePayment->setDelFlg(1);
                        $this->app['orm.em']->persist($removePayment);
                    }
                    $this->app['orm.em']->flush();
                }
            }
        }

        $RegPayments = $objPayUtil->getRegPaymentNames();
        $RegPayments = array_reverse($RegPayments, true);
        // 以前の定期利用状況を取得
        $RegularProduct = $this->app['eccube.plugin.epsilon.repository.regular_product']->find(1);
        $pre_regular = $RegularProduct->getRegularFlg();

        if ($data['regular'] == '1') {
            foreach ($RegPayments as $paymentTypeId => $value) {
                //インストールされていなければ新規作成
                $arrDefault = $this->getRegPaymentConfig($paymentTypeId);
                $id = $this->savePayment($paymentTypeId, $RegPayments, $arrDefault);
                $this->saveExtensionPayment($id, $paymentTypeId, $RegPayments, $arrDefault);
            }

            if ($pre_regular === 0) {
                if ($RegularProduct->getCreateFlg() == '0') {
                    // mtb_product_typeに「定期購入商品」を追加
                    $MasterProductTypes = $this->app['eccube.repository.master.product_type']->findAll();
                    $maxId = 0;
                    $maxRank = 0;
                    foreach ($MasterProductTypes as $ProductType) {
                        $maxId = max($maxId, $ProductType->getId());
                        $maxRank = max($maxRank, $ProductType->getRank());
                    }
                    $MasterProductType = new ProductType();
                    $MasterProductType->setId($maxId + 1);
                    $MasterProductType->setName('定期購入商品');
                    $MasterProductType->setRank($maxRank + 1);
                    $this->app['orm.em']->persist($MasterProductType);

                    $RegularProduct->setProductTypeId($maxId + 1);
                    $RegularProduct->setCreateFlg(1);
                }

                $RegularProduct->setRegularFlg(1);

                $this->app['orm.em']->persist($RegularProduct);
                $this->app['orm.em']->flush();
            }
        } else {
            // チェックされていない定期決済情報を削除
            foreach ((array)$RegPayments as $paymentTypeId => $value) {
                $removePaymentExtension = $this->app['eccube.plugin.epsilon.repository.payment_extension']->find($paymentTypeId);

                $removePayment = $this->app['eccube.repository.payment']->find($paymentTypeId);
                if (!empty($removePayment)){
                    $removePayment->setDelFlg(1);
                    $this->app['orm.em']->persist($removePayment);
                }
                $this->app['orm.em']->flush();
            }

            if ($pre_regular === 1) {
                $RegularProduct->setRegularFlg(0);
                $this->app['orm.em']->persist($RegularProduct);
                $this->app['orm.em']->flush();
            }
        }
    }

    /**
     * 決済情報を取得
     *
     * @param integer $paymentTypeId
     * @return array
     */
    function getDefaultPaymentConfig($paymentTypeId)
    {
        $listData = array();
        $listData['charge'] = '0';

        switch ($paymentTypeId) {
            case $this->const['PAY_ID_CREDIT']:
                $listData['rule_max'] = $this->const['CREDIT_RULE_MAX'];
                $listData['st_code'] = $this->const['CREDIT_ST_CODE'];
                break;
            case $this->const['PAY_ID_REG_CREDIT']:
                $listData['rule_max'] = $this->const['REG_CREDIT_RULE_MAX'];
                $listData['st_code'] = $this->const['REG_CREDIT_ST_CODE'];
                break;
            case $this->const['PAY_ID_CONVENI']:
                $listData['rule_max'] = $this->const['CONVENI_RULE_MAX'];
                $listData['st_code'] = $this->const['CONVENI_ST_CODE'];
                break;
            case $this->const['PAY_ID_NETBANK_JNB']:
                $listData['rule_max'] = $this->const['NETBANK_JNB_RULE_MAX'];
                $listData['st_code'] = $this->const['NETBANK_JNB_ST_CODE'];
                break;
            case $this->const['PAY_ID_NETBANK_RAKUTEN']:
                $listData['rule_max'] = $this->const['NETBANK_RAKUTEN_RULE_MAX'];
                $listData['st_code'] = $this->const['NETBANK_RAKUTEN_ST_CODE'];
                break;
            case $this->const['PAY_ID_PAYEASY']:
                $listData['rule_max'] = $this->const['PAYEASY_RULE_MAX'];
                $listData['st_code'] = $this->const['PAYEASY_ST_CODE'];
                break;
            case $this->const['PAY_ID_WEBMONEY']:
                $listData['rule_max'] = $this->const['WEBMONEY_RULE_MAX'];
                $listData['st_code'] = $this->const['WEBMONEY_ST_CODE'];
                break;
            case $this->const['PAY_ID_YWALLET']:
                $listData['rule_max'] = $this->const['YWALLET_RULE_MAX'];
                $listData['st_code'] = $this->const['YWALLET_ST_CODE'];
                break;
            case $this->const['PAY_ID_PAYPAL']:
                $listData['rule_max'] = $this->const['PAYPAL_RULE_MAX'];
                $listData['st_code'] = $this->const['PAYPAL_ST_CODE'];
                break;
            case $this->const['PAY_ID_BITCASH']:
                $listData['rule_max'] = $this->const['BITCASH_RULE_MAX'];
                $listData['st_code'] = $this->const['BITCASH_ST_CODE'];
                break;
            case $this->const['PAY_ID_CHOCOM']:
                $listData['rule_max'] = $this->const['CHOCOM_RULE_MAX'];
                $listData['st_code'] = $this->const['CHOCOM_ST_CODE'];
                break;
            case $this->const['PAY_ID_SPHONE']:
                $listData['rule_max'] = $this->const['SPHONE_RULE_MAX'];
                $listData['st_code'] = $this->const['SPHONE_ST_CODE'];
                break;
            case $this->const['PAY_ID_JCB']:
                $listData['rule_max'] = $this->const['JCB_RULE_MAX'];
                $listData['st_code'] = $this->const['JCB_ST_CODE'];
                break;
            case $this->const['PAY_ID_SUMISHIN']:
                $listData['rule_max'] = $this->const['SUMISHIN_RULE_MAX'];
                $listData['st_code'] = $this->const['SUMISHIN_ST_CODE'];
                break;
            case $this->const['PAY_ID_DEFERRED']:
                $listData['rule_max'] = $this->const['DEFERRED_RULE_MAX'];
                $listData['st_code'] = $this->const['DEFERRED_ST_CODE'];
                break;
            case $this->const['PAY_ID_VIRTUAL_ACCOUNT']:
                $listData['rule_max'] = $this->const['VIRTUAL_ACCOUNT_RULE_MAX'];
                $listData['st_code'] = $this->const['VIRTUAL_ACCOUNT_ST_CODE'];
                break;
            case $this->const['PAY_ID_PAYPAY']:
                $listData['rule_max'] = $this->const['PAYPAY_RULE_MAX'];
                $listData['st_code'] = $this->const['PAYPAY_ST_CODE'];
                break;
            case $this->const['PAY_ID_MAIL']:
                $listData['rule_max'] = $this->const['MAIL_RULE_MAX'];
                $listData['st_code'] = $this->const['MAIL_ST_CODE'];
                break;
        }

        return $listData;
    }

    /**
     * 定期受注決済情報を取得
     *
     * @param integer $paymentTypeId
     * @return array
     */
    function getRegPaymentConfig($paymentTypeId)
    {
        $listData = array();
        $listData['charge'] = '0';
        $listData['rule_max'] = $this->const['CREDIT_RULE_MAX'];
        $listData['st_code'] = $this->const['CREDIT_ST_CODE'];

        switch ($paymentTypeId) {
            case $this->const['PAY_ID_EVERY_MONTH']:
                $listData['mission_code'] = $this->const['EVERY_MONTH_MISSION_CODE'];
                break;
            case $this->const['PAY_ID_EVERY_OTHER_MONTH']:
                $listData['mission_code'] = $this->const['EVERY_OTHER_MONTH_MISSION_CODE'];
                break;
            case $this->const['PAY_ID_EVERY_THREE_MONTH']:
                $listData['mission_code'] = $this->const['EVERY_THREE_MONTH_MISSION_CODE'];
                break;
            case $this->const['PAY_ID_EVERY_SIX_MONTH']:
                $listData['mission_code'] = $this->const['EVERY_SIX_MONTH_MISSION_CODE'];
                break;
            case $this->const['PAY_ID_EVERY_YEAR']:
                $listData['mission_code'] = $this->const['EVERY_YEAR_MISSION_CODE'];
                break;
        }

        return $listData;
    }


    /**
     * dtb_paymentに決済情報を登録
     *
     * @param integer $paymentTypeId
     * @param array $Payments
     * @param array $arrDefault
     * @return integer
     */
    public function savePayment($paymentTypeId, $Payments, $arrDefault)
    {
        // 決済情報を取得
        $Payment = $this->app['eccube.plugin.epsilon.repository.payment_extension']->getPaymentByType($paymentTypeId, true, $this->app);

        // 取得できない場合は新規作成
        if (is_null($Payment)) {
            $Payment = $this->app['eccube.repository.payment']->findOrCreate(0);
        }

        // 各値を設定
        $Payment->setMethod($Payments[$paymentTypeId]);
        $Payment->setFixFlg(1);
        $Payment->setRuleMin(1);
        $Payment->setCharge($arrDefault['charge']);
        $Payment->setDelFlg(0);
        $Payment->setRuleMax($arrDefault['rule_max']);

        $this->app['orm.em']->persist($Payment);
        $this->app['orm.em']->flush();
        return $Payment->getId();
    }

    /**
     * plg_paylite_payment_extensionに決済情報を登録
     *
     * @param integer $id
     * @param integer $paymentTypeId
     * @param array $Payments
     * @param array $arrDefault
     */
    public function saveExtensionPayment($id, $paymentTypeId, $Payments, $arrDefault)
    {
        $objPlgUtil =& PluginUtil::getInstance($this->app);
        $pluginCode = $objPlgUtil->getCode(true);

        $PaymentExtension = $this->app['eccube.plugin.epsilon.repository.payment_extension']->getPaymentExtension('id', $id, true, $this->app);

        if (is_null($PaymentExtension)) {
            // Create new payment_extension
            $PaymentExtension = $this->app['eccube.plugin.epsilon.repository.payment_extension']->findOrCreate(0);
        }

        $PaymentExtension->setId($id);
        $PaymentExtension->setMethod($Payments[$paymentTypeId]);
        $PaymentExtension->setPaymentTypeId($paymentTypeId);
        $PaymentExtension->setStCode($arrDefault['st_code']);
        if (!empty($arrDefault['mission_code'])) {
            $PaymentExtension->setMissionCode($arrDefault['mission_code']);
        }
        $PaymentExtension->setPluginCode($this->const['PLUGIN_CODE']);

        $this->app['orm.em']->persist($PaymentExtension);
        $this->app['orm.em']->flush();
    }

}
