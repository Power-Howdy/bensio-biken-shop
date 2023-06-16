<?php

namespace Plugin\EccubePaymentLite3\Service;

use Eccube\Entity\Order;
use Eccube\Entity\OrderDetail;
use Eccube\Entity\Product;
use Plugin\EccubePaymentLite3\Entity\GmoEpsilonPlugin;
use Eccube\Application;
use Plugin\EccubePaymentLite3\Util\PluginUtil;

class GmoEpsilonService
{
    /**
     * @var Application
     */
    public $app;

    /**
     * @var array
     */
    public $const;

    /**
     * constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->const = $app['config']['EccubePaymentLite3']['const'];
    }

    /**
     *Get Api Url
     *
     * @param string $connectTo
     * @param int $env
     * @return string
     */
    public function getUrl($connectTo, $env = null)
    {
        $env = $env ? $env : $this->getEnv();
        $key = $env == GmoEpsilonPlugin::ENVIRONMENTAL_SETTING_PRODUCTION ? 'prod' : 'dev';

        return $this->const['URL'][strtoupper($key)][strtoupper($connectTo)];
    }

    /**
     * Get Environment
     * Values:
     *  - 1: ENVIRONMENTAL_SETTING_DEVELOPMENT
     *  - 2: ENVIRONMENTAL_SETTING_PRODUCTION
     *
     * @return int|null
     */
    public function getEnv()
    {
        $objPlugin =& PluginUtil::getInstance($this->app);
        $subData = $objPlugin->getSubData();
        $userSettings = !empty($subData['user_settings']) ? $subData['user_settings'] : array();

        return !empty($userSettings['environmental_setting']) ? $userSettings['environmental_setting'] : null;
    }

    /**
     * 受注から代表商品情報を取得
     *
     * @param Order $Order
     * @return array
     */
    public function getProductInfo($Order)
    {
        /** @var OrderDetail $item */
        foreach ($Order->getOrderDetails() as $item) {
            if (!$item->getProduct() instanceof Product) {
                continue;
            }

            $item_code = $item->getProductCode();
            // 空の場合は仮の値をセット
            if (empty($item_code)) {
                $item_code = 'no_code';
            } else {
                /**
                 * 商品コードを整形
                 * 1. 全角→半角
                 * 2. 許容されない文字を削除
                 * 3. 64byteに丸め
                 */
                $item_code = mb_convert_kana($item_code, 'kvrn');
                $item_code = preg_replace('/[^a-zA-Z0-9\.\-\+\/]/', '', $item_code);
                if (64 < strlen($item_code)) {
                    $item_code = mb_strimwidth($item_code, 0, 64);
                }
            }

            $itemInfo = array();
            $itemInfo['item_code'] = $item_code;
            $itemInfo['item_name'] = $item->getProductName().'x'.$item->getQuantity().'個（代表）';

            return $itemInfo;
        }

        return array();
    }
}
