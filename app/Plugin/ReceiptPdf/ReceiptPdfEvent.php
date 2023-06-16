<?php
/*
 * This file is part of Receipt Pdf plugin
 *
 * Copyright (C) 2018 NinePoint Co. LTD. All Rights Reserved.
 *
 * Copyright (C) 2016 LOCKON CO.,LTD. All Rights Reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\ReceiptPdf;

use Eccube\Application;
use Eccube\Event\TemplateEvent;
use Plugin\ReceiptPdf\Event\ReceiptPdf;
use Plugin\ReceiptPdf\Event\ReceiptPdfLegacy;
use Plugin\ReceiptPdf\Util\Version;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

/**
 * Class ReceiptPdf Event.
 */
class ReceiptPdfEvent
{
    /**
     * @var Application
     */
    private $app;

    /**
     * ReceiptPdfEvent constructor.
     *
     * @param \Silex\Application $app
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Event for new hook point.
     *
     * @param TemplateEvent $event
     */
    public function onAdminReceiptIndexRender(TemplateEvent $event)
    {
        /* @var ReceiptPdf $orderPdfEvent */
        $orderPdfEvent = $this->app['ReceiptPdf.event.receipt_pdf'];
        $orderPdfEvent->onAdminReceiptIndexRender($event);
    }

    /**
     * Event for v3.0.0 - 3.0.8.
     *
     * @param FilterResponseEvent $event
     *
     * @deprecated for since v3.0.0, to be removed in 3.1
     */
    public function onRenderAdminReceiptPdfBefore(FilterResponseEvent $event)
    {
        if ($this->supportNewHookPoint()) {
            return;
        }

        /* @var ReceiptPdfLegacy $eventLegacy */
        $eventLegacy = $this->app['ReceiptPdf.event.receipt_pdf_legacy'];
        $eventLegacy->onRenderAdminReceiptPdfBefore($event);
    }

    /**
     * Check to support new hookpoint.
     *
     * @return bool v3.0.9以降のフックポイントに対応しているか？
     */
    private function supportNewHookPoint()
    {
        return Version::isSupportVersion();
    }
}
