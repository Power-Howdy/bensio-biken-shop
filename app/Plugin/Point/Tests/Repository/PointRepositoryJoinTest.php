<?php

namespace Eccube\Tests\Repository;

use Eccube\Application;
use Eccube\Entity\Customer;
use Eccube\Entity\Master\OrderStatus;
use Eccube\Entity\Order;
use Eccube\Event\EccubeEvents;
use Eccube\Event\EventArgs;
use Eccube\Tests\EccubeTestCase;
use Eccube\Tests\Web\AbstractWebTestCase;
use Eccube\Tests\Web\Admin\AbstractAdminWebTestCase;
use Plugin\Point\Entity\PointInfo;
use Plugin\Point\Entity\PointStatus;
use Plugin\Point\Helper\PointCalculateHelper\PointCalculateHelper;
use Symfony\Component\Form\Form;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Class PointRepositoryScenarioTest
 *
 * @package Eccube\Tests\Repository
 */
class PointRepositoryJoinTest extends AbstractWebTestCase
{
    /**
     * @var int テストでの確定ステータス
     */
    private $pointFixStatus;

    public function setUp()
    {
        parent::setUp();
        $this->pointFixStatus  = (int)$this->app['config']['order_pre_end'];
    }

    // 購入（すぐに確定ポイント）
    public function testShoppingCompleteWithPointFix()
    {
        // ポイント設定を変更
        $this->updatePointSettings($this->app['config']['order_new']);

        // 注文する
        $customer = $this->createCustomer();
        $order = $this->DoOrder($customer);

        // 期待結果の計算
        $expectedPoint = $this->CalcExpectedPoint($order);

        // 検証
        $this->assertEquals($expectedPoint, $this->getCurrentPoint($customer));
        $this->assertEquals(0, $this->getProvisionalPoint($customer));
    }

    // 購入（仮ポイント）
    public function testShoppingCompleteWithoutPointFix()
    {
        // ポイント設定を変更
        $this->updatePointSettings($this->pointFixStatus);

        // 注文する
        $customer = $this->createCustomer();
        $order = $this->DoOrder($customer);

        // 期待結果の計算
        $expectedPoint = $this->CalcExpectedPoint($order);

        // 検証
        $this->assertEquals(0, $this->getCurrentPoint($customer));
        $this->assertEquals($expectedPoint, $this->getProvisionalPoint($customer));
    }

    // 受注変更（確定ステータスへの変更）
    public function testEditOrderToFixedStatus()
    {
        // ポイント設定を変更
        $this->updatePointSettings($this->pointFixStatus);

        // 注文する
        $customer = $this->createCustomer();
        $order = $this->DoOrder($customer);

        // 期待結果の計算
        $expectedPoint = $this->CalcExpectedPoint($order);

        // 検証（仮ポイントであること）
        $this->assertEquals(0, $this->getCurrentPoint($customer));
        $this->assertEquals($expectedPoint, $this->getProvisionalPoint($customer));

        // ポイント確定する
        $this->ChangeOrderToFixStatus($this->pointFixStatus, $order, $customer);

        // 検証（確定していること）
        $this->assertEquals($expectedPoint, $this->getCurrentPoint($customer));
        $this->assertEquals(0, $this->getProvisionalPoint($customer));
    }

    // 受注変更（未確定ステータスへの変更）
    public function testEditOrderToUnfixedStatus()
    {
        // ポイント設定を変更
        $this->updatePointSettings($this->pointFixStatus);

        // 注文する
        $customer = $this->createCustomer();
        $order = $this->DoOrder($customer);

        // 期待結果の計算
        $expectedPoint = $this->CalcExpectedPoint($order);

        // 検証（仮ポイントであること）
        $this->assertEquals(0, $this->getCurrentPoint($customer));
        $this->assertEquals($expectedPoint, $this->getProvisionalPoint($customer));

        // ポイント確定する
        $unfixedStatus = (int)$this->app['config']['order_processing'];
        $this->ChangeOrderToFixStatus($unfixedStatus, $order, $customer);

        // 検証（仮ポイントのままであること）
        $this->assertEquals(0, $this->getCurrentPoint($customer));
        $this->assertEquals($expectedPoint, $this->getProvisionalPoint($customer));
    }

