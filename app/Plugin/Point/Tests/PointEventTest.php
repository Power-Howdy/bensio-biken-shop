<?php

namespace Eccube\Tests;

use Eccube\Application;
use Eccube\Event\EccubeEvents;
use Eccube\Event\EventArgs;
use Eccube\Tests\Web\AbstractWebTestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * PointEvent test cases.
 *
 * カバレッジを出すため、一通りのイベントを実行する
 */
class PointEventTest extends AbstractWebTestCase
{
    protected $Customer;
    protected $Order;
    protected $Product;

    public function setUp()
    {
        parent::setUp();
        $this->app['request'] = new Request();
        $this->app['admin'] = true;
        $this->app['front'] = true;
        $paths = array();
        $paths[] = $this->app['config']['template_default_realdir'];
        $paths[] = __DIR__.'/../../../../app/Plugin';
        $this->app['twig.loader']->addLoader(new \Twig_Loader_Filesystem($paths));

        $this->Customer = $this->createCustomer();
        $this->Order = $this->createOrder($this->Customer);
        $this->Product = $this->createProduct();
        $this->mailBody = "合　計 10000\n";
    }

    public function eventCallable()
    {
        $PointEvent = new PointEventMock($this->app);
        $builder = $this->app['form.factory']->createBuilder();
        $builder
            ->add('plg_point_product_rate', 'integer')
            ->add('plg_point_current', 'integer');
        $MailHistory = new \Eccube\Entity\MailHistory();
        $MailHistory->setSubject('test');
        $MailHistory->setOrder($this->Order);
        $MailHistory->setMailBody($this->mailBody);
        $MailMessage = \Swift_Message::newInstance();
        $MailMessage->setBody($this->mailBody);
        $this->app['orm.em']->persist($MailHistory);
        $this->event = new EventArgs(
            array(
                'builder' => $builder,
                'form' => $builder->getForm(),
                'TargetOrder' => $this->Order,
                'OriginOrder' => $this->Order,
                'Order' => $this->Order,
                'Customer' => $this->Customer,
                'Product' => $this->Product,
                'plg_point_product_rate' => null,
                'MailHistory' => $MailHistory,
                'message' => $MailMessage
            ),
            null
        );
        $this->TemplateEvent = new \Eccube\Event\TemplateEvent(
            'index.twig', null,
            array(
                'Order' => $this->Order,
                'point_use' => 0,
                'body' => $this->mailBody,
                'Product' => $this->Product
            )
        );
        return $PointEvent;
    }
    public function testEvent1()
    {
        $PointEvent = $this->eventCallable();
        $PointEvent->onAdminProductEditInitialize($this->event);
    }
    public function testEvent2()
    {
        $PointEvent = $this->eventCallable();
        $PointEvent->onAdminProductEditComplete($this->event);
    }
    public function testEvent3()
    {
        $PointEvent = $this->eventCallable();
        $PointEvent->onAdminCustomerEditIndexInitialize($this->event);
    }
    public function testEvent4()
    {
        $builder = $this->app['form.factory']->createBuilder('admin_customer', $this->Customer);
        $builder->add('plg_point_current', 'integer');
        $builder->get('plg_point_current')->setData(100);
        $event = new EventArgs(
            array(
                'form' => $builder,
                'Customer' => $this->Customer,
            ),
            null
        );

        $PointEvent = $this->eventCallable();
        $PointEvent->onAdminCustomerEditIndexComplete($event);
    }
    public function testEvent5()
    {
        $PointEvent = $this->eventCallable();
        $PointEvent->onAdminOrderEditIndexInitialize($this->event);
    }
    public function testEvent6()
    {
        $builder = $this->app['form.factory']->createBuilder('order');
        $builder
            ->add('use_point', 'integer')
            ->add('add_point', 'integer');
        $event = new EventArgs(
            array(
                'form' => $builder->getForm(),
                'TargetOrder' => $this->Order,
            ),
            null
        );

        $PointEvent = $this->eventCallable();
        $PointEvent->onAdminOrderEditIndexComplete($event);
    }
    public function testEvent7()
    {
        $PointEvent = $this->eventCallable();
        $PointEvent->onAdminOrderDeleteComplete($this->event);
    }
    public function testEvent8()
    {
        $PointEvent = $this->eventCallable();
        $PointEvent->onAdminOrderMailIndexComplete($this->event);
    }
    public function testEvent9()
    {
        $PointEvent = $this->eventCallable();
        $PointEvent->onFrontShoppingConfirmProcessing($this->event);
    }
    public function testEvent10()
    {
        $PointEvent = $this->eventCallable();
        $PointEvent->onServiceShoppingNotifyComplete($this->event);
    }
    public function testEvent11()
    {
        $PointEvent = $this->eventCallable();
        $PointEvent->onFrontChangeTotal($this->event);
    }
    public function testEvent12()
    {
        $PointEvent = $this->eventCallable();
        $PointEvent->onFrontChangeTotal($this->event);
    }
    public function testEvent13()
    {
        $PointEvent = $this->eventCallable();
        $PointEvent->onFrontChangeTotal($this->event);
    }
    public function testEvent14()
    {
        // XXX Request に依存しているためテストが書けない
        try {
            $PointEvent = $this->eventCallable();
            $PointEvent->onRenderShoppingIndex($this->TemplateEvent);
        } catch (\Exception $e) {
        }
    }
    public function testEvent15()
    {
        $PointEvent = $this->eventCallable();
        $PointEvent->onRenderAdminOrderEdit($this->TemplateEvent);
    }
    public function testEvent16()
    {
        $PointEvent = $this->eventCallable();
        $PointEvent->onRenderMyPageIndex($this->TemplateEvent);
    }
    public function testEvent17()
    {
        $PointEvent = $this->eventCallable();
        $PointEvent->onRenderAdminOrderMailConfirm($this->TemplateEvent);
    }
    public function testEvent18()
    {
        $PointEvent = $this->eventCallable();
        $PointEvent->onMailOrderComplete($this->event);
    }
    public function testEvent19()
    {
        $PointEvent = $this->eventCallable();
        $PointEvent->onRenderProductDetail($this->TemplateEvent);
    }
    public function testEvent20()
    {
        // XXX Request に依存しているためテストが書けない
        try {
            $PointEvent = $this->eventCallable();
            $PointEvent->onRenderCart($this->TemplateEvent);
        } catch (\Exception $e) {
        }
    }
    public function testEvent21()
    {
        $PointEvent = $this->eventCallable();
        $PointEvent->onRenderHistory($this->TemplateEvent);
    }
}

/**
 * テスト用のモック
 */
class PointEventMock extends \Plugin\Point\PointEvent {
    protected function isAuthRouteFront()
    {
        return true;
    }
    protected function replaceView(TemplateEvent $event, $snippet, $search)
    {
        return true;
    }
}
