<?php

namespace Plugin\EccubePaymentLite3\Controller\PaymentNotification;

use Eccube\Application;
use Eccube\Entity\Order;
use Plugin\EccubePaymentLite3\Entity\Extension\OrderExtension;
use Plugin\EccubePaymentLite3\Entity\Master\PaymentStatus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DeferredPaymentStatusChangeNotificationController
{
    /**
     * @param Application $app
     * @param Request $request
     * @return Response
     */
    public function index(Application $app, Request $request)
    {
        $app['monolog.gmoepsilon']->addInfo('後払い決済ステータス変更通知送信先: 開始');
        $app['monolog.gmoepsilon']->addInfo('order_number: '.$request->get('order_number'));
        $app['monolog.gmoepsilon']->addInfo('trans_code: '.$request->get('trans_code'));
        $app['monolog.gmoepsilon']->addInfo('state: '.$request->get('state'));

        /** @var Order $Order */
        $Order = $app['eccube.plugin.epsilon.repository.order_extension']->getOrderByParams(array(
            'gmo_epsilon_order_no' => $request->get('order_number'),
            'trans_code' => $request->get('trans_code'),
            'payment_method' => 'GMO後払い',
        ));
        if (!$Order) {
            $app['monolog.gmoepsilon']->addError('後払い決済ステータス変更通知送信先: 対象の受注が見つかりません。');
            return new Response(0);
        }

        /** @var OrderExtension $OrderExtension */
        $OrderExtension = $app['eccube.plugin.epsilon.repository.order_extension']->find($Order->getId());
        // OrderExtensionがnullの場合処理を行わない
        if (is_null($OrderExtension)) {
            $app['monolog.gmoepsilon']->addInfo('OrderExtensionがnullの場合処理を行わない');
            return new Response(1);
        }

        /** @var PaymentStatus $PaymentStatus */
        $PaymentStatus = $app['eccube.plugin.epsilon.repository.payment_status']->find($request->get('state'));
        $OrderExtension->setPaymentStatus($PaymentStatus);

        $app['orm.em']->persist($OrderExtension);
        $app['orm.em']->flush();

        $app['monolog.gmoepsilon']->addInfo('後払い決済ステータス変更通知: 正常終了');
        return new Response(1);
    }
}
