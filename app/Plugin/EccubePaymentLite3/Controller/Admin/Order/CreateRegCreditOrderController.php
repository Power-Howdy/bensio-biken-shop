<?php

namespace Plugin\EccubePaymentLite3\Controller\Admin\Order;

use Eccube\Application;
use Eccube\Controller\AbstractController;
use Eccube\Entity\Order;
use Plugin\EccubePaymentLite3\Entity\Extension\OrderExtension;
use Symfony\Component\HttpFoundation\Response;

class CreateRegCreditOrderController extends AbstractController
{
    /**
     * @param Application $app
     * @param int $id
     * @return Response
     */
    public function index(Application $app, $id)
    {
        /** @var Order $Order */
        $Order = $app['eccube.repository.order']->find($id);
        $Customer = $Order->getCustomer();

        if (is_null($Customer)) {
            $app->addError('非会員の受注は、イプシロン決済登録が出来ません。', 'admin');
            return $app->redirect($app->url('admin_order_edit', array('id' => $Order->getId())));
        }

        if ($Order->getPaymentMethod() !== $app['config']['EccubePaymentLite3']['const']['PAY_NAME_REG_CREDIT']) {
            $app->addError($app['config']['EccubePaymentLite3']['const']['PAY_NAME_REG_CREDIT'] . '以外の受注は、イプシロン決済登録が出来ません。', 'admin');
            return $app->redirect($app->url('admin_order_edit', array('id' => $Order->getId())));
        }

        /** @var OrderExtension $OrderExtension */
        $OrderExtension = $app['eccube.plugin.epsilon.repository.order_extension']->find($Order->getId());
        $gmo_epsilon_order_no = $OrderExtension ? $OrderExtension->getGmoEpsilonOrderNo() : null;
        $getSales = $app['eccube.plugin.epsilon.service.request.get_sales']->handle(null, $gmo_epsilon_order_no);

        // gmo_epsilon_order_noが未登録または、gmo_epsilon_order_noに紐づく決済情報が無い場合
        if (is_null($gmo_epsilon_order_no) || $getSales['order_number'] !== 0) {
            $result = $app['eccube.plugin.epsilon.service.request.receive_order']->handle($Customer, 2, 'paylite_create_reg_credit_order', $Order);

            if ($result['status'] === 'NG') {
                $app->addError($result['message'], 'admin');
                return $app->redirect($app->url('admin_order_edit', array('id' => $Order->getId())));
            }

            return $app->redirect($result['url']);
        }

        // 決済登録済みの場合
        $app->addWarning('すでにイプシロン決済サービスに決済情報を登録済みです。', 'admin');

        return $app->redirect($app->url('admin_order_edit', array('id' => $Order->getId())));
    }
}
