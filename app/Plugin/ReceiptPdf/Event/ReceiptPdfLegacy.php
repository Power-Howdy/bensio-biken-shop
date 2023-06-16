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

namespace Plugin\ReceiptPdf\Event;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class ReceiptPdfLegacy.
 * For old event.
 *
 * @deprecated support since 3.0.0, it will remove on 3.1
 */
class ReceiptPdfLegacy extends CommonEvent
{
    /**
     * 受注マスター表示、検索ボタンクリック時のEvent Fork.
     * 下記の項目を追加する.
     * ・検索結果一覧のコンボボックスに「帳票出力」を追加
     * ・検索結果一覧の上部に「一括帳票出力を追加.
     *
     * @param FilterResponseEvent $event
     */
    public function onRenderAdminReceiptPdfBefore(FilterResponseEvent $event)
    {
        log_info('EventLegacy: The Order pdf hook into the order search start');

        if (!$this->app->isGranted('ROLE_ADMIN')) {
            log_info('EventLegacy: You need permission manager to be able to use this function.');

            return;
        }

        $response = $event->getResponse();

        $response->setContent($this->getHtml($response));
        $event->setResponse($response);

        log_info('EventLegacy: The Order pdf hook into the order search end');
    }

    /**
     * EC-CUBEの受注マスター画面のHTMLを取得し、帳票関連項目を書き込む
     *
     * @param Response $response
     *
     * @return mixed
     */
    private function getHtml(Response $response)
    {
        $document = \DOMDocument::loadHTML($response->getContent());

        $xpath = new \DOMXPath($document);
        $menu = $xpath->query('//li[@id="dropmenu"]//ul[@class="dropdown-menu"]', $document)->item(0);

        if ($menu) {
            $parts = $this->app->renderView(
                'ReceiptPdf/Resource/template/admin/receipt_pdf_menu.twig'
            );
            $newNode = \DOMDocument::loadXML($parts)->getElementsByTagName('li')->item(0);
            $menu->appendChild($document->importNode($newNode, true));
        }

        $crawler = new Crawler($document);
        return $crawler->html();
    }
}
