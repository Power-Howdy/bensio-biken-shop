<?php

namespace Plugin\EccubePaymentLite3\Service\Client;

use DateTime;
use Eccube\Application;
use Eccube\Entity\Order;
use Eccube\Entity\OrderDetail;
use Eccube\Entity\Payment;
use Eccube\Entity\Shipping;
use Eccube\Entity\ShipmentItem;
use Plugin\EccubePaymentLite3\Entity\Extension\OrderExtension;
use Plugin\EccubePaymentLite3\Entity\Extension\PaymentExtension;
use Plugin\EccubePaymentLite3\Entity\RegularOrder;
use Plugin\EccubePaymentLite3\Entity\RegularOrderDetail;
use Plugin\EccubePaymentLite3\Entity\RegularShipping;
use Plugin\EccubePaymentLite3\Entity\RegularShipmentItem;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * 決済モジュール 決済処理：定期課金(クレジットカード決済)
 */
class GmoEpsilon_Regular extends GmoEpsilon_Base
{
    private $orderVar = array(
        'PreOrderId', 'Message', 'Name01', 'Name02', 'Kana01', 'Kana02', 'CompanyName', 'Email',
        'Tel01', 'Tel02', 'Tel03', 'Fax01', 'Fax02', 'Fax03', 'Zip01', 'Zip02', 'Zipcode', 'Addr01', 'Addr02',
        'Birth', 'Subtotal', 'Discount', 'DeliveryFeeTotal', 'Charge', 'Tax', 'Total', 'PaymentTotal', 'PaymentMethod',
        'Note', 'OrderDate', 'DelFlg', 'Customer', 'Country',
        'Pref', 'Sex', 'Job', 'Payment', 'DeviceType',
    );

    private $shippingVar = array(
        'Name01', 'Name02', 'Kana01', 'Kana02', 'CompanyName', 'Tel01', 'Tel02', 'Tel03', 'Fax01', 'Fax02', 'Fax03',
        'Zip01', 'Zip02', 'Zipcode', 'Addr01', 'Addr02', 'ShippingDeliveryName', 'ShippingDeliveryTime',
        'ShippingDeliveryDate', 'ShippingDeliveryFee', 'Rank', 'CreateDate', 'UpdateDate',
        'DelFlg', 'Country', 'Pref', 'Delivery', 'DeliveryTime', 'DeliveryFee',
    );

    private $orderDetailVar = array(
        'ProductName', 'ProductCode', 'ClassCategoryName1', 'ClassCategoryName2', 'Price', 'Quantity',
        'TaxRate', 'TaxRule', 'Product', 'ProductClass',
    );

    private $shipmentItemVar = array(
        'ProductName', 'ProductCode', 'ClassCategoryName1', 'ClassCategoryName2', 'Price', 'Quantity',
        'Product', 'ProductClass',
    );
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
     * 受注情報を更新、定期受注マスタを登録
     *
     * @param Order $Order
     * @param array $response
     */
    function updateOrder($Order, $response)
    {
        // 受注情報を更新
        parent::updateOrder($Order, $response);

        // 定期受注マスタが未登録の場合 ※決済完了通知と2重に作成しないため
        $RegularOrder = $this->app['eccube.plugin.epsilon.repository.regular_order']->findBy(array('FirstOrder' => $response['order_number']));
        if (empty($RegularOrder)) {
            // 定期受注マスタを登録
            $this->copyOrderEachOther($Order, $response);
        }
    }

