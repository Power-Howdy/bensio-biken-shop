<?php



namespace Plugin\EccubePaymentLite3;

use Eccube\Application;
use Eccube\Common\Constant;
use Eccube\Entity\Delivery;
use Eccube\Entity\Order;
use Eccube\Entity\Shipping;
use Eccube\Entity\CartItem;
use Eccube\Event\EventArgs;
use Eccube\Event\TemplateEvent;
use Plugin\EccubePaymentLite3\Entity\Extension\DeliveryExtension;
use Plugin\EccubePaymentLite3\Entity\Extension\OrderExtension;
use Plugin\EccubePaymentLite3\Entity\Master\DeliveryCompany;
use Plugin\EccubePaymentLite3\Entity\Master\PaymentStatus;
use Plugin\EccubePaymentLite3\Util\PaymentUtil;
use Plugin\EccubePaymentLite3\Util\ViewHelper;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class EccubePaymentLite3Event
{

    /**
     * @var Application
     */
    private $app;

    /**
     * @var array
     */
    private $const;

    /**
     * constructor.
     * @param $app
     */
    public function __construct($app)
    {
        $this->app = $app;
        $this->const = $app['config']['EccubePaymentLite3']['const'];
    }

    public function onRenderShoppingBefore(FilterResponseEvent $event)
    {
        $Order = $this->app['eccube.repository.order']->findOneBy(array('pre_order_id' => $this->app['eccube.service.cart']->getPreOrderId()));

        if (!is_null($Order)) {
            $Payment = $Order->getPayment();
            $PaymentConfig = null;
            if (!is_null($Payment)) {
                $PaymentConfig = $this->app['eccube.plugin.epsilon.repository.payment_extension']->find($Payment->getId());
            }
            // 現在のソースを取得
            $source = $event->getResponse()->getContent();

            // DOMDocumentのエラー制御
            libxml_use_internal_errors(true);

            // DOMDocumentを用いてソースを取得する
            $dom = new \DOMDocument();
            $dom->loadHTML('<?xml encoding="UTF-8">' . $source);
            $dom->encoding = "UTF-8";

            if (!is_null($PaymentConfig)) {
                // ソースを結合したい部分を取得
                $domElements = $dom->getElementsByTagName("*");
                for ($i = 0; $i < $domElements->length; $i++) {
                    if (@$domElements->item($i)->attributes->getNamedItem('id')->nodeValue == "order-button") {
                        $elements[] = $domElements->item($i);
                    }
                }

                if (!empty($elements)) {
                    // 購入ボタンを変更
                    $objUtil = new PaymentUtil($this->app);
                    $PaymentExtension = $objUtil->getPaymentTypeConfig($Order->getPayment()->getId());
                    $template = $dom->createDocumentFragment();
                    $template->appendXML($this->app['twig']->render('EccubePaymentLite3/Twig/shopping/next_cart_button.twig',
                        array('button_comment' => '注文する')
                    ));

                    $elements[0]->parentNode->replaceChild($template, $elements[0]);
                    $source = $event->getResponse()->setContent($dom->saveHTML());
                }
                // Get payment_type_id
                $paymentTypeId = $PaymentConfig->getPaymentTypeId();
                // Append info description for GMO後払い in shopping page
                if($paymentTypeId == $this->app['config']['EccubePaymentLite3']['const']['PAY_ID_DEFERRED']) {
                    $this->appendGMODeferredDescription($event, $dom);
                }
                // Append card info to shopping page
                if($paymentTypeId == $this->app['config']['EccubePaymentLite3']['const']['PAY_ID_REG_CREDIT']
                    || $paymentTypeId == $this->app['config']['EccubePaymentLite3']['const']['PAY_ID_CREDIT']) {
                    $this->appendCardInfo($event, $dom);
                }

                // 個数と総分量と支払い時期・お届け予定日がわかるテーブルが表示
                if ($Order->getPaymentMethod() === $this->app['config']['EccubePaymentLite3']['const']['PAY_NAME_EVERY_MONTH'] ||
                    $Order->getPaymentMethod() === $this->app['config']['EccubePaymentLite3']['const']['PAY_NAME_EVERY_OTHER_MONTH'] ||
                    $Order->getPaymentMethod() === $this->app['config']['EccubePaymentLite3']['const']['PAY_NAME_EVERY_THREE_MONTH'] ||
                    $Order->getPaymentMethod() === $this->app['config']['EccubePaymentLite3']['const']['PAY_NAME_EVERY_SIX_MONTH'] ||
                    $Order->getPaymentMethod() === $this->app['config']['EccubePaymentLite3']['const']['PAY_NAME_EVERY_YEAR']) {
                    // 各回の個数と総分量がわかるテーブルが5回分まで表示
                    $this->appendComTransInfo($event, $dom);
                    // 各回の代金の支払い時期とお届け予定日がわかるテーブルが5回分まで表示
                    $this->appendComTransDelivDateInfo($event, $dom);
                }
            }
            // 支払時期とキャンセル返品についての枠内
            $this->appendComTransOtherInfo($event, $dom);
        }
    }

    public function onControllerShoppingConfirmBefore($event = null)
    {
        // カートチェック
        if (!$this->app['eccube.service.cart']->isLocked()) {
            // カートが存在しない、カートがロックされていない時はエラー
            return $this->app->redirect($this->app->url('cart'));
        }

        $Order = $this->app['eccube.service.shopping']->getOrder($this->app['config']['order_processing']);
        if (!$Order) {
            $this->app->addError('front.shopping.order.error');
            return $this->app->redirect($this->app->url('shopping_error'));
        }

        // form作成
        $form = $this->app['eccube.service.shopping']->getShippingForm($Order);
        if ('POST' === $this->app['request']->getMethod()) {
            $form->handleRequest($this->app['request']);
            if ($form->isValid()) {
                $formData = $form->getData();
                $PaymentExtension = $this->app['eccube.plugin.epsilon.repository.payment_extension']->find($formData['payment']->getId());

                if (!is_null($PaymentExtension)) {
                    // 受注情報、配送情報を更新（決済処理中として更新する）
                    $this->app['eccube.service.order']->setOrderUpdate($this->app['orm.em'], $Order, $formData);

                    $Order->setOrderStatus($this->app['eccube.repository.order_status']->find($this->app['config']['order_pending']));
                    $this->app['orm.em']->persist($Order);
                    $this->app['orm.em']->flush();

                    // バージョンアップに伴う対応。
                    if (version_compare('3.0.11', Constant::VERSION, '<=')) {
                    	// 3.0.11以降
	                    $response = $this->app->redirect($this->app->url('paylite_shopping_payment'));
	                    $event->setResponse($response);
	                    return;
                    } else {
                    	// 3.0.10以前
	                    header("Location: " . $this->app->url('paylite_shopping_payment'));
	                    exit;
                    }
                }
            }
        }
    }

    public function onRenderShoppingCompleteBefore(FilterResponseEvent $event)
    {
        $orderId = $this->app['session']->get('eccube.plugin.epsilon.orderId');
        if ($orderId == null) {
            return;
        }

        $orderRep = $this->app['orm.em']->getRepository('\Eccube\Entity\Order');
        $Order = $orderRep->findOneBy(array('id' => $orderId));
        if ($Order == null) {
            return;
        }

        $PaymentExtension = $this->app['eccube.plugin.epsilon.repository.payment_extension']->find($Order->getPayment()->getId());
	    $paymentTypeId = $PaymentExtension->getPaymentTypeId();
        if ($paymentTypeId != $this->app['config']['EccubePaymentLite3']['const']['PAY_ID_CONVENI'] &&
                $paymentTypeId != $this->app['config']['EccubePaymentLite3']['const']['PAY_ID_PAYEASY']) {
            $this->app['session']->set('eccube.plugin.epsilon.orderId', null);
            return;
        }

        $source = $event->getResponse()->getContent();
        libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        $dom->loadHTML('<?xml encoding="UTF-8">' . $source);
        $dom->encoding = "UTF-8";

        $Elements = $dom->getElementsByTagName("*");
        $beforeNode = null;
        for ($i = 0; $i < $Elements->length; $i++) {
            if (@$Elements->item($i)->attributes->getNamedItem('class')->nodeValue == "complete_message") {
                // Position to insert HTML
                $beforeNode = $Elements->item($i);
            }
        }

        if (!is_null($beforeNode)) {
            $appendTwig = 'EccubePaymentLite3/Twig/shopping/shopping_complete_add.twig';
            $OrderExtension = $this->app['eccube.plugin.epsilon.repository.order_extension']->findOneBy(array('id' => $orderId));
            $arrOther = unserialize($OrderExtension->getPaymentInfo());

            // Render insert HTML
            $insert = $this->app['twig']->render($appendTwig, array('arrOther' => $arrOther));
            $template = $dom->createDocumentFragment();
            $template->appendXML($insert);
            $beforeNode->appendChild($template);
            $event->getResponse()->setContent($dom->saveHTML());
        }

        $this->app['session']->set('eccube.plugin.epsilon.orderId', null);
    }

    public function onRenderAdminOrderEditBefore(FilterResponseEvent $event) {
        $orderId = $this->app['request']->get('id');
        if ($orderId == null) {
            return;
        }

        $OrderExtension = $this->app['eccube.plugin.epsilon.repository.order_extension']->find($orderId);
        if ($OrderExtension == null) {
            return;
        }

        $regularOrderId = $OrderExtension->getRegularOrderId();
        if ($regularOrderId == null) {
            return;
        }

        $source = $event->getResponse()->getContent();
        libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        $dom->loadHTML('<?xml encoding="UTF-8">' . $source);
        $dom->encoding = "UTF-8";

        $Elements = $dom->getElementsByTagName("*");
        $beforeNode = null;
        for ($i = 0; $i < $Elements->length; $i++) {
            if (@$Elements->item($i)->attributes->getNamedItem('class')->nodeValue == "col_inner") {
                // Position to insert HTML
                $beforeNode = $Elements->item($i);
            }
        }

        if (!is_null($beforeNode)) {
            $appendTwig = 'EccubePaymentLite3/Twig/admin/Order/edit_add.twig';
            $RegularOrder = $this->app['eccube.plugin.epsilon.repository.regular_order']->find($regularOrderId);
            // Render insert HTML
            $insert = $this->app['twig']->render($appendTwig, array('RegularOrder' => $RegularOrder));
            $template = $dom->createDocumentFragment();
            $template->appendXML($insert);
            $beforeNode->appendChild($template);
            $event->getResponse()->setContent($dom->saveHTML());
        }
    }

    public function onControllerAdminOrderEditBefore() {
        $orderId = $this->app['request']->get('id');
        if ($orderId == null) {
            return;
        }

        $OrderExtension = $this->app['eccube.plugin.epsilon.repository.order_extension']->find($orderId);
        if ($OrderExtension == null) {
            return;
        }

        $regularOrderId = $OrderExtension->getRegularOrderId();
        if ($regularOrderId == null) {
            return;
        }

        $softDeleteFilter = $this->app['orm.em']->getFilters()->getFilter('soft_delete');
        $softDeleteFilter->setExcludes(array(
            'Eccube\Entity\Order'
        ));
    }

    /**
     * Append card info to shopping page
     * @param $event
     * @param $dom
     */
    public function appendCardInfo($event, $dom){
        if (!$this->app->isGranted('ROLE_USER')) {
            return;
        }
        $requestGetUserInfoService = $this->app['eccube.plugin.epsilon.getinfo.services'];
        // Get info of customer from Epsilon
        $results = $requestGetUserInfoService->handle();
        $isRegisteredCreditCard = true;
        if ($results['result'] === $this->const['receive_parameters']['result']['ng']) {
            $isRegisteredCreditCard = false;
        }
        $Elements = $dom->getElementsByTagName("*");
        $beforeNode = null;
        for ($i = 0; $i < $Elements->length; $i++) {
            if (@$Elements->item($i)->attributes->getNamedItem('id')->nodeValue == "payment_list") {
                // Position to insert HTML
                $beforeNode = $Elements->item($i);
            }
        }
        if (!is_null($beforeNode)) {
            // Render insert HTML
            $appendTwig = 'EccubePaymentLite3/Twig/shopping/credit_card_info.twig';
            $insert = $this->app['twig']->render($appendTwig, array(
                'isRegisteredCreditCard' => $isRegisteredCreditCard,
                'cardBrand' => $results['cardBrand'],
                'cardExpire' => $results['cardExpire'],
                'cardNumberMask' => $results['cardNumberMask']

            ));
            $template = $dom->createDocumentFragment();
            $template->appendXML($insert);
            $beforeNode->appendChild($template);
            $event->getResponse()->setContent($dom->saveHTML());
        }

    }

    /**
     * Append commercial transactions product info to shopping page
     *
     * @param $event
     * @param $dom
     */
    public function appendComTransInfo($event, $dom){
        if (!$this->app->isGranted('ROLE_USER')) {
            return;
        }

        $Elements = $dom->getElementsByTagName("*");
        $beforeNode = null;
        for ($i = 0; $i < $Elements->length; $i++) {
            if (@$Elements->item($i)->attributes->getNamedItem('id')->nodeValue == "shipping_confirm_box--0") {
                // Position to insert HTML
                $beforeNode = $Elements->item($i);
            }
        }
        if (!is_null($beforeNode)) {
            // Render insert HTML
            $appendTwig = 'EccubePaymentLite3/Twig/shopping/specified_commercial_transactions.twig';
            $Order = $this->app['eccube.repository.order']->findOneBy(array('pre_order_id' => $this->app['eccube.service.cart']->getPreOrderId()));

            $arrRegularDescriptionQuantity = array();
            $arrRegularDescriptionPrice = array();
            $arrRegularDescriptionPaymentDeliv = array();
            foreach ($Order->getOrderDetails() as $Detail) {
                $productID = $Detail->getproduct()->getId();
                $productExtension = $this->app['eccube.plugin.epsilon.repository.product_extension']->findOneBy(array('product_id' => $productID));
                if ($productExtension) {
                    $arrRegularDescriptionQuantity[] = array(
                        'product_id'                => $productID,
                        'product_name'              => $Detail->getproduct()->getName(),
                        'free_description_quantity' => $productExtension->getFreeDescriptionQuantity(),
                    );
                    $arrRegularDescriptionPrice[] = array(
                        'product_id'                     => $productID,
                        'product_name'                   => $Detail->getproduct()->getName(),
                        'free_description_selling_price' => $productExtension->getFreeDescriptionSellingPrice(),
                    );
                    $arrRegularDescriptionPaymentDeliv[] = array(
                        'product_id'                        => $productID,
                        'product_name'                      => $Detail->getproduct()->getName(),
                        'free_description_payment_delivery' => $productExtension->getFreeDescriptionPaymentDelivery(),
                    );
                }
            }

            $arrRegularDescriptionQuantity = array_unique($arrRegularDescriptionQuantity, SORT_REGULAR);;
            $arrRegularDescriptionPrice = array_unique($arrRegularDescriptionPrice, SORT_REGULAR);;
            $arrRegularDescriptionPaymentDeliv = array_unique($arrRegularDescriptionPaymentDeliv, SORT_REGULAR);;

            $Cart = $this->app['eccube.service.cart']->getCart();
            $limitCycle = 5;
            $insert = $this->app['twig']->render($appendTwig, array(
                'Order'                             => $Order,
                'totalQuantity'                     => $Cart->getTotalQuantity(),
                'limitCycle'                        => $limitCycle,
                'arrRegularDescriptionQuantity'     => $arrRegularDescriptionQuantity,
                'arrRegularDescriptionPrice'        => $arrRegularDescriptionPrice,
                'arrRegularDescriptionPaymentDeliv' => $arrRegularDescriptionPaymentDeliv,
            ));
            $template = $dom->createDocumentFragment();
            $template->appendXML($insert);
            $beforeNode->appendChild($template);
            $event->getResponse()->setContent($dom->saveHTML());
        }

    }

    /**
     * Append commercial transactions delivery date info to shopping page
     *
     * @param $event
     * @param $dom
     *
     * @throws \Exception
     */
    public function appendComTransDelivDateInfo($event, $dom){
        if (!$this->app->isGranted('ROLE_USER')) {
            return;
        }
        $Elements = $dom->getElementsByTagName("*");
        $beforeNode = null;
        for ($i = 0; $i < $Elements->length; $i++) {
            if (@$Elements->item($i)->attributes->getNamedItem('id')->nodeValue == "payment_list") {
                // Position to insert HTML
                $beforeNode = $Elements->item($i);
            }
        }
        if (!is_null($beforeNode)) {
            // Render insert HTML
            $appendTwig = 'EccubePaymentLite3/Twig/shopping/specified_commercial_transactions_deliv.twig';
            $Order = $this->app['eccube.repository.order']->findOneBy(array('pre_order_id' => $this->app['eccube.service.cart']->getPreOrderId()));

            $nextOrderDate = array();
            $purchaseOrderDate = array();

            // お届け日を取得
            $arrShippings = $Order->getShippings();
            $Shipping = $arrShippings[0];
            // 選択したお届け日
            $shippingDeliveryDate = $Shipping->getShippingDeliveryDate();

            if (empty($shippingDeliveryDate)) {
                // 未選択場合、商品のお届け可能日として計算する
                $shippingDeliveryDate = $this->app['eccube.service.shopping']->getFormDeliveryDates($Order);


                if (is_array($shippingDeliveryDate) && count($shippingDeliveryDate) > 0) {
                    $shippingDeliveryDate = array_keys($shippingDeliveryDate)[0];
                    $shippingDeliveryDate = new \DateTime($shippingDeliveryDate);
                }
            }

            // お届け日がない場合、受注の作成日として取得
            if (empty($shippingDeliveryDate)) {
                $shippingDeliveryDate = $Order->getCreateDate();
            }
            $nextOrderDate[] = $shippingDeliveryDate->format('Y/m/d');
            $CreateDate = $Order->getCreateDate();
            $purchaseOrderDate[] = $CreateDate->format('Y/m/d');
            // https://www.epsilon.jp/service/option/subscription_billing.html
            // お支払い時期は毎月25日に課金
            $shippingDeliveryDate = new \DateTime($CreateDate->format('Y/m/25'));
            $limitCycle = 5;
            for ($i = 0; $i < $limitCycle - 1; $i++) {
                $CreateDate = $this->app['eccube.plugin.epsilon.service.regular']->getNextOrderDate($Order->getPayment(), $CreateDate);
                $nextOrderDate[] = $CreateDate;
                $CreateDate = new \DateTime($CreateDate);

                $shippingDeliveryDate = $this->app['eccube.plugin.epsilon.service.regular']->getNextOrderDate($Order->getPayment(), $shippingDeliveryDate);
                $purchaseOrderDate[] = $shippingDeliveryDate;
                $shippingDeliveryDate = new \DateTime($shippingDeliveryDate);
            }

            $arrRegularDescriptionPaymentDeliv = array();
            foreach ($Order->getOrderDetails() as $Detail) {
                $productID = $Detail->getproduct()->getId();
                $productExtension = $this->app['eccube.plugin.epsilon.repository.product_extension']->findOneBy(array('product_id' => $productID));
                if ($productExtension) {
                    $arrRegularDescriptionPaymentDeliv[] = array(
                        'product_id'                        => $productID,
                        'product_name'                      => $Detail->getproduct()->getName(),
                        'free_description_payment_delivery' => $productExtension->getFreeDescriptionPaymentDelivery(),
                    );
                }
            }
            // remove duplicate data
            $arrRegularDescriptionPaymentDeliv = array_unique($arrRegularDescriptionPaymentDeliv, SORT_REGULAR);;
            $insert = $this->app['twig']->render($appendTwig, array(
                'Order'                             => $Order,
                'methodName'                        => $Order->getPayment(),
                'limitCycle'                        => $limitCycle,
                'nextOrderDate'                     => $nextOrderDate,
                'purchaseOrderDate'                 => $purchaseOrderDate,
                'arrRegularDescriptionPaymentDeliv' => $arrRegularDescriptionPaymentDeliv,
            ));
            $template = $dom->createDocumentFragment();
            $template->appendXML($insert);
            $beforeNode->appendChild($template);
            $event->getResponse()->setContent($dom->saveHTML());
        }
    }

    /**
     * Append commercial transactions other info to shopping page
     *
     * @param $event
     * @param $dom
     */
    public function appendComTransOtherInfo($event, $dom){
        if (!$this->app->isGranted('ROLE_USER')) {
            return;
        }
        $Elements = $dom->getElementsByTagName("*");
        $beforeNode = null;
        for ($i = 0; $i < $Elements->length; $i++) {
            if (@$Elements->item($i)->attributes->getNamedItem('id')->nodeValue == "contact_message") {
                // Position to insert HTML
                $beforeNode = $Elements->item($i);
            }
        }
        if (!is_null($beforeNode)) {
            // Render insert HTML
            $appendTwig = 'EccubePaymentLite3/Twig/shopping/specified_commercial_transactions_other.twig';

            $insert = $this->app['twig']->render($appendTwig, array());
            $template = $dom->createDocumentFragment();
            $template->appendXML($insert);
            $beforeNode->appendChild($template);
            $event->getResponse()->setContent($dom->saveHTML());
        }
    }

    /**
     * Append info description for GMO後払い in shopping page
     * @param $event
     * @param $dom
     */
    public function appendGMODeferredDescription($event, $dom){
        $Elements = $dom->getElementsByTagName("*");
        $beforeNode = null;
        for ($i = 0; $i < $Elements->length; $i++) {
            if (@$Elements->item($i)->attributes->getNamedItem('id')->nodeValue == "payment_list") {
                // Position to insert HTML
                $beforeNode = $Elements->item($i);
            }
        }
        if (!is_null($beforeNode)) {
            // Render insert HTML
            $appendTwig = 'EccubePaymentLite3/Twig/shopping/gmo_deferred_payment_description.twig';
            $insert = $this->app['twig']->render($appendTwig, array());
            $template = $dom->createDocumentFragment();
            $template->appendXML($insert);
            $beforeNode->appendChild($template);
            $event->getResponse()->setContent($dom->saveHTML());
        }

    }

    /**
     * Add sub menu link to change card page on menu in my page
     */
    public function onRenderMypageBefore(FilterResponseEvent $event) {
        // If user go to withdraw page and delete account, token will be null and isGranted function will be error.
        // Must check null token before call isGranted function.
        if(!is_null($this->app['security']->getToken())){
            // check user login before render sub menu link to change card page
            if ($this->app->isGranted('ROLE_USER')) {
                // Get request
                $request = $event->getRequest();
                // Get response
                $response = $event->getResponse();
                // Proccess html
                $html = $this->getHtmlMypage($request, $response);
                // Set content for response
                $response->setContent($html);
                $event->setResponse($response);
            }
        }
    }

    /**
     * Add menu card management into menu Mypage
     * @param Request $request
     * @param Response $response
     * @return string html
     */
    private function getHtmlMypage(Request $request, Response $response){
        $crawler = new Crawler($response->getContent());
        $html = $this->getHtml($crawler);
        // Get mypageno
        $myPageNo = $request->get('mypageno');

        $insert = $this->app->renderView('EccubePaymentLite3/Twig/mypage/mypage_navi_add.twig', array(
            'mypageno' => $myPageNo,
        ));

        $node = $crawler->filter("#main_middle .local_nav");
        if ($node->count() == 0) {
            return $html;
        }
        $oldHtml = $node->children('ul')->html();
        $newHtml = $oldHtml . $insert;
        $html = str_replace($oldHtml, $newHtml, $html);

        return $html;
    }

    /**
     * 解析用HTMLを取得
     *
     * @param Crawler $crawler
     * @return string
     */
    public static function getHtml(Crawler $crawler){
        $html = '';
        foreach ($crawler as $domElement) {
            $domElement->ownerDocument->formatOutput = true;
            $html .= $domElement->ownerDocument->saveHTML();
        }
        return EccubePaymentLite3Event::my_html_entity_decode($html);
    }

    /**
     * HTMLエンティティに変換された<>以外のみデコードする
     *
     * @param string $html
     * @return string
     */
    public static function my_html_entity_decode($html) {
        $result = preg_replace_callback
        ("/(&#[0-9]+;|&[a-zA-Z0-9]+;)/",
            function ($m) {
                if ($m[1] == "&lt;"   || $m[1] == "&gt;" ||
                    $m[1] == "&#060;" || $m[1] == "&#062;") {
                    return $m[1];
                }
                return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES");
            },
            $html);
        return $result;
    }

    /**
     * @param TemplateEvent $event
     */
    public function onAdminOrderEditRender(TemplateEvent $event)
    {
        $this->addTrackingNumber($event);
        $this->addPaymentStatus($event);
        $this->addCompletePaymentButton($event);
    }

    /**
     * @param TemplateEvent $event
     */
    public function onAdminProductEditRender(TemplateEvent $event)
    {
        // 分量項目と販売項目の関するフリー記述を追加
        $this->addFreeDescription($event);
    }

    /**
     * @param TemplateEvent $event
     */
    public function onRenderAdminOrder(TemplateEvent $event)
    {
        $this->addEpsilonPaymentStatus($event);
    }

    /**
     * Add Epsilon Payment Status in order search page
     *
     * @param TemplateEvent $event
     */
    private function addEpsilonPaymentStatus(TemplateEvent $event)
    {
        // Get source
        $source = $event->getSource();
        // Find 対応状況 column to insert new 決済状況 column
        $searchHeader = '<th id="result_list_main__header_order_status">対応状況</th>';
        $searchBody = '<td id="result_list_main__order_status--{{ Order.id }}">{{ Order.OrderStatus }}</td>';

        $snippetHeader = $this->app['twig']->getLoader()->getSource('EccubePaymentLite3/Twig/admin/Order/order_index_header.twig');
        $snippetBody = $this->app['twig']->getLoader()->getSource('EccubePaymentLite3/Twig/admin/Order/order_index_body.twig');

        $replaceHeader = $searchHeader . $snippetHeader;
        $replaceBody =  $searchBody .  $snippetBody;

        // Replace view
        $source = str_replace($searchHeader, $replaceHeader, $source);
        $source = str_replace($searchBody, $replaceBody, $source);

        // Get list orders
        $parameters = $event->getParameters();
        $orderList = $parameters['pagination'];

        $displayOrders = array();
        foreach ($orderList as $key => $order) {
            /** @var OrderExtension $OrderExtension */
            $OrderExtension = $this->app['eccube.plugin.epsilon.repository.order_extension']->find($order->getId());
            if ($OrderExtension) {
                $PaymentStatus = $OrderExtension->getPaymentStatus();
                if($PaymentStatus){
                    $displayOrders[$order->getId()]['id'] = $PaymentStatus->getId();
                    $displayOrders[$order->getId()]['name'] = $PaymentStatus->getName();
                }
            }
        }
        // Set parameters
        $parameters['arrEpsilonStatus'] = $displayOrders;
        $parameters['virtual_account'] = $this->app['config']['EccubePaymentLite3']['const']['PAY_NAME_VIRTUAL_ACCOUNT'];
        $parameters['payment_status_id'] = PaymentStatus::CHARGED;
        $event->setParameters($parameters);
        $event->setSource($source);
    }
    /**
     * Add Tracking Number in Edit Order page
     *
     * @param TemplateEvent $event
     */
    private function addTrackingNumber(TemplateEvent $event)
    {
        $source = $event->getSource();
        $snippet = $this->app['twig']->getLoader()->getSource('EccubePaymentLite3/Twig/admin/Order/tracking_number_form.twig');
        $source = ViewHelper::insertSnippet($source, $snippet);

        $event->setSource($source);
    }

    /**
     * Add PaymentStatus in Edit Order page
     *
     * @param TemplateEvent $event
     */
    private function addPaymentStatus(TemplateEvent $event)
    {
        $source = $event->getSource();
        $parameters = $event->getParameters();
        /** @var Order $Order */
        $Order = $parameters['Order'];

        // 新規作成時は決済ステータスを表示しない
        if (is_null($Order->getId())) {
            return;
        }

        $snippet = $this->app['twig']->getLoader()->getSource('EccubePaymentLite3/Twig/admin/Order/payment_status_form.twig');
        $source = ViewHelper::insertSnippet($source, $snippet);

        $event->setSource($source);
    }

    /**
     * Add Complete Payment Button in Edit Order page
     *
     * @param TemplateEvent $event
     */
    private function addCompletePaymentButton(TemplateEvent $event)
    {
        $source = $event->getSource();
        $parameters = $event->getParameters();
        /** @var Order $Order */
        $Order = $parameters['Order'];

        // 新規作成時は表示しない
        if (is_null($Order->getId())) {
            return;
        }

        // 登録済みのクレジットカード決済以外は表示しない
        if ($Order->getPaymentMethod() !== $this->app['config']['EccubePaymentLite3']['const']['PAY_NAME_REG_CREDIT']) {
            return;
        }

        /** @var OrderExtension $OrderExtension */
        $OrderExtension = $this->app['eccube.plugin.epsilon.repository.order_extension']->find($Order->getId());
        // gmo_epsilon_order_numberが登録済みの場合は表示しない
        $gmo_epsilon_order_number = $OrderExtension ? $OrderExtension->getGmoEpsilonOrderNo() : null;
        if (!empty($gmo_epsilon_order_number)) {
            return;
        }

        $snippet = $this->app['twig']->getLoader()->getSource('EccubePaymentLite3/Twig/admin/Order/complete_payment_button.twig');
        $source = ViewHelper::insertSnippet($source, $snippet);

        $snippet = $this->app['twig']->getLoader()->getSource('EccubePaymentLite3/Twig/admin/Order/complete_payment_modal.twig');
        $source = ViewHelper::insertModal($source, $snippet);

        $event->setSource($source);
    }

    /**
     * Add free description in Edit product page
     *
     * @param TemplateEvent $event
     */
    private function addFreeDescription(TemplateEvent $event)
    {
        $parameters = $event->getParameters();
        $Product = $parameters['Product'];
        $isRegularProduct = false;
        if (!empty($Product)) {
            foreach ($Product->getProductClasses() as $ProductClass) {
                $ProductType = $ProductClass->getProductType();
                if (empty($ProductType)) {
                    break;
                }
                if($ProductType->getName() === '定期購入商品') {
                    $isRegularProduct = true;
                    break;
                }

                if($ProductType->getId() !== $this->app['config']['product_type_normal']
                && $ProductType->getId() !== $this->app['config']['product_type_download']) {
                    $isRegularProduct = true;
                    break;
                }
            }
        }
        $source = $event->getSource();
        $snippet = $this->app['twig']->getLoader()->getSource('EccubePaymentLite3/Twig/admin/Product/product_extension.twig');
        $source = ViewHelper::insertSnippet($source, $snippet);

        $parameters['regular_product_type'] = $isRegularProduct;
        $event->setParameters($parameters);
        $event->setSource($source);
    }

    /**
     * @param EventArgs $eventArgs
     */
    public function onAdminOrderEditComplete(EventArgs $eventArgs)
    {
        $this->updateTrackingNumber($eventArgs);

        //【eccube→イプシロン】金額変更機能
        $this->changePaymentAmount($eventArgs);

        $this->changePaymentStatus($eventArgs);
    }

    /**
     * Update TrackingNumber
     *
     * @param EventArgs $eventArgs
     */
    private function updateTrackingNumber(EventArgs $eventArgs)
    {
        /** @var Order $TargetOrder */
        $TargetOrder = $eventArgs->getArgument('TargetOrder');
        /** @var Form $form */
        $form = $eventArgs->getArgument('form');

        $trackingNumbers = array();
        /** @var Form $item */
        foreach ($form->get('Shippings') as $item) {
            $trackingNumbers[] = $item->get('tracking_number')->getData();
        }

        $Shippings = $TargetOrder->getShippings();
        /** @var Shipping $Shipping */
        foreach ($Shippings as $key => $Shipping) {
            $params = array('tracking_number' => $trackingNumbers[$key]);
            $this->app['eccube.plugin.epsilon.repository.shipping_extension']->insertOrUpdate($Shipping->getId(), $params);
        }
    }

    /**
     * Change Payment Status
     *
     * @param EventArgs $eventArgs
     */
    private function changePaymentStatus(EventArgs $eventArgs)
    {
        /** @var Order $TargetOrder */
        $TargetOrder = $eventArgs->getArgument('TargetOrder');
        /** @var Form $form */
        $form = $eventArgs->getArgument('form');

        $request = $eventArgs->getRequest();
        if ($request->attributes->get('_route') === 'admin_order_new') {
            if ($TargetOrder->getPaymentMethod() !== $this->app['config']['EccubePaymentLite3']['const']['PAY_NAME_REG_CREDIT']) {
                return;
            }

            $this->app->addWarning('イプシロン決済サービスに登録済みクレジットカード決済登録は行っておりません。「決済を登録する」ボタンより決済処理を完了させてください。', 'admin');
            return;
        }

        // 決済ステータスが未入力の場合は処理を行なわない。
        /** @var PaymentStatus $PaymentStatus */
        $PaymentStatus = $form->get('PaymentStatus')->getData();
        if ($PaymentStatus instanceof PaymentStatus === false) {
            return;
        }

        // 受注登録（編集）画面
        if ($PaymentStatus->getId() === PaymentStatus::CHARGED) {
            $results = $this->app['eccube.plugin.epsilon.service.request.sales_payment']->handle($TargetOrder);

            // リクエストの成否に関わらず、決済ステータスは更新する。
            $this->app['eccube.plugin.epsilon.service.action.update_payment_status']->handle($TargetOrder, $PaymentStatus);
            $this->app->addSuccess('受注情報の決済ステータスを「課金済み」に変更しました', 'admin');

            if ($results['status'] === 'OK') {
                $this->app->addSuccess($results['message'], 'admin');
                return;
            }

            $this->app->addWarning($results['message'], 'admin');
            return;
        }

        if ($PaymentStatus->getId() === PaymentStatus::CANCEL) {
            $results = $this->app['eccube.plugin.epsilon.service.request.cancel_payment']->handle($TargetOrder);

            // リクエストの成否に関わらず決済ステータスを更新する
            $this->app['eccube.plugin.epsilon.service.action.update_payment_status']->handle($TargetOrder, $PaymentStatus);
            $this->app->addSuccess('受注情報の決済ステータスを「キャンセル」に変更しました', 'admin');

            if ($results['status'] === 'OK') {
                $this->app->addSuccess($results['message'], 'admin');
                return;
            }

            $this->app->addWarning($results['message'], 'admin');
            return;
        }

        if ($PaymentStatus->getId() === PaymentStatus::SHIPPING_REGISTRATION) {
            $results = $this->app['eccube.plugin.epsilon.service.request.shipping_registration']->handle($TargetOrder);

            // リクエストの成否に関わらず決済ステータスを更新する
            $this->app['eccube.plugin.epsilon.service.action.update_payment_status']->handle($TargetOrder, $PaymentStatus);
            $this->app->addSuccess('受注情報の決済ステータスを「出荷登録中」に変更しました', 'admin');

            if ($results['status'] === 'OK') {
                $this->app->addSuccess($results['message'], 'admin');
                return;
            }

            $this->app->addWarning($results['message'], 'admin');
            return;
        }

        if ($PaymentStatus->getId() === PaymentStatus::TEMPORARY_SALES) {
            $this->app['eccube.plugin.epsilon.service.action.update_payment_status']->handle($TargetOrder, $PaymentStatus);
            $this->app->addSuccess('受注情報の決済ステータスを「仮売上」に変更しました', 'admin');
            return;
        }

        if ($PaymentStatus->getId() === PaymentStatus::UNPAID) {
            $this->app['eccube.plugin.epsilon.service.action.update_payment_status']->handle($TargetOrder, $PaymentStatus);
            $this->app->addSuccess('受注情報の決済ステータスを「未課金」に変更しました', 'admin');
            return;
        }

        if ($PaymentStatus->getId() === PaymentStatus::UNDER_REVIEW) {
            $this->app['eccube.plugin.epsilon.service.action.update_payment_status']->handle($TargetOrder, $PaymentStatus);
            $this->app->addSuccess('受注情報の決済ステータスを「審査中」に変更しました', 'admin');
            return;
        }

        if ($PaymentStatus->getId() === PaymentStatus::EXAMINATION_NG) {
            $this->app['eccube.plugin.epsilon.service.action.update_payment_status']->handle($TargetOrder, $PaymentStatus);
            $this->app->addSuccess('受注情報の決済ステータスを「審査NG」に変更しました', 'admin');
            return;
        }
    }

    /**
     * Change Payment Amount
     * 【eccube→イプシロン】金額変更機能
     *
     * @param EventArgs $eventArgs
     */
    private function changePaymentAmount(EventArgs $eventArgs)
    {
        /** @var Order $TargetOrder */
        $TargetOrder = $eventArgs->getArgument('TargetOrder');

        // Customerがnullの場合処理を行わない
        $Customer = $TargetOrder->getCustomer();
        if (is_null($Customer)) {
            $this->app->addWarning('受注ID: '.$TargetOrder->getId().'は、ゲスト購入の受注は金額変更処理に対応していないため、イプシロン決済サービスとの同期処理をスキップしました', 'admin');
            return;
        }

        // 金額変更が必要か判定?
        $results = $this->app['eccube.plugin.epsilon.service.request.change_payment_amount']->handle($TargetOrder);

        // 決済金額変更リクエストが成功すれば、successのメッセージを返す。
        if ($results['result'] === $this->const['receive_parameters']['result']['ok']) {
            $this->app->addSuccess($results['message'], 'admin');
            return;
        }

        // 決済金額変更リクエストが失敗すれば、warningのメッセージを返す。
        $this->app->addWarning($results['message'], 'admin');
    }

    /**
     * @param TemplateEvent $event
     */
    public function onAdminSettingShopDeliveryEditRender(TemplateEvent $event)
    {
        $source = $event->getSource();
        $snippet = $this->app['twig']->getLoader()->getSource('EccubePaymentLite3/Twig/admin/Setting/Shop/delivery_company.twig');
        $source = ViewHelper::insertSnippet($source, $snippet);

        $event->setSource($source);
    }

    /**
     * @param EventArgs $eventArgs
     */
    public function onAdminProductEditComplete(EventArgs $eventArgs)
    {
        /** @var Product $Product */
        $Product = $eventArgs->getArgument('Product');
        /** @var Form $form */
        $form = $eventArgs->getArgument('form');
        $isRegularProduct = false;
        foreach ($Product->getProductClasses() as $ProductClass) {
            $ProductType = $ProductClass->getProductType();
            if (empty($ProductType)) {
                break;
            }

            if($ProductType->getName() === '定期購入商品') {
                $isRegularProduct = true;
                break;
            }

            if($ProductType->getId() !== $this->app['config']['product_type_normal']
                && $ProductType->getId() !== $this->app['config']['product_type_download']) {
                $isRegularProduct = true;
                break;
            }
        }

        if ($isRegularProduct == false) {
            return;
        }
        $params = array(
            'product_id' => $Product->getId(),
            'free_description_quantity' => $form->get('free_description_quantity')->getData(),
            'free_description_selling_price' => $form->get('free_description_selling_price')->getData(),
            'free_description_payment_delivery' => $form->get('free_description_payment_delivery')->getData(),
        );

        $this->app['eccube.plugin.epsilon.repository.product_extension']->insertOrUpdate($Product->getId(), $params);

    }

    /**
 * @param EventArgs $eventArgs
 */
    public function onAdminSettingShopDeliveryEditComplete(EventArgs $eventArgs)
    {
        /** @var Delivery $Delivery */
        $Delivery = $eventArgs->getArgument('Delivery');
        /** @var Form $form */
        $form = $eventArgs->getArgument('form');
        /** @var DeliveryCompany $DeliveryCompany */
        $DeliveryCompany = $form->get('DeliveryCompany')->getData();

        if ($Delivery && $DeliveryCompany) {
            /** @var DeliveryExtension $DeliveryExtension */
            $DeliveryExtension = $this->app['eccube.plugin.epsilon.repository.delivery_extension']->find($Delivery->getId());
            if (!$DeliveryExtension) {
                $DeliveryExtension = new DeliveryExtension();
                $DeliveryExtension->setId($Delivery->getId());
            }
            $DeliveryExtension->setDeliveryCompany($DeliveryCompany);

            $this->app['orm.em']->persist($DeliveryExtension);
            $this->app['orm.em']->flush();
        }
    }

    public function onShoppingLoginRender(TemplateEvent $event)
    {
        // 定期購入の時はゲストの表示を消す
        $cartService = $this->app['eccube.service.cart'];
        $cart = $cartService->getCart();
        $cartItem = $cart->getCartItems()->first();
        /* @var CartItem $cartItem */
        /* @var \Eccube\Entity\ProductClass $productClass */
        $productClass = $cartItem->getObject();
        if($productClass->getProductType()->getName() !== '定期購入商品') {
            return;
        }

        $source = $event->getSource();
        $tag = <<< EOT
{% block javascript %}
<script>
    $(window).on('load',function(){
        $('#guest_box').css('display', 'none');
    });
</script>

{% endblock javascript %}
EOT;

        $event->setSource($source . $tag);
    }
}
