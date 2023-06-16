<?php

namespace Plugin\EccubePaymentLite3\ServiceProvider;

use Eccube\Common\Constant;
use Eccube\Service\TaxRuleService;
use Monolog\Handler\FingersCrossed\ErrorLevelActivationStrategy;
use Monolog\Handler\FingersCrossedHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Plugin\EccubePaymentLite3\Command\CreditCardExpirationNoticeBatchCommand;
use Plugin\EccubePaymentLite3\Doctrine\EventSubscriber\TaxRuleEventSubscriber;
use Plugin\EccubePaymentLite3\Form\Extension\Admin\DeliveryCompanyTypeExtension;
use Plugin\EccubePaymentLite3\Form\Extension\Admin\PaymentStatusTypeExtension;
use Plugin\EccubePaymentLite3\Form\Extension\Admin\ProductTypeExtension;
use Plugin\EccubePaymentLite3\Form\Extension\Admin\TrackingNumberTypeExtension;
use Plugin\EccubePaymentLite3\Form\Type\Admin\RegularOrderType;
use Plugin\EccubePaymentLite3\Form\Type\Admin\RegularSearchOrderType;
use Plugin\EccubePaymentLite3\Form\Type\Admin\RegularShipmentItemType;
use Plugin\EccubePaymentLite3\Form\Type\Admin\RegularShippingType;
use Plugin\EccubePaymentLite3\Form\Type\Admin\SearchRegularProductType;
use Plugin\EccubePaymentLite3\Form\Type\ConvenienceType;
use Plugin\EccubePaymentLite3\Form\Type\CreditCardForTokenPaymentType;
use Plugin\EccubePaymentLite3\Form\Type\Master\RegularStatusType;
use Plugin\EccubePaymentLite3\Form\Type\OrderType;
use Plugin\EccubePaymentLite3\Service\Action\UpdateGmoEpsilonOrder;
use Plugin\EccubePaymentLite3\Service\Action\UpdatePaymentStatus;
use Plugin\EccubePaymentLite3\Service\ChangeCardNotificationMailService;
use Plugin\EccubePaymentLite3\Service\Client\GmoEpsilon_Base;
use Plugin\EccubePaymentLite3\Service\Client\GmoEpsilon_Bitcash;
use Plugin\EccubePaymentLite3\Service\Client\GmoEpsilon_Chocom;
use Plugin\EccubePaymentLite3\Service\Client\GmoEpsilon_Convenience;
use Plugin\EccubePaymentLite3\Service\Client\GmoEpsilon_Credit;
use Plugin\EccubePaymentLite3\Service\Client\GmoEpsilon_Deferred;
use Plugin\EccubePaymentLite3\Service\Client\GmoEpsilon_Jcb;
use Plugin\EccubePaymentLite3\Service\Client\GmoEpsilon_Maillink;
use Plugin\EccubePaymentLite3\Service\Client\GmoEpsilon_Netbank_Jnb;
use Plugin\EccubePaymentLite3\Service\Client\GmoEpsilon_Netbank_Rakuten;
use Plugin\EccubePaymentLite3\Service\Client\GmoEpsilon_Payeasy;
use Plugin\EccubePaymentLite3\Service\Client\GmoEpsilon_Paypal;
use Plugin\EccubePaymentLite3\Service\Client\GmoEpsilon_PayPay;
use Plugin\EccubePaymentLite3\Service\Client\GmoEpsilon_Reg_Credit;
use Plugin\EccubePaymentLite3\Service\Client\GmoEpsilon_Regular;
use Plugin\EccubePaymentLite3\Service\Client\GmoEpsilon_Sphone;
use Plugin\EccubePaymentLite3\Service\Client\GmoEpsilon_Sumishin;
use Plugin\EccubePaymentLite3\Service\Client\GmoEpsilon_Virtual_Account;
use Plugin\EccubePaymentLite3\Service\Client\GmoEpsilon_Webmoney;
use Plugin\EccubePaymentLite3\Service\Client\GmoEpsilon_Ywallet;
use Plugin\EccubePaymentLite3\Service\GetCardExpireDateTimeService;
use Plugin\EccubePaymentLite3\Service\GetCustomerForSendChangeCardMailService;
use Plugin\EccubePaymentLite3\Service\GmoEpsilon_MailService;
use Plugin\EccubePaymentLite3\Service\GmoEpsilonRequestService;
use Plugin\EccubePaymentLite3\Service\GmoEpsilonService;
use Plugin\EccubePaymentLite3\Service\IpBlackListService;
use Plugin\EccubePaymentLite3\Service\Request\CancelPaymentService;
use Plugin\EccubePaymentLite3\Service\Request\ChangePaymentAmountService;
use Plugin\EccubePaymentLite3\Service\Request\GetSales2Service;
use Plugin\EccubePaymentLite3\Service\Request\GetUserInfoService;
use Plugin\EccubePaymentLite3\Service\Request\ReceiveOrderService;
use Plugin\EccubePaymentLite3\Service\Request\SalesPaymentService;
use Plugin\EccubePaymentLite3\Service\Request\ShippingRegistrationService;
use Silex\Application as BaseApplication;
use Silex\ServiceProviderInterface;