    function copyOrderEachOther($SourceOrder, array $other = null)
    {
        $this->app['orm.em']->getConnection()->beginTransaction();

        if (strpos(get_class($SourceOrder),'RegularOrder') !== false) {
            $source_prefix = 'Regular';
            $destination_prefix = '';
        } else {
            $source_prefix = '';
            $destination_prefix = 'Regular';
        }
        /**
         * 定期受注マスタを登録、以下の様に受注情報をコピー
         *
         * dtb_order → plg_paylite_regular_order
         * dtb_order_detail → plg_paylite_regular_order_detail
         * dtb_shipping → plg_paylite_regular_shipping
         * dtb_shipment_item → plg_paylite_regular_shipment_item
         */
        // order
        $DestinationOrder = empty($destination_prefix) ? new Order() : new RegularOrder();
        $this->copyRecord($DestinationOrder, $SourceOrder, $this->orderVar);
        if (strpos(get_class($DestinationOrder), 'RegularOrder') !== false) {
            $DestinationOrder->setTransCode($other['trans_code']);
            $DestinationOrder->setRegularOrderCount(1);
            $DestinationOrder->setRegularStatus($this->app['eccube.plugin.epsilon.repository.regular_status']->find(1));
            $DestinationOrder->setFirstOrder($SourceOrder);
            $DestinationOrder->setLastOrder($SourceOrder);
        } else {
            $DestinationOrder->setOrderStatus($this->app['eccube.repository.order_status']->find($this->app['config']['order_new']));
        }
        $this->app['orm.em']->persist($DestinationOrder);

        // order_detail
        $getter = 'get' . $source_prefix . 'OrderDetails';
        $SourceOrderDetails = $SourceOrder->$getter();
        foreach ($SourceOrderDetails as $SourceOrderDetail) {
            $DestinationOrderDetail = empty($destination_prefix) ? new OrderDetail() : new RegularOrderDetail();
            $this->copyRecord($DestinationOrderDetail, $SourceOrderDetail, $this->orderDetailVar);
            $setter = 'set' . $destination_prefix . 'Order';
            $DestinationOrderDetail->$setter($DestinationOrder);
            $this->app['orm.em']->persist($DestinationOrderDetail);

            $add = 'add' . $destination_prefix . 'OrderDetail';
            $DestinationOrder->$add($DestinationOrderDetail);
        }

        // shipping
        $getter = 'get' . $source_prefix . 'Shippings';
        $SourceShippings = $SourceOrder->$getter();
        foreach ($SourceShippings as $SourceShipping) {
            $DestinationShipping = empty($destination_prefix) ? new Shipping() : new RegularShipping();
            $this->copyRecord($DestinationShipping, $SourceShipping, $this->shippingVar);
            $setter = 'set' . $destination_prefix . 'Order';
            $DestinationShipping->$setter($DestinationOrder);
            // shipment_item
            $getter = 'get' . $source_prefix . 'ShipmentItems';
            $SourceShipmentItems = $SourceShipping->$getter();
            foreach ($SourceShipmentItems as $SourceShipmentItem) {
                $DestinationShipmentItem = empty($destination_prefix) ? new ShipmentItem() : new RegularShipmentItem();
                $this->copyRecord($DestinationShipmentItem, $SourceShipmentItem, $this->shipmentItemVar);
                $setter = 'set' . $destination_prefix . 'Shipping';
                $DestinationShipmentItem->$setter($DestinationShipping);
                $setter = 'set' . $destination_prefix . 'Order';
                $DestinationShipmentItem->$setter($DestinationOrder);
                $this->app['orm.em']->persist($DestinationShipmentItem);

                $add = 'add' . $destination_prefix . 'ShipmentItem';
                $DestinationShipping->$add($DestinationShipmentItem);
        }
            $this->app['orm.em']->persist($DestinationShipping);

            $add = 'add' . $destination_prefix . 'Shipping';
            $DestinationOrder->$add($DestinationShipping);
        }

        $this->app['orm.em']->flush();

        // order_extension
        if (strpos(get_class($DestinationOrder), 'RegularOrder') !== false) {
            // 拡張テーブルに定期受注番号を登録
            $OrderExtension = $this->app['eccube.plugin.epsilon.repository.order_extension']->find($SourceOrder->getId());
            $OrderExtension->setRegularOrderId($DestinationOrder->getId());
        } else {
            // 拡張テーブルに定期情報を登録
            $OrderExtension = new OrderExtension();
            $OrderExtension->setId($DestinationOrder->getId());
            $OrderExtension->setTransCode($SourceOrder->getTransCode());
            $OrderExtension->setRegularOrderId($SourceOrder->getId());

            $SourceOrder->setRegularOrderCount($SourceOrder->getRegularOrderCount() + 1);
            $SourceOrder->setLastOrder($DestinationOrder);

            $this->app['orm.em']->persist($SourceOrder);
            $this->app['orm.em']->flush();
        }

        $this->app['orm.em']->persist($OrderExtension);
        $this->app['orm.em']->flush();

        $this->app['orm.em']->getConnection()->commit();
    }

    public function copyRecord(&$Destination, $Source, $commonVar)
    {
        foreach ($commonVar as $var) {
            $setFunc = 'set'.$var;
            $getFunc = 'get'.$var;
            $Destination->$setFunc($Source->$getFunc());
        }
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
     * 定期受注マスタを基に受注を登録
     *
     * @param $regularOrderId
     */
    public function registOrder($regularOrderId)
    {
        // 定期受注マスタを取得
        $RegularOrder = $this->app['eccube.plugin.epsilon.repository.regular_order']->find($regularOrderId);
        // 受注を登録
        $this->copyOrderEachOther($RegularOrder);
        }


    /**
     * 次回受注作成日を取得
     *
     * @param Payment $Payment
     * @param DateTime $CreateDate
     * @return string|null
     */
    public function getNextOrderDate($Payment, $CreateDate)
    {
        $result = null;
        // 今日の日付けを設定
        $Date = new DateTime();

        $PaymentExtension = $this->app['eccube.plugin.epsilon.repository.payment_extension']->find($Payment->getId());

        // 最後の受注IDの作成日を取得する
        switch ($PaymentExtension->getMissionCode()){
            //  毎月
            case $this->const['EVERY_MONTH_MISSION_CODE']:
                $Interval = new \DateInterval('P1M');
                break;
            //  隔月
            case $this->const['EVERY_OTHER_MONTH_MISSION_CODE']:
                $Interval = new \DateInterval('P2M');
                break;
            //  3ヶ月毎
            case $this->const['EVERY_THREE_MONTH_MISSION_CODE']:
                $Interval = new \DateInterval('P3M');
                break;
            //  半年毎
            case $this->const['EVERY_SIX_MONTH_MISSION_CODE']:
                $Interval = new \DateInterval('P6M');
                break;
            // 毎年
            case $this->const['EVERY_YEAR_MISSION_CODE']:
                $Interval = new \DateInterval('P1Y');
                break;
        }

        $CreateDate->add($Interval);

        // 次回注文月を「年/月/日」の形で設定する
        if ($Date <= $CreateDate){
            $result = $CreateDate->format('Y/m/d');
        }

        return $result;
    }

    /**
     * リクエストパラメータを設定
     *
     * @param Order $Order
     * @param PaymentExtension
     * @return array
     */
    function setParameter($Order, $PaymentExtension)
    {
        // 共通のリクエストパラメータを取得
        $arrParameter = parent::setParameter($Order, $PaymentExtension);
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
        $arrParameter = array_merge($arrParameter, $arr3DS2Parameter);

        $this->app['monolog.gmoepsilon']->addInfo(' Sent Regular arr3DS2Parameter = ' . print_r($arrParameter, true));

        return $arrParameter;
    }
}
