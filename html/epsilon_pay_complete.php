<?php
/*

 注文完了画面の処理と競合するため、処理を遅らせる

*/

use Plugin\EccubePaymentLite3\Entity\Extension\OrderExtension;

sleep(10);



require __DIR__.'/../autoload.php';


$app = new Eccube\Application();
$app->initialize();
$app->initializePlugin();
$app->boot();


$params = $_POST;
$app['monolog.gmoepsilon']->addInfo('Epsilon_Pay_Complete : start. order_id = ' . $params['order_number']);


// 契約コード取得
// データ送信
$objPlugin =& Plugin\EccubePaymentLite3\Util\PluginUtil::getInstance($app);
$contract_code = $objPlugin->getSubData('contract_code');

$Order = $app['eccube.repository.order']->find($params['order_number']);
$orderStatusId = $Order->getOrderStatus()->getId();


// 正常なパラメータがPostされてきたか判定
if ($contract_code != $params['contract_code'] ||
		empty($params['trans_code']) ||
		empty($Order)||
		empty($params['state'])
) {
	$app['monolog.gmoepsilon']->addError('Epsilon_Pay_Complete : POST param argument ' . print_r($params, true));
	// 異常応答
	echo 0;
} else {
	$PaymentExtension = $app['eccube.plugin.epsilon.repository.payment_extension']->find($Order->getPayment()->getId());
	$paymentTypeId = $PaymentExtension->getPaymentTypeId();

	// 決済パラメータ変更判定
	$updateFlg = false;
	switch ($params['payment_code']) {
		case $app['config']['EccubePaymentLite3']['const']['PAY_ID_CONVENI']:
		case $app['config']['EccubePaymentLite3']['const']['PAY_ID_PAYEASY']:
			// コンビニ・ペイジー
			if ($orderStatusId == $app['config']['order_pay_wait']) {
				$updateFlg = true;
			}
			break;
		default:
			// その他クレジットなど
			if ($paymentTypeId == $app['config']['EccubePaymentLite3']['const']['PAY_ID_MAIL']) {
				if ($orderStatusId == $app['config']['order_new']) {
					$updateFlg = true;
				}
			} else {
				if ($orderStatusId == $app['config']['order_pending']) {
					$updateFlg = true;
				}
			}

			break;
	}

	// 決済パラメータ変更処理
	if ($updateFlg) {
		// GMO後払いの場合は「新規受付」に、その他決済「入金済み」に更新
		if ($params['payment_code'] == $app['config']['EccubePaymentLite3']['const']['PAY_ID_DEFERRED']) {
			$OrderStatus = $app['eccube.repository.order_status']->find($app['config']['order_new']);
		} else {
			$OrderStatus = $app['eccube.repository.order_status']->find($app['config']['order_pre_end']);

		}


		$app['eccube.repository.order']->changeStatus($params['order_number'], $OrderStatus);

		if ($params['payment_code'] !== $app['config']['EccubePaymentLite3']['const']['PAY_ID_CONVENI'] &&
				$params['payment_code'] !== $app['config']['EccubePaymentLite3']['const']['PAY_ID_PAYEASY'] &&
					$paymentTypeId !== $app['config']['EccubePaymentLite3']['const']['PAY_ID_MAIL']) {
			// 在庫情報更新
        	$app['eccube.service.order']->setStockUpdate($app['orm.em'], $Order);

			$Customer = $Order->getCustomer();
			if (!empty($Customer)) {
                // 会員の場合、購入金額を更新
                $app['eccube.service.order']->setCustomerUpdate($app['orm.em'], $Order, $Customer);
            }
		}

		$app['monolog.gmoepsilon']->addInfo('Epsilon_Pay_Complete : status changed order_id=' .
												$params['order_number'] . ' status=' . $OrderStatus);
		// OrderExにレコードがない場合は登録する。
		$OrderExtension = $app['eccube.plugin.epsilon.repository.order_extension']->find($params['order_number']);
		if (empty($OrderExtension)) {
			$OrderExtension = new OrderExtension();
	    	$OrderExtension->setId($Order->getId());
	    	$OrderExtension->setTransCode($params['trans_code']);
	    	$app->persist($OrderExtension);
	    	$app->flush();

			$app['monolog.gmoepsilon']->addInfo('Epsilon_Pay_Complete : create plg_paylite_order_extension order_id='.$params['order_number']);

		}

		// 定期受注の場合は定期受注マスターにもデータを登録する。
		if ($paymentTypeId == $app['config']['EccubePaymentLite3']['const']['PAY_ID_EVERY_MONTH'] ||
				$paymentTypeId == $app['config']['EccubePaymentLite3']['const']['PAY_ID_EVERY_OTHER_MONTH'] ||
				$paymentTypeId == $app['config']['EccubePaymentLite3']['const']['PAY_ID_EVERY_THREE_MONTH'] ||
				$paymentTypeId == $app['config']['EccubePaymentLite3']['const']['PAY_ID_EVERY_SIX_MONTH'] ||
				$paymentTypeId == $app['config']['EccubePaymentLite3']['const']['PAY_ID_EVERY_YEAR']) {
			$RegularOrder = $app['eccube.plugin.epsilon.repository.regular_order']->findBy(array('FirstOrder' => $Order));
			if (empty($RegularOrder)) {
				$app['eccube.plugin.epsilon.service.regular']->copyOrderEachOther($Order, $params);
				// ログメッセージ
				$regularOrder_id = $app['eccube.plugin.epsilon.repository.regular_order']->findBy(array('FirstOrder' => $params['order_number']));
				$app['monolog.gmoepsilon']->addInfo('Epsilon_Pay_Complete : create plg_paylite_regular_order, plg_paylite_regular_order_detail, plg_paylite_regular_shipping, plg_paylite_regular_shipment_item. ' .
						'regular_order_id = ' . $regularOrder_id[0]['id']);
			}
		}
	}
	// 正常応答
    $OrderEx = $app['eccube.plugin.epsilon.repository.order_extension']->getOrderByParams(array(
        'gmo_epsilon_order_no' => $params['order_number'],
        'trans_code' => $params['trans_code'],
    ));
    if (!empty($OrderEx)) {
        // OrderExにレコードがない場合は登録する。
        $OrderExtension = $app['eccube.plugin.epsilon.repository.order_extension']->find($OrderEx->getId());
        if (!empty($OrderExtension)) {
            $PaymentStatus = $app['eccube.plugin.epsilon.repository.payment_status']->find($params['state']);
            $OrderExtension->setPaymentStatus($PaymentStatus);
            $app['orm.em']->persist($OrderExtension);
            $app['orm.em']->flush();
        }
    }
	echo 1;
}
$app['monolog.gmoepsilon']->addInfo('Epsilon_Pay_Complete : end.');