    // 受注削除（確定ポイントを削除）
    public function testDeleteOrderWithFixedPoint()
    {
        // ポイント設定を変更
        $this->updatePointSettings($this->app['config']['order_new']);

        // 注文する
        $customer = $this->createCustomer();
        $order = $this->DoOrder($customer);

        // 期待結果の計算
        $expectedPoint = $this->CalcExpectedPoint($order);

        // 検証（確定ポイントであること）
        $this->assertEquals($expectedPoint, $this->getCurrentPoint($customer));
        $this->assertEquals(0, $this->getProvisionalPoint($customer));

        // 受注の削除
        $this->deleteOrder($order);

        // 検証（ポイント無くなっていること）
        $this->assertEquals(0, $this->getCurrentPoint($customer));
        $this->assertEquals(0, $this->getProvisionalPoint($customer));
    }

    // 受注削除（仮ポイントを削除）
    public function testDeleteOrderWithUnfixedPoint()
    {
        // ポイント設定を変更
        $this->updatePointSettings($this->pointFixStatus);

        // 注文する
        $customer = $this->createCustomer();
        $order = $this->DoOrder($customer);

        // 期待結果の計算
        $expectedPoint = $this->CalcExpectedPoint($order);

        // 検証（仮ポイントであること）
        $this->assertEquals(0, $this->getCurrentPoint($customer));
        $this->assertEquals($expectedPoint, $this->getProvisionalPoint($customer));

        // 受注の削除
        $this->deleteOrder($order);

        // 検証（ポイント無くなっていること）
        $this->assertEquals(0, $this->getCurrentPoint($customer));
        $this->assertEquals(0, $this->getProvisionalPoint($customer));
    }

    // 受注登録で受注作成
    public function testCreateOrderByOrderEditWithFixedStatus()
    {
        // ポイント設定を変更
        $this->updatePointSettings($this->app['config']['order_new']);
        
        // 受注情報を登録する
        $customer = $this->createCustomer();
        $order = $this->DoCreateNewOrder($customer);
        //$order = $this->DoOrder($customer);

        // 検証（ポイントステータスのレコードが作成されていること）
        // https://github.com/EC-CUBE/point-plugin/issues/44
        $existedStatus = $this->app['eccube.plugin.point.repository.pointstatus']->findOneBy(
            array('order_id' => $order->getId())
        );
        $this->assertEquals(1, $existedStatus->getStatus());
        $this->assertNotEmpty($existedStatus);
    }

    // 受注登録で受注作成（未確定ステータス）
    public function testCreateOrderByOrderEditWithUnfixedStatus()
    {
        // ポイント設定を変更
        $this->updatePointSettings($this->pointFixStatus);

        // 受注情報を登録する
        $customer = $this->createCustomer();
        $order = $this->DoCreateNewOrder($customer);

        // 検証（ポイントステータスのレコードが作成されていること）
        // https://github.com/EC-CUBE/point-plugin/issues/44
        $existedStatus = $this->app['eccube.plugin.point.repository.pointstatus']->findOneBy(
            array('order_id' => $order->getId())
        );
        $this->assertEquals(0, $existedStatus->getStatus());
        $this->assertNotEmpty($existedStatus);
    }

    /**
     * オーダーから加算ポイントを取得する
     * @param Order $order
     * @return int
     */
    private function CalcExpectedPoint($order)
    {
        /** @var PointCalculateHelper $calculator */
        $calculator = $this->app['eccube.plugin.point.calculate.helper.factory'];
        $calculator->addEntity('Order', $order);
        $expectedPoint = $calculator->getAddPointByOrder();

        return $expectedPoint;
    }

    /**
     * 仮ポイントの取得
     * @return int
     */
    private function getProvisionalPoint($customer)
    {
        /** @var PointCalculateHelper $calculator */
        $calculator = $this->app['eccube.plugin.point.calculate.helper.factory'];
        $calculator->addEntity('Customer', $customer);
        return $calculator->getProvisionalAddPoint();
    }

    /**
     * 確定ポイントの取得
     * @param Customer $customer
     * @return int
     */
    private function getCurrentPoint($customer)
    {
        $orderIds = $this->app['eccube.plugin.point.repository.pointstatus']->selectOrderIdsWithFixedByCustomer(
            $customer->getId()
        );
        $currentPoint = $this->app['eccube.plugin.point.repository.point']->calcCurrentPoint(
            $customer->getId(),
            $orderIds
        );
        return $currentPoint;
    }

