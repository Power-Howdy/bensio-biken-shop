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

use Eccube\Application;

/**
 * Class Common Event.
 */
class CommonEvent
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * AbstractEvent constructor.
     *
     * @param \Silex\Application $app
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Render position.
     *
     * @param string $html
     * @param string $part
     *
     * @return string
     */
    public function renderPosition($html, $part)
    {
        /**
         * For old and new ec-cube version
         * Search group
         * Group 1
         * Points to start the search.
         */
        $search = '/(<li\s+id="dropmenu"[\s\S]*)';
        /*
         * Group 2
         * Start drop down section.
         */
        $search .= '(<ul\s+class="dropdown\-menu"[\s\S]*)';
        /*
         * Group 3
         * The end of the dropdown section.
         */
        $search .= '(<\/li>[\n\s]*<\/ul>)';
        /*
         * Group 4
         * Points to end the search.
         */
        $search .= '([\s\S]*<form\s+id="dropdown\-form")/';

        $arrMatch = array();
        preg_match($search, $html, $arrMatch, PREG_OFFSET_CAPTURE);

        if (!isset($arrMatch[4])) {
            return $html;
        }
        $oldHtml = $arrMatch[2][0];

        // first html
        $oldHtmlStartPos = $arrMatch[2][1];
        $firstHalfHtml = substr($html, 0, $oldHtmlStartPos);

        // end html
        $oldHtmlEndPos = $arrMatch[3][1];
        $endHalfHtml = substr($html, $oldHtmlEndPos);

        // new html
        $newHtml = str_replace('</ul>', $part.'</ul>', $oldHtml);

        $html = $firstHalfHtml.$newHtml.$endHalfHtml;

        return $html;
    }
}