class GmoEpsilonServiceProvider implements ServiceProviderInterface
{

    public function register(BaseApplication $app) {
        // Setting
        $app->match('/' . $app["config"]["admin_route"] . '/plugin/EccubePaymentLite3/config', '\\Plugin\\EccubePaymentLite3\\Controller\\ConfigController::index')->bind('plugin_EccubePaymentLite3_config');

        // Epsilon payment
        $app->match('/shopping/epsilon_payment', '\\Plugin\\EccubePaymentLite3\\Controller\\PaymentController::index')->bind('paylite_shopping_payment');
        $app->match('/shopping/epsilon_payment/back', '\\Plugin\\EccubePaymentLite3\\Controller\\PaymentController::back')->bind('paylite_shopping_payment_back');
        $app->match('/shopping/epsilon_payment/complete', '\\Plugin\\EccubePaymentLite3\\Controller\\PaymentController::complete')->bind('paylite_shopping_payment_complete');
        $app->match('/shopping/credit_card', '\\Plugin\\EccubePaymentLite3\\Controller\\PaymentController::tokenCredit')->bind('paylite_credit_card_for_token_payment');
        $app->match('/shopping/checkout', '\\Plugin\\EccubePaymentLite3\\Controller\\PaymentController::checkout')->bind('paylite_shopping_checkout');
        $app->match('/epsilon_deferred_payment_status_change_notification', '\\Plugin\\EccubePaymentLite3\\Controller\\PaymentNotification\\DeferredPaymentStatusChangeNotificationController::index')->bind('paylite_deferred_payment_status_change_notification');

        // Regular order
        $app->match('/' . $app["config"]["admin_route"] . '/paylite_regular_order', '\\Plugin\\EccubePaymentLite3\\Controller\\Admin\\Order\\RegularOrderController::index')->bind('paylite_regular_order');
        $app->match('/' . $app["config"]["admin_route"] . '/paylite_regular_order/page/{page_no}', '\\Plugin\\EccubePaymentLite3\\Controller\\Admin\\Order\\RegularOrderController::index')->assert('page_no', '\d+')->bind('paylite_regular_order_page');
        $app->match('/' . $app["config"]["admin_route"] . '/paylite_regular_order/add', '\\Plugin\\EccubePaymentLite3\\Controller\\Admin\\Order\\RegularOrderController::add')->bind('paylite_regular_order_add');
        $app->match('/' . $app["config"]["admin_route"] . '/epsilon_regular_order/{id}/delete', '\\Plugin\\EccubePaymentLite3\\Controller\\Admin\\Order\\RegularOrderController::delete')->bind('paylite_regular_order_delete');
        $app->match('/' . $app["config"]["admin_route"] . '/epsilon_regular_order/{id}/edit', '\\Plugin\\EccubePaymentLite3\\Controller\\Admin\\Order\\RegularEditController::index')->bind('paylite_regular_order_edit');
        $app->match('/' . $app["config"]["admin_route"] . '/epsilon_regular_order/search/product', '\\Plugin\\EccubePaymentLite3\\Controller\\Admin\\Order\\RegularEditController::searchProduct')->bind('paylite_regular_order_search_product');

        // Reg Credit Card
        $app->match('/' . $app["config"]["admin_route"] . '/order/{id}/create_reg_credit_order', '\\Plugin\\EccubePaymentLite3\\Controller\\Admin\\Order\\CreateRegCreditOrderController::index')->bind('paylite_create_reg_credit_order');

        // 3Dセキュア
        $app->match('/shopping/epsilon_payment/reception3ds', '\\Plugin\\EccubePaymentLite3\\Controller\\Reception3DSAuthenticationController::index')->bind('paylite_shopping_reception_3ds');

        // 3D 2.0セキュア
        $app->match('/shopping/epsilon_payment/reception3ds2', '\\Plugin\\EccubePaymentLite3\\Controller\\Reception3DSAuthenticationController::index')->bind('paylite_shopping_reception_3ds2');

        // Mypage
        $app->match('/mypage/gmo_epsilon_credit_card', '\\Plugin\\EccubePaymentLite3\\Controller\\Mypage\\EditCreditCardController::index')->value('mypageno', 'card')->bind('paylite_mypage_credit_card_index');
        $app->match('/mypage/gmo_epsilon_credit_card/new', '\\Plugin\\EccubePaymentLite3\\Controller\\Mypage\\EditCreditCardController::create')->value('mypageno', 'card')->bind('paylite_mypage_credit_card_new');
        $app->match('/mypage/gmo_epsilon_credit_card/edit', '\\Plugin\\EccubePaymentLite3\\Controller\\Mypage\\EditCreditCardController::edit')->value('mypageno', 'card')->bind('paylite_mypage_credit_card_edit');
        $app->match('/mypage/gmo_epsilon_credit_card/complete', '\\Plugin\\EccubePaymentLite3\\Controller\\Mypage\\EditCreditCardController::complete')->value('mypageno', 'card')->bind('paylite_mypage_credit_card_complete');
        // Service
        $app['eccube.plugin.epsilon.service.base'] = $app->share(function () use ($app) {
            return new GmoEpsilon_Base($app);
        });
        $app['eccube.plugin.epsilon.service.credit'] = $app->share(function () use ($app) {
            return new GmoEpsilon_Credit($app);
        });
        $app['eccube.plugin.epsilon.service.reg_credit'] = $app->share(function () use ($app) {
            return new GmoEpsilon_Reg_Credit($app);
        });
        $app['eccube.plugin.epsilon.service.convenience'] = $app->share(function () use ($app) {
            return new GmoEpsilon_Convenience($app);
        });
        $app['eccube.plugin.epsilon.service.netbank_jnb'] = $app->share(function () use ($app) {
            return new GmoEpsilon_Netbank_Jnb($app);
        });
        $app['eccube.plugin.epsilon.service.netbank_rakuten'] = $app->share(function () use ($app) {
            return new GmoEpsilon_Netbank_Rakuten($app);
        });
        $app['eccube.plugin.epsilon.service.sumishin'] = $app->share(function () use ($app) {
            return new GmoEpsilon_Sumishin($app);
        });
        $app['eccube.plugin.epsilon.service.payeasy'] = $app->share(function () use ($app) {
            return new GmoEpsilon_Payeasy($app);
        });
        $app['eccube.plugin.epsilon.service.webmoney'] = $app->share(function () use ($app) {
            return new GmoEpsilon_Webmoney($app);
        });
        $app['eccube.plugin.epsilon.service.ywallet'] = $app->share(function () use ($app) {
            return new GmoEpsilon_Ywallet($app);
        });
        $app['eccube.plugin.epsilon.service.paypal'] = $app->share(function () use ($app) {
            return new GmoEpsilon_Paypal($app);
        });
        $app['eccube.plugin.epsilon.service.bitcash'] = $app->share(function () use ($app) {
            return new GmoEpsilon_Bitcash($app);
        });
        $app['eccube.plugin.epsilon.service.chocom'] = $app->share(function () use ($app) {
            return new GmoEpsilon_Chocom($app);
        });
        $app['eccube.plugin.epsilon.service.sphone'] = $app->share(function () use ($app) {
            return new GmoEpsilon_Sphone($app);
        });
        $app['eccube.plugin.epsilon.service.jcb'] = $app->share(function () use ($app) {
            return new GmoEpsilon_Jcb($app);
        });
        $app['eccube.plugin.epsilon.service.deferred'] = $app->share(function () use ($app) {
            return new GmoEpsilon_Deferred($app);
        });
        $app['eccube.plugin.epsilon.service.maillink'] = $app->share(function () use ($app) {
            return new GmoEpsilon_Maillink($app);
        });
        $app['eccube.plugin.epsilon.service.regular'] = $app->share(function () use ($app) {
            return new GmoEpsilon_Regular($app);
        });
        $app['eccube.plugin.epsilon.service.virtual_account'] = $app->share(function () use ($app) {
            return new GmoEpsilon_Virtual_Account($app);
        });
        $app['eccube.plugin.epsilon.service.paypay'] = $app->share(function () use ($app) {
            return new GmoEpsilon_PayPay($app);
        });
        $app['eccube.plugin.epsilon.service.mail'] = $app->share(function () use ($app) {
            return new GmoEpsilon_MailService($app);
        });
        $app['eccube.plugin.epsilon.service.expiration_notice_mail'] = $app->share(function () use ($app) {
            return new ChangeCardNotificationMailService($app);
        });
        $app['eccube.plugin.epsilon.service.get_customer_for_send_notice_mail'] = $app->share(function () use ($app) {
            return new GetCustomerForSendChangeCardMailService($app);
        });
        $app['eccube.plugin.epsilon.services'] = $app->share(function () use ($app) {
            return new GmoEpsilonService($app);
        });
        $app['eccube.plugin.epsilon.service.ip_black_list'] = $app->share(function () use ($app) {
            return new IpBlackListService($app);
        });
        $app['eccube.plugin.epsilon.service.get_card_expire_date'] = $app->share(function () use ($app) {
            return new GetCardExpireDateTimeService($app);
        });
        $app['eccube.plugin.epsilon.service.request.sales_payment'] = $app->share(function () use ($app) {
            return new SalesPaymentService($app);
        });
        $app['eccube.plugin.epsilon.service.request.cancel_payment'] = $app->share(function () use ($app) {
            return new CancelPaymentService($app);
        });
        $app['eccube.plugin.epsilon.service.request.shipping_registration'] = $app->share(function () use ($app) {
            return new ShippingRegistrationService($app);
        });
        $app['eccube.plugin.epsilon.service.request.change_payment_amount'] = $app->share(function () use ($app) {
            return new ChangePaymentAmountService($app);
        });
        $app['eccube.plugin.epsilon.service.request.get_sales'] = $app->share(function () use ($app) {
            return new GetSales2Service($app);
        });
        $app['eccube.plugin.epsilon.service.request.receive_order'] = $app->share(function () use ($app) {
            return new ReceiveOrderService($app);
        });
        $app['eccube.plugin.epsilon.service.action.update_payment_status'] = $app->share(function () use ($app) {
            return new UpdatePaymentStatus($app);
        });
        $app['eccube.plugin.epsilon.service.action.update_gmo_order'] = $app->share(function () use ($app) {
            return new UpdateGmoEpsilonOrder($app);
        });
        $app['eccube.plugin.epsilon.request.services'] = $app->share(function () use ($app) {
            return new GmoEpsilonRequestService($app);
        });
        $app['eccube.plugin.epsilon.getinfo.services'] = $app->share(function () use ($app) {
            return new GetUserInfoService($app);
        });
        // Repository
        $app['eccube.plugin.epsilon.repository.epsilon_plugin'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Plugin\EccubePaymentLite3\Entity\GmoEpsilonPlugin');
        });
        $app['eccube.plugin.epsilon.repository.payment_extension'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('\Plugin\EccubePaymentLite3\Entity\Extension\PaymentExtension');
        });
        $app['eccube.plugin.epsilon.repository.order_extension'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('\Plugin\EccubePaymentLite3\Entity\Extension\OrderExtension');
        });
        $app['eccube.plugin.epsilon.repository.regular_product'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('\Plugin\EccubePaymentLite3\Entity\RegularProduct');
        });
        $app['eccube.plugin.epsilon.repository.regular_status'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('\Plugin\EccubePaymentLite3\Entity\Master\RegularStatus');
        });
        $app['eccube.plugin.epsilon.repository.epsilon_member'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('\Plugin\EccubePaymentLite3\Entity\EpsilonMember');
        });
        $app['eccube.plugin.epsilon.repository.regular_order'] = $app->share(function () use ($app) {
            $regularOrderRepository = $app['orm.em']->getRepository('Plugin\EccubePaymentLite3\Entity\RegularOrder');
            $regularOrderRepository->setApp($app);
            $regularOrderRepository->setConfig($app['config']);

            return $regularOrderRepository;
        });
        $app['eccube.plugin.epsilon.repository.credit_access_block'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Plugin\EccubePaymentLite3\Entity\CreditAccessBlock');
        });
        $app['eccube.plugin.epsilon.repository.credit_access_logs'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Plugin\EccubePaymentLite3\Entity\CreditAccessLogs');
        });
        $app['eccube.plugin.epsilon.repository.payment_status'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Plugin\EccubePaymentLite3\Entity\Master\PaymentStatus');
        });
        $app['eccube.plugin.epsilon.repository.delivery_company'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Plugin\EccubePaymentLite3\Entity\Master\DeliveryCompany');
        });
        $app['eccube.plugin.epsilon.repository.shipping_extension'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Plugin\EccubePaymentLite3\Entity\Extension\ShippingExtension');
        });
        $app['eccube.plugin.epsilon.repository.delivery_extension'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Plugin\EccubePaymentLite3\Entity\Extension\DeliveryExtension');
        });
        $app['eccube.plugin.epsilon.repository.product_extension'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('\Plugin\EccubePaymentLite3\Entity\Extension\ProductExtension');
        });

        // form
        $app['form.types'] = $app->share($app->extend('form.types', function ($types) use ($app) {
            $types[] = new ConvenienceType($app);
            $types[] = new CreditCardForTokenPaymentType($app);
            $types[] = new OrderType($app);
            $types[] = new RegularOrderType($app);
            $types[] = new RegularShippingType($app);
            $types[] = new RegularShipmentItemType($app);
            $types[] = new RegularSearchOrderType($app['config']);
            $types[] = new SearchRegularProductType($app['config']);
            $types[] = new RegularStatusType($app);
            return $types;
        }));

        // Form\Type
        $app['form.type.extensions'] = $app->share($app->extend('form.type.extensions', function ($extensions) use ($app) {
            $extensions[] = new PaymentStatusTypeExtension($app);
            $extensions[] = new TrackingNumberTypeExtension($app);
            $extensions[] = new DeliveryCompanyTypeExtension($app);
            $extensions[] = new ProductTypeExtension($app);

            return $extensions;
        }));

        // em
        if (isset($app['orm.em'])) {
            $app['orm.em'] = $app->share($app->extend('orm.em', function (\Doctrine\ORM\EntityManager $em, \Silex\Application $app) {
                // tax_rule
                $taxRuleRepository = $em->getRepository('Eccube\Entity\TaxRule');
                $low_versions = array('3.0.3', '3.0.4', '3.0.5', '3.0.6');
                if (in_array(Constant::VERSION, $low_versions)) {
                    $taxRuleRepository->setApp($app);
                } else {
                    $taxRuleRepository->setApplication($app);
                }
                $taxRuleService = new TaxRuleService($taxRuleRepository);
                $em->getEventManager()->addEventSubscriber(new TaxRuleEventSubscriber($taxRuleService));

                return $em;
            }));
        }

        // sub navi
        if ($app['eccube.plugin.epsilon.repository.regular_product']->getRegularFlg() == 1) {
            $app['config'] = $app->share($app->extend('config', function ($config) {
                foreach ($config['nav'] as $key => $nav) {
                    if ($nav['id'] == 'order') {
                        $orderNav = $nav;
                        $orderNavKey = $key;
                        break;
                    }
                }

                $orderNav['child'][] = array(
                    'id' => 'epsilon_regular_order_master',
                    'name' => '定期受注マスター',
                    'url' => 'paylite_regular_order',
                );

                $config['nav'][$orderNavKey] = $orderNav;

                return $config;
            }));
        }

        // log file
        $app['monolog.gmoepsilon'] = $app->share(function ($app) {

            $logger = new $app['monolog.logger.class']('gmoepsilon');

            $file = $app['config']['root_dir'] . '/app/log/gmoepsilon.log';
            $RotateHandler = new RotatingFileHandler($file, $app['config']['log']['max_files'], Logger::INFO);
            $RotateHandler->setFilenameFormat(
                'GmoEpsilon_{date}',
                'Y-m-d'
            );

            $logger->pushHandler(
                new FingersCrossedHandler(
                    $RotateHandler,
                    new ErrorLevelActivationStrategy(Logger::INFO)
                )
            );

            return $logger;
        });

        // コマンドライン以外ではコマンドの登録はスキップする
        if (!isset($app['console'])) {
            return;
        }
        $app['console']->add(new CreditCardExpirationNoticeBatchCommand($app));
    }

    public function boot(BaseApplication $app)
    {
    }
}