    /**
     * ポイント設定の更新
     * @param int $status
     * @return PointInfo
     */
    private function updatePointSettings($status){
        $PointInfo = new PointInfo();
        $PointInfo
            ->setPlgAddPointStatus($status)
            ->setPlgBasicPointRate(1)
            ->setPlgCalculationType(1)
            ->setPlgPointConversionRate(1)
            ->setPlgRoundType(1);

        $this->app['orm.em']->persist($PointInfo);
        $this->app['orm.em']->flush();

        return $PointInfo;
    }

    /**
     * 注文をする
     * @return Order
     */
    private function DoOrder($customer)
    {
        $order = $this->createOrder($customer);

        // ログイン
        $this->logIn($customer);
        // 受注
        $event = new EventArgs(
            array(
                'Order' => $order,
            ),
            null
        );
        $this->app['eccube.event.dispatcher']->dispatch(EccubeEvents::SERVICE_SHOPPING_NOTIFY_COMPLETE, $event);

        return $order;
    }

    /**
     * 受注を受注登録から作成する
     * @return Order
     */
    private function DoCreateNewOrder($customer)
    {
        $order = $this->createOrder($customer);
        $order->getOrderStatus()->setId($this->app['config']['order_new']);

        // ログイン
        $this->logInAsAdmin($customer);

        // 初期化イベント
        $builder = $this->app['form.factory']->createBuilder('order', $order);
        $this->app['request'] = new Request();
        $event = new EventArgs(
            array(
                'builder' => $builder,
                'TargetOrder' => $order,
                'OriginOrder' => $order,
            ),
            null
        );
        $this->app['eccube.event.dispatcher']->dispatch(EccubeEvents::ADMIN_ORDER_EDIT_INDEX_INITIALIZE, $event);

        // 反映イベント
        $event = new EventArgs(
            array(
                'form' => $builder->getForm(),
                'TargetOrder' => $order,
                'Customer' => $customer,
            ),
            null
        );
        $this->app['eccube.event.dispatcher']->dispatch(EccubeEvents::ADMIN_ORDER_EDIT_INDEX_COMPLETE, $event);

        return $order;
    }

    /**
     * 受注をステータスを切り替える
     * @param int $status
     * @param Order $order
     * @param Customer $customer
     */
    private function ChangeOrderToFixStatus($status, $order, $customer)
    {
        // 初期化イベント
        $builder = $this->app['form.factory']->createBuilder('order', $order);
        $this->app['request'] = new Request();
        $event = new EventArgs(
            array(
                'builder' => $builder,
                'OriginOrder' => $order,
                'TargetOrder' => $order,
            ),
            null
        );
        $this->app['eccube.event.dispatcher']->dispatch(EccubeEvents::ADMIN_ORDER_EDIT_INDEX_INITIALIZE, $event);

        // ステータス変更
        $orderStatus = $this->app['eccube.repository.order_status']->find($status);
        $order->setOrderStatus($orderStatus);

        // 反映イベント
        $event = new EventArgs(
            array(
                'form' => $builder->getForm(),
                'OriginOrder' => $order,
                'TargetOrder' => $order,
                'Customer' => $customer,
            ),
            null
        );
        $this->app['eccube.event.dispatcher']->dispatch(EccubeEvents::ADMIN_ORDER_EDIT_INDEX_COMPLETE, $event);
    }

    /**
     * 受注を削除する
     * @param Order $order
     */
    private function deleteOrder($order)
    {
        $this->logInAsAdmin();
        $this->client->request(
            'DELETE',
            $this->app->path('admin_order_delete', array('id' => $order->getId()))
        );
    }

    /**
     * 管理者としてログインする
     * @param null $user
     * @return null
     */
    private function logInAsAdmin($user = null)
    {
        $firewall = 'admin';

        if (!is_object($user)) {
            $user = $this->app['eccube.repository.member']
                ->findOneBy(array(
                    'login_id' => 'admin',
                ));
        }

        $token = new UsernamePasswordToken($user, null, $firewall, array('ROLE_ADMIN'));

        $this->app['session']->set('_security_' . $firewall, serialize($token));
        $this->app['session']->save();

        $cookie = new Cookie($this->app['session']->getName(), $this->app['session']->getId());
        $this->client->getCookieJar()->set($cookie);
        return $user;
    }



}
