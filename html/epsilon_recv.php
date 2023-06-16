<?php

require __DIR__.'/../autoload.php';

$app = new Eccube\Application();
$app->initialize();
$app->initializePlugin();
$app->boot();


$app['monolog.gmoepsilon']->addInfo('Epsilon_Notice start.');
$params = $_POST;

// Get order information
$Order = $app['eccube.plugin.epsilon.repository.order_extension']->findBy(array('id' => $params['order_number'], 'trans_code' => $params['trans_code']));

// If order information cannot be obtained
if (is_null($Order)) {
    $app['monolog.gmoepsilon']->addInfo('Notice Error : not found Order "order_id = ' . $params['order_number'] . ' trans_code = ' . $params['trans_code'] . '"');
} else {
    // Convenience store payment/page payment
    if (!empty($params['trans_code']) && $params['paid'] == '1' && !empty($params['order_number'])) {
        $OrderStatus = $app['eccube.repository.order_status']->find($app['config']['order_pre_end']);
        $app['eccube.repository.order']->changeStatus($params['order_number'], $OrderStatus);
        $app['monolog.gmoepsilon']->addInfo('Epsilon_Notice conveni or payeasy pre_end. order_id='.$params['order_number']);

        // 正常応答
        echo '1';
    // GMO payment after delivery
    } else if (!empty($params['trans_code']) && $params['payment_code'] == $app['config']['EccubePaymentLite3']['const']['PAY_ID_DEFERRED'] && !empty($params['order_number'])) {
        switch ($params['state']) {
            // Deposited
            case '1':
                $OrderStatus = $app['eccube.repository.order_status']->find($app['config']['order_pre_end']);
                $app['eccube.repository.order']->changeStatus($params['order_number'], $OrderStatus);
                $app['monolog.gmoepsilon']->addInfo('Epsilon_Notice gmo pre_end. order_id='.$params['order_number']);
                break;
            // cancel
            case '9':
                $OrderStatus = $app['eccube.repository.order_status']->find($app['config']['order_cancel']);
                $app['eccube.repository.order']->changeStatus($params['order_number'], $OrderStatus);
                $app['monolog.gmoepsilon']->addInfo('Epsilon_Notice gmo cancel. order_id='.$params['order_number']);
                break;
        }
        $OrderEx = $app['eccube.plugin.epsilon.repository.order_extension']->getOrderByParams(array(
            'gmo_epsilon_order_no' => $params['order_number'],
            'trans_code' => $params['trans_code'],
        ));
        if (!empty($OrderEx)) {
            // Register if there is no record in OrderEx.
            $OrderExtension = $app['eccube.plugin.epsilon.repository.order_extension']->find($OrderEx->getId());
            if (!empty($OrderExtension)) {
                $PaymentStatus = $app['eccube.plugin.epsilon.repository.payment_status']->find($params['state']);
                $OrderExtension->setPaymentStatus($PaymentStatus);
                $app['orm.em']->persist($OrderExtension);
                $app['orm.em']->flush();
            }
        }
        // normal response
        echo '1';
    } else {
        $app['monolog.gmoepsilon']->addInfo('Epsilon_Notice error. POST = '.print_r($_POST, true));
        // Abnormal response
        echo '0';
    }
}

$app['monolog.gmoepsilon']->addInfo('Epsilon_Notice end.');
