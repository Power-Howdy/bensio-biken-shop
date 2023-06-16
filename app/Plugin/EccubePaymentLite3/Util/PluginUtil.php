<?php

namespace Plugin\EccubePaymentLite3\Util;

use Eccube\Application;
use Plugin\EccubePaymentLite3\Entity\GmoEpsilonPlugin;

/**
 * 決済モジュール基本クラス
 */
class PluginUtil
{

    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /** サブデータを保持する変数 */
    var $subData = null;

    /** モジュール情報 */
    var $pluginInfo = array(
        'pluginName' => 'EC-CUBEペイメントLite3',
        'pluginCode' => 'EccubePaymentLite3',
    );

    /**
     * Enter description here...
     *
     */
    var $updateFile = array();

    /**
     * GmoPaymentGateway:install()を呼んだ際にdtb_moduleのsub_dataカラムへ登録される値
     * シリアライズされて保存される.
     *
     * master_settings => 初期データなど
     * user_settings => 設定情報など、ユーザの入力によるデータ
     */
    var $installSubData = array(
        // 初期データなどを保持する
        'master_settings' => array(),
        // 設定情報など、ユーザの入力によるデータを保持する
        'user_settings' => array(),
    );
    private $pluginCode;


    /**
     * PG_MULPAYのインスタンスを取得する
     *
     * @return PluginUtil
     */
    static function &getInstance($app)
    {
        static $paymentUtil;
        if (empty($paymentUtil)) {
            $paymentUtil = new PluginUtil($app);
        }
        $paymentUtil->init();
        return $paymentUtil;
    }

    /**
     * 初期化処理.
     */
    function init()
    {
        foreach ($this->pluginInfo as $k => $v) {
            $this->$k = $v;
        }

    }

    /**
     * 終了処理.
     */
    function destroy()
    {
    }

    /**
     * モジュール表示用名称を取得する
     *
     * @return string
     */
    function getName()
    {
        return $this->pluginName;
    }

    /**
     * モジュールコードを取得する
     *
     * @param boolean $toLower trueの場合は小文字へ変換する.デフォルトはfalse.
     * @return string
     */
    function getCode($toLower = false)
    {
        $pluginCode = $this->pluginCode;
        return $pluginCode;
    }

    /**
     * サブデータを取得する.
     *
     * @return mixed|null
     */
    function getSubData($key = null)
    {
        // Check & Load subData
        if (empty($this->subData)) {
            $res = $this->app['orm.em']
                ->getRepository('Plugin\EccubePaymentLite3\Entity\GmoEpsilonPlugin')
                ->getSubData('EccubePaymentLite3');

            if (!empty($res)) {
                $this->subData = unserialize($res);
            }
        }

        // Extract value from subData
        if (!empty($this->subData)) {
            if (is_null($key)) {
                return $this->subData;
            }

            $userSettings = !empty($this->subData['user_settings']) ? $this->subData['user_settings'] : array();
            // Load urls from config file
            if (in_array($key, array('destination_url', 'info_conf_url'))) {
                $connectTo = $key == 'destination_url' ? 'receive_order3' : 'getsales';
                return $this->app['eccube.plugin.epsilon.services']->getUrl($connectTo, $userSettings['environmental_setting']);
            }

            return $userSettings[$key];
        }

        return null;
    }

    /**
     *Get Api Url
     *
     * @param string $key
     * @return string
     */
    public function getUrl($key)
    {
        $subData = $this->getSubData();
        $userSettings = !empty($subData['user_settings']) ? $subData['user_settings'] : array();
        $env = !empty($userSettings['environmental_setting']) ? $userSettings['environmental_setting'] : null;

        // convert
        if (in_array($key, array('destination_url', 'info_conf_url'))) {
            $key = $key == 'destination_url' ? 'receive_order3' : 'getsales';
        }

        return $this->app['eccube.plugin.epsilon.services']->getUrl($key, $env);
    }

    /**
     * サブデータをDBへ登録する
     * $keyがnullの時は全データを上書きする
     *
     * @param mixed $data
     * @param string $key
     */
    function registerSubData($data, $key = null)
    {
        $subData = $this->getSubData();

        if (is_null($key)) {
            $subData = $data;
        } else {
            $subData[$key] = $data;
        }
        $subDataSer = serialize($subData);

        $pluginCode = $this->getCode(true);
        $GmoPlugin = $this->app['eccube.plugin.epsilon.repository.epsilon_plugin']->findOneBy(array('code' => $pluginCode));
        if (!is_null($GmoPlugin)) {
            $GmoPlugin->setSubData($subDataSer);
            $this->app['orm.em']->persist($GmoPlugin);
            $this->app['orm.em']->flush();
        }

        $this->subData = $subData;
    }

    function getUserSettings($key = null)
    {
        $subData = $this->getSubData();
        $returnData = null;

        if (is_null($key)) {
            $returnData = isset($subData['user_settings'])
                ? $subData['user_settings']
                : null;
        } else {
            $returnData = isset($subData['user_settings'][$key])
                ? $subData['user_settings'][$key]
                : null;
        }

        return $returnData;
    }

    function registerUserSettings($data)
    {
        $this->registerSubData($data, 'user_settings');
    }

    /**
     * インストール処理
     *
     * @param boolean $force true時、上書き登録を行う
     */
    function install($force = false)
    {
        $subData = $this->getSubData();
        if (is_null($subData) || $force) {
            $this->registerSubdata(
                $this->installSubData['master_settings'],
                'master_settings'
            );
        }
    }

}
