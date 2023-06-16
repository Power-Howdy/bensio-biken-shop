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

namespace Plugin\ReceiptPdf\Service;

$includePath = get_include_path().';'.__DIR__.'/../vendor/tcpdf';
$includePath = $includePath.';'.__DIR__.'/../vendor/FPDI';
set_include_path($includePath);

require_once __DIR__.'/../vendor/tcpdf/tcpdf.php';
require_once __DIR__.'/../vendor/FPDI/fpdi.php';

/**
 * FPDIのラッパークラス.
 */
abstract class AbstractFPDIService extends \FPDI
{
}
