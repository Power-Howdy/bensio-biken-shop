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

use Eccube\Application;
use Eccube\Entity\BaseInfo;
use Eccube\Entity\Help;
use Eccube\Entity\Order;
use Eccube\Entity\OrderDetail;
use Eccube\Repository\TaxRuleRepository;

/**
 * Class ReceiptPdfService.
 * Do export pdf function.
 */
class ReceiptPdfService extends AbstractFPDIService
{
    /**
     * @var TaxRuleRepository
     */
    private $taxRuleRepository;

    // ====================================
    // 定数宣言
    // ====================================
    /** OrderPdf用リポジトリ名 */
    const REPOSITORY_ORDER_PDF = 'eccube.repository.order';

    /** 通貨単位 */
    const MONETARY_UNIT = '円';

    /** ダウンロードするPDFファイルのデフォルト名 */
    const DEFAULT_DETAIL_PDF_NAME = 'nouhinsyo.pdf';
    const DEFAULT_RECEIPT_PDF_NAME = 'receipt.pdf';

    /** FONT ゴシック */
    const FONT_GOTHIC = 'kozgopromedium';
    /** FONT 明朝 */
    const FONT_SJIS = 'kozminproregular';

    /** 購入詳細情報 ラベル配列
     * @var array
     */
    private $labelCell = array();
    private $labelCellByFront = array();

    /*** 購入詳細情報 幅サイズ配列
     * @var array
     */
    private $widthCell = array();
    private $widthCellByFront = array();

    /** 最後に処理した注文番号 @var string */
    private $lastOrderId = null;

    // --------------------------------------
    // Font情報のバックアップデータ
    /** @var string フォント名 */
    private $bakFontFamily;
    /** @var string フォントスタイル */
    private $bakFontStyle;
    /** @var string フォントサイズ */
    private $bakFontSize;
    // --------------------------------------

    // lfTextのoffset
    private $baseOffsetX = 0;
    private $baseOffsetY = -4;

    /** ダウンロードファイル名 @var string */
    private $downloadFileName = null;

    /** 発行日 @var string */
    private $issueDate = '';

    /** 注文日 @var string */
    private $orderDate = '';

    /**
     * コンストラクタ.
     *
     * @param object $app
     */
    public function __construct($app)
    {
        $this->app = $app;
        $this->BaseInfo = $app['eccube.repository.base_info']->get();
        $this->taxRuleRepository = $this->app['eccube.repository.tax_rule'];

        parent::__construct();

        // 購入詳細情報の設定を行う
        // 動的に入れ替えることはない
        $this->labelCell[] = '商品名 / 商品コード';
        $this->labelCell[] = '数量';
        $this->labelCell[] = '単価';
        $this->labelCell[] = '金額(税込)';
        $this->widthCell = array(110.3, 12, 21.7, 24.5);

        $this->labelCellByFront[] = 'お取引日';
        $this->labelCellByFront[] = '項目';
        $this->labelCellByFront[] = '数量';
        $this->labelCellByFront[] = '単価';
        $this->labelCellByFront[] = '金額';
        // $this->labelCellByFront[] = '消費税額';
        $this->widthCellByFront = array(17, 108, 8, 16, 34); //-15

        // Fontの設定しておかないと文字化けを起こす
        $this->SetFont(self::FONT_SJIS);

        // PDFの余白(上左右)を設定
        $this->SetMargins(15, 20);

        // ヘッダーの出力を無効化
        $this->setPrintHeader(false);

        // フッターの出力を無効化
        $this->setPrintFooter(false);
        $this->setFooterMargin();
        $this->setFooterFont(array(self::FONT_SJIS, '', 8));
    }

    /**
     * 注文情報からPDFファイルを作成する.
     *
     * @param array $formData
     *                        [KEY]
     *                        ids: 注文番号
     *                        issue_date: 発行日
     *                        title: タイトル
     *                        message1: メッセージ1行目
     *                        message2: メッセージ2行目
     *                        message3: メッセージ3行目
     *                        note1: 備考1行目
     *                        note2: 備考2行目
     *                        note3: 備考3行目
     *
     * @return bool
     */
    public function makePdf(array $formData)
    {
        // 発行日の設定
        $this->issueDate = '作成日：  ' . $formData['issue_date']->format('Y年m月d日');

        // ダウンロードファイル名の初期化
        $this->downloadFileName = null;

        // データが空であれば終了
        if (!$formData['ids']) {
            return false;
        }

        // 注文番号をStringからarrayに変換
        $ids = explode(',', $formData['ids']);

        // 空文字列の場合のデフォルトメッセージを設定する
        $this->setDefaultData($formData);

        // ID順にPDF出力
        foreach ($ids as $id) {
            // 注文番号から受注情報を取得する
            $order = $this->app[self::REPOSITORY_ORDER_PDF]->find($id);
            if (!$order) {
                // 注文情報の取得ができなかった場合
                continue;
            }
            if ($formData['specification_flg']) {
                // テンプレートファイルを読み込む(app配下のテンプレートファイルを優先して読み込む)
                $pdfFile = $this->app['config']['ReceiptPdf']['const']['pdf_file'];
                $originalPath = __DIR__ . '/../Resource/template/' . $pdfFile;
                $userPath = $this->app['config']['template_realdir'] . '/../admin/ReceiptPdf/' . $pdfFile;
                $templateFilePath = file_exists($userPath) ? $userPath : $originalPath;
                $this->setSourceFile($templateFilePath);

                $this->lastOrderId = $id;

                // PDFにページを追加する
                $this->addPdfPage();

                // タイトルを描画する
                $this->renderTitle($formData['title']);

                // 店舗情報を描画する
                $this->renderShopDataDetail();

                // 注文情報を描画する
                $this->renderOrderDataReceipt($order);

                // メッセージを描画する
                $this->renderMessageData($formData);

                // 受注詳細情報を描画する
                $this->renderOrderData($order);

                // 備考を描画する
                $this->renderEtcData($formData);
            }

            if ($formData['receipt_flg']) {
                $pdfFile2 = $this->app['config']['ReceiptPdf']['const']['pdf_file2'];
                $originalPath2 = __DIR__ . '/../Resource/template/' . $pdfFile2;
                $userPath2 = $this->app['config']['template_realdir'] . '/../admin/ReceiptPdf/' . $pdfFile2;
                $templateFilePath2 = file_exists($userPath2) ? $userPath2 : $originalPath2;
                $this->setSourceFile($templateFilePath2);

                $this->lastOrderId = $id;

                // PDFにページを追加する
                $this->addPdfPage();



                // 注文情報を描画する
                $this->renderOrderDataDetail($order, $formData['address_name_flg']);
                if (!empty($formData['catalog_detail'])) {
                    // お品書きを描画する
                    $this->renderMenuData($formData);
                }
                // 店舗情報を描画する
                $this->renderShopDataReceipt($order);
                // 発行日を描画する
                $this->renderDateData();
                // 明細出力設定がONの場合、受注詳細情報を描画する
                $this->renderOrderData($order);
            }
        }
        return true;
    }

    public function makePdfFromFront($id)
    {

        // データが空であれば終了
        if (empty($id)) {
            return false;
        }

        // ダウンロードファイル名の初期化
        $this->downloadFileName = null;

        // ID順にPDF出力
        $order = $this->app[self::REPOSITORY_ORDER_PDF]->find($id);

        if (!$order) {
            // 注文情報の取得ができなかった場合
            return false;
        }

        $pdfFile2 = $this->app['config']['ReceiptPdf']['const']['pdf_file2'];
        $originalPath2 = __DIR__ . '/../Resource/template/' . $pdfFile2;
        $userPath2 = $this->app['config']['template_realdir'] . '/../admin/ReceiptPdf/' . $pdfFile2;
        $templateFilePath2 = file_exists($userPath2) ? $userPath2 : $originalPath2;
        $this->setSourceFile($templateFilePath2);

        $this->lastOrderId = $id;

        // PDFにページを追加する
        $this->addPdfPage();

        //ご注文日
        // $orderDate = $order->getCreateDate()->format('Y年m月d日');
        // 発行日の設定
        // $this->issueDate = '発行日： '.$orderDate;
        $this->issueDate = '発行日： ' . date('Y年m月d日');

        // 発行日を描画する
        $this->lfText(125, 27, $this->issueDate, 10);

        // 注文番号
        $this->lfText(125, 32, '注文番号：' . $order->getId(), 10);

        // 注文情報を描画する
        $this->renderOrderDataDetail($order, true);

        // 店舗情報を描画する
        $this->renderShopDataReceipt($order);

        // 明細出力設定がONの場合、受注詳細情報を描画する
        $this->renderOrderDataByFront($order);

        return true;
    }

    /**
     * PDFファイルを出力する.
     *
     * @return string|mixed
     */
    public function outputPdf($arrData)
    {
        if ($arrData['specification_flg']) {
            return $this->Output($this->getDetailName(), 'S');
        }
        if ($arrData['receipt_flg']) {
            return $this->Output($this->getReceiptName(), 'S');
        }
    }

    public function outputPdfFromFront()
    {
        return $this->Output($this->getReceiptName(), 'S');
    }

    /**
     * PDFファイル名を取得する
     * PDFが1枚の時は注文番号をファイル名につける.
     *
     * @return string ファイル名
     */
    public function getDetailName()
    {
        if (!is_null($this->downloadFileName)) {
            return $this->downloadFileName;
        }
        $this->downloadFileName = self::DEFAULT_DETAIL_PDF_NAME;
        if ($this->PageNo() == 1) {
            $this->downloadFileName = 'nouhinsyo-No' . $this->lastOrderId . '.pdf';
        }

        return $this->downloadFileName;
    }

    public function getReceiptName()
    {
        if (!is_null($this->downloadFileName)) {
            return $this->downloadFileName;
        }
        $this->downloadFileName = self::DEFAULT_RECEIPT_PDF_NAME;
        if ($this->PageNo() == 1) {
            $this->downloadFileName = 'ryoushuusho-No' . $this->lastOrderId . '.pdf';
        }

        return $this->downloadFileName;
    }


    /**
     * フッターに発行日を出力する.
     */
    public function Footer()
    {
        $this->Cell(0, 0, $this->issueDate, 0, 0, 'R');
    }

    /**
     * お品書きを出力する.
     */
    public function renderMenuData($formData)
    {
        $this->lfText(100, 90, $formData['catalog_detail'], 12);
    }

    /**
     * 発行日時を出力する.
     */
    public function renderDateData()
    {
        $this->lfText(150, 28, $this->issueDate, 10);
    }

    /**
     * 作成するPDFのテンプレートファイルを指定する.
     */
    protected function addPdfPage()
    {
        // ページを追加
        $this->AddPage();

        // テンプレートに使うテンプレートファイルのページ番号を取得
        $tplIdx = $this->importPage(1);

        // テンプレートに使うテンプレートファイルのページ番号を指定
        $this->useTemplate($tplIdx, null, null, null, null, true);
    }

    /**
     * PDFに店舗情報を設定する
     * ショップ名、ロゴ画像以外はdtb_helpに登録されたデータを使用する.
     */
    protected function renderShopDataDetail()
    {
        // 基準座標を設定する
        $this->setBasePosition();

        // 特定商取引法を取得する
        /* @var Help $Help */
        $Help = $this->app['eccube.repository.help']->get();

        // ショップ名
        $this->lfText(125, 60, $this->BaseInfo->getShopName(), 8, 'B');
        // URL
        $this->lfText(125, 63, $Help->getLawUrl(), 8);
        // 会社名
        $this->lfText(125, 68, $Help->getLawCompany(), 8);
        // 郵便番号
        $text = '〒 ' . $Help->getLawZip01() . ' - ' . $Help->getLawZip02();
        $this->lfText(125, 71, $text, 8);
        // 都道府県+所在地
        $lawPref = $Help->getLawPref() ? $Help->getLawPref()->getName() : null;
        $text = $lawPref . $Help->getLawAddr01();
        $this->lfText(125, 74, $text, 8);
        $this->lfText(125, 77, $Help->getLawAddr02(), 8);

        // 電話番号
        // $text = 'TEL: ' . $Help->getLawTel01() . '-' . $Help->getLawTel02() . '-' . $Help->getLawTel03();
        // //FAX番号が存在する場合、表示する
        // if (strlen($Help->getLawFax01()) > 0) {
        //     $text .= '　FAX: ' . $Help->getLawFax01() . '-' . $Help->getLawFax02() . '-' . $Help->getLawFax03();
        // }
        $text = "ガレリアグランデ２１０７";
        $this->lfText(125, 80, $text, 8);  //TEL・FAX

        // メールアドレス
        if (strlen($Help->getLawEmail()) > 0) {
            $text = 'Email: ' . $Help->getLawEmail();
            $this->lfText(125, 83, $text, 8);      // Email
        }


        // ロゴ画像(app配下のロゴ画像を優先して読み込む)
        $logoFile = $this->app['config']['ReceiptPdf']['const']['logo_file'];
        $originalPath = __DIR__ . '/../Resource/template/' . $logoFile;
        $userPath = $this->app['config']['template_realdir'] . '/../admin/ReceiptPdf/' . $logoFile;
        $logoFilePath = file_exists($userPath) ? $userPath : $originalPath;
        $this->Image($logoFilePath, 124, 46, 40);
    }
    protected function renderShopDataReceipt(Order $Order)
    {
        // 基準座標を設定する
        $this->setBasePosition(0, 38);

        // 特定商取引法を取得する
        /* @var Help $Help */
        $Help = $this->app['eccube.repository.help']->get();

        // 会社名
        $this->SetFont(self::FONT_SJIS, 'B', 10);
        $this->Cell(110, 6, '', 0, 0, 'R', 0, '');
        $this->Cell(83, 6, $Help->getLawCompany(), 0, 1, 'L', 0, '');
        // $this->lfText(160, 55, $Help->getLawCompany(), 8);
        $this->SetFont(self::FONT_SJIS, '', 10);
        // 郵便番号
        $text = '〒 ' . $Help->getLawZip01() . ' - ' . $Help->getLawZip02();
        $this->Cell(110, 6, '', 0, 0, 'L', 0, '');
        $this->Cell(83, 6, $text, 0, 1, 'L', 0, '');
        // 都道府県+所在地
        //$lawPref = $Help->getLawPref() ? $Help->getLawPref()->getName() : null;
        /////////////////////////////////////
        //$text = $lawPref . $Help->getLawAddr01() . $Help->getLawAddr02();
        $text = $this->BaseInfo->getAddr01();
        $this->Cell(110, 6, '', 0, 0, 'L', 0, '');
        $this->Cell(83, 6, $text, 0, 1, 'L', 0, '');
        // 電話番号
        // $text = 'TEL: ' . $Help->getLawTel01() . '-' . $Help->getLawTel02() . '-' . $Help->getLawTel03();
        //$text =  $Help->getLawAddr02(); //'ガレリアグランデ２１０７';

        $text = $this->BaseInfo->getAddr02();
        $this->Cell(110, 6, '', 0, 0, 'L', 0, '');
        $this->Cell(83, 6, $text, 0, 1, 'L', 0, '');
        // 登録番号
        $text = "登録番号: " . $this->BaseInfo->getReceiptNumber();
        $this->Cell(110, 6, '', 0, 0, 'L', 0, '');
        $this->Cell(83, 6, $text, 0, 1, 'L', 0, '');

        // ロゴ画像(app配下のロゴ画像を優先して読み込む)
        $baseLogFileName = $this->BaseInfo->getReceiptLogo();
        $baseLogFilePath = $this->app['config']['image_save_realdir'] . '/' . $baseLogFileName;

        $logoFilePath = '';
        if (file_exists($baseLogFilePath)) {
            $logoFilePath = $baseLogFilePath;
        } else {
            $logoFile = $this->app['config']['ReceiptPdf']['const']['logo_file'];
            $originalPath = __DIR__ . '/../Resource/template/' . $logoFile;
            $userPath = $this->app['config']['template_realdir'] . '/../admin/ReceiptPdf/' . $logoFile;
            $logoFilePath = file_exists($userPath) ? $userPath : $originalPath;
        }
        $this->Image($logoFilePath, 178, 47, 14);
    }

    /**
     * メッセージを設定する.
     *
     * @param array $formData
     */
    protected function renderMessageData(array $formData)
    {
        $this->lfText(27, 70, $formData['message1'], 8);  //メッセージ1
        $this->lfText(27, 74, $formData['message2'], 8);  //メッセージ2
        $this->lfText(27, 78, $formData['message3'], 8);  //メッセージ3
    }

    /**
     * PDFに備考を設定数.
     *
     * @param array $formData
     */
    protected function renderEtcData(array $formData)
    {
        // フォント情報のバックアップ
        $this->backupFont();

        $this->Cell(0, 10, '', 0, 1, 'C', 0, '');

        $this->SetFont(self::FONT_GOTHIC, 'B', 9);
        $this->MultiCell(0, 6, '＜ 備考 ＞', 'T', 2, 'L', 0, '');

        $this->SetFont(self::FONT_SJIS, '', 8);

        $this->Ln();
        // rtrimを行う
        $text = preg_replace('/\s+$/us', '', $formData['note1'] . "\n" . $formData['note2'] . "\n" . $formData['note3']);
        $this->MultiCell(0, 4, $text, '', 2, 'L', 0, '');

        // フォント情報の復元
        $this->restoreFont();
    }

    /**
     * タイトルをPDFに描画する.
     *
     * @param string $title
     */
    protected function renderTitle($title)
    {
        // 基準座標を設定する
        $this->setBasePosition();

        // フォント情報のバックアップ
        $this->backupFont();

        //文書タイトル（納品書・請求書）
        $this->SetFont(self::FONT_GOTHIC, '', 15);
        $this->Cell(0, 10, $title, 0, 2, 'C', 0, '');
        $this->Cell(0, 66, '', 0, 2, 'R', 0, '');
        $this->Cell(5, 0, '', 0, 0, 'R', 0, '');

        // フォント情報の復元
        $this->restoreFont();
    }

    /**
     * 購入者情報を設定する.
     *
     * @param Order $Order
     */
    protected function renderOrderDataReceipt(Order $Order)
    {
        // 基準座標を設定する
        $this->setBasePosition();

        // フォント情報のバックアップ
        $this->backupFont();

        // =========================================
        // 購入者情報部
        // =========================================
        // 郵便番号
        $text = '〒 ' . $Order->getZip01() . ' - ' . $Order->getZip02();
        $this->lfText(23, 43, $text, 10);

        // 購入者都道府県+住所1
        $text = $Order->getPref() . $Order->getAddr01();
        $this->lfText(27, 47, $text, 10);
        $this->lfText(27, 51, $Order->getAddr02(), 10); //購入者住所2

        // 購入者氏名
        $text = $Order->getName01() . '　' . $Order->getName02() . '　様';
        $this->lfText(27, 59, $text, 11);

        // =========================================
        // お買い上げ明細部
        // =========================================
        $this->SetFont(self::FONT_SJIS, '', 10);

        //ご注文日
        $orderDate = $Order->getCreateDate()->format('Y/m/d H:i');
        if ($Order->getOrderDate()) {
            $orderDate = $Order->getOrderDate()->format('Y/m/d H:i');
        }

        $this->lfText(25, 125, $orderDate, 10);
        //注文番号
        $this->lfText(25, 135, $Order->getId(), 10);

        // 総合計金額
        //totalpayment amount now is calculated without the 10% tax of delivery fee
        //so should add deliveryfee*0.1
        $this->SetFont(self::FONT_SJIS, 'B', 15);
        $paymentTotalText = number_format($Order->getPaymentTotal() + $Order->getDeliveryFeeTotal()*0.1) . ' ' . self::MONETARY_UNIT;

        $this->setBasePosition(120, 95.5);
        $this->Cell(5, 7, '', 0, 0, '', 0, '');
        $this->Cell(67, 8, $paymentTotalText, 0, 2, 'R', 0, '');
        $this->Cell(0, 45, '', 0, 2, '', 0, '');

        // フォント情報の復元
        $this->restoreFont();
    }

    protected function getPaymentTotalForOrder(Order $Order){

    }

    /**
     * 宛名を設定する.
     *
     * @param Order $Order
     */
    protected function renderOrderDataDetail(Order $Order, $addressNameFlg)
    {
        // 基準座標を設定する
        $this->setBasePosition();

        // フォント情報のバックアップ
        $this->backupFont();

        // 宛名出力有無
        if ($addressNameFlg) {
            // 購入者氏名
            $text = $Order->getName01() . '　' . $Order->getName02() . '　御中';
            if (strlen($text) >= 60) {
                $this->lfText(15, 46, $text, 12);
            } else {
                $text = $Order->getName01() . '　' . $Order->getName02();
                $this->lfText(32, 37, $text . '      御中', 12);
                // $this->setBasePosition(55, 32);
                // $this->Cell(79, 6, $text, 0, 2, 'L', 0, '');
                // $this->setBasePosition(55, 32);
                // $this->Cell(81, 6, '御中', 0, 2, 'R', 0, '');
            }
        } else {
            $this->setBasePosition(100, 41);
            $this->Cell(81, 8, '御中', 0, 2, 'R', 0, '');
        }

        // 総合計金額
        $this->SetFont(self::FONT_SJIS, 'B', 12);
        $paymentTotalText = number_format($Order->getPaymentTotal()+$Order->getDeliveryFeeTotal()*0.1) . ' ' . self::MONETARY_UNIT;

        $this->setBasePosition(156, 60);
        $this->Cell(30, 6, '', 0, 0, '', 0, '');
        $this->Cell(70, 6, "合計金額：￥ " . $paymentTotalText, 0, 2, 'C', 0, '');

        // 消費税額の取得
        $this->SetFont(self::FONT_SJIS, '', 10);
        // $taxSum = $this->getTaxTotalByTaxRate($Order);
        // $tax = 0;
        // if (isset($taxSum[8])) {
        //     // 消費税（8％）
        //     $tax = str_replace('￥', '', $this->getPriceFilter($taxSum[8]));
        // }
        // if (isset($taxSum[10])) {
        //     // 消費税（10％）
        //     $tax = $tax + str_replace('￥', '', $this->getPriceFilter($taxSum[10]));
        // }
        // 内消費税
        // $this->Cell(70, 6, "内消費税：" . $this->getPriceFilter($Order->calculateTotalTax()), 0, 2, 'R', 0, '');

        // 送料
        // $this->Cell(70, 6, "送料：" . $this->getPriceFilter($Order->getDeliveryFeeTotal()), 0, 2, 'R', 0, '');

        // お支払い方法
        $this->Ln();
        $this->Cell(30, 6, '', 0, 0, '', 0, '');
        $this->Cell(70, 6, "お支払い方法：" . $Order->getPaymentMethod(), 0, 2, 'C', 0, '');

        // フォント情報の復元
        $this->restoreFont();
    }

    /**
     * 購入商品詳細情報を設定する.
     *
     * @param Order $Order
     */
    protected function renderOrderData(Order $Order)
    {
        $arrOrder = array();
        // テーブルの微調整を行うための購入商品詳細情報をarrayに変換する

        // =========================================
        // 受注詳細情報
        // =========================================
        $i = 0;
        /* @var OrderDetail $OrderDetail */
        foreach ($Order->getOrderDetails() as $OrderDetail) {
            // class categoryの生成
            $classCategory = '';
            if ($OrderDetail->getClassCategoryName1()) {
                $classCategory .= ' [ ' . $OrderDetail->getClassCategoryName1();
                if ($OrderDetail->getClassCategoryName2() == '') {
                    $classCategory .= ' ]';
                } else {
                    $classCategory .= ' * ' . $OrderDetail->getClassCategoryName2() . ' ]';
                }
            }
            // 税
            $tax = $this->app['eccube.service.tax_rule']->calcTax($OrderDetail->getPrice(), $OrderDetail->getTaxRate(), $OrderDetail->getTaxRule());
            $OrderDetail->setPriceIncTax($OrderDetail->getPrice() + $tax);

            // product
            $productName = $OrderDetail->getProductName();
            if (null !== $OrderDetail->getProductCode()) {
                $productName .= ' / ' . $OrderDetail->getProductCode();
            }
            if ($classCategory) {
                $productName .= ' / ' . $classCategory;
            }
            if ($this->isReducedTaxRate($OrderDetail)) {
                $productName .= ' ※';
            }
            $arrOrder[$i][0] = $productName;
            // 購入数量
            $arrOrder[$i][1] = number_format($OrderDetail->getQuantity());
            // 税込金額（単価）
            $arrOrder[$i][2] = $this->getPriceFilter($OrderDetail->getPrice());
            // 小計（商品毎）
            $arrOrder[$i][3] = $this->getPriceFilter($OrderDetail->getTotalPrice());

            ++$i;
        }

        // =========================================
        // 小計
        // =========================================
        $arrOrder[$i][0] = '';
        $arrOrder[$i][1] = '';
        $arrOrder[$i][2] = '';
        $arrOrder[$i][3] = '';

        ++$i;
        $arrOrder[$i][0] = '';
        $arrOrder[$i][1] = '';
        $arrOrder[$i][2] = '商品合計';
        $arrOrder[$i][3] = $this->getPriceFilter($Order->getSubtotal());

        ++$i;
        $arrOrder[$i][0] = '';
        $arrOrder[$i][1] = '';
        $arrOrder[$i][2] = '送料';
        $arrOrder[$i][3] = $this->getPriceFilter($Order->getDeliveryFeeTotal());

        ++$i;
        $arrOrder[$i][0] = '';
        $arrOrder[$i][1] = '';
        $arrOrder[$i][2] = '手数料';
        $arrOrder[$i][3] = $this->getPriceFilter($Order->getCharge());

        ++$i;
        $arrOrder[$i][0] = '';
        $arrOrder[$i][1] = '';
        $arrOrder[$i][2] = '値引き';
        $arrOrder[$i][3] = '-' . $this->getPriceFilter($Order->getDiscount());

        ++$i;
        $arrOrder[$i][0] = '';
        $arrOrder[$i][1] = '';
        $arrOrder[$i][2] = '';
        $arrOrder[$i][3] = '';

        ++$i;
        $arrOrder[$i][0] = '';
        $arrOrder[$i][1] = '';
        $arrOrder[$i][2] = '合計';
        $arrOrder[$i][3] = $this->getPriceFilter($Order->getTotal());

        foreach ($this->getTaxableTotalByTaxRate($Order) as $rate => $total) {
            ++$i;
            $arrOrder[$i][0] = '';
            $arrOrder[$i][1] = '';
            $arrOrder[$i][2] = '(' . $rate . '%対象)';
            $arrOrder[$i][3] = $this->getPriceFilter($total);
        }

        ++$i;
        $arrOrder[$i][0] = '';
        $arrOrder[$i][1] = '';
        $arrOrder[$i][2] = '';
        $arrOrder[$i][3] = '';

        ++$i;
        $arrOrder[$i][0] = '';
        $arrOrder[$i][1] = '';
        $arrOrder[$i][2] = '請求金額';
        $arrOrder[$i][3] = $this->getPriceFilter($Order->getPaymentTotal());

        ++$i;
        $arrOrder[$i][0] = '※は軽減税率対象商品です。';
        $arrOrder[$i][1] = '';
        $arrOrder[$i][2] = '';
        $arrOrder[$i][3] = '';

        // PDFに設定する
        $this->setFancyTable($this->labelCell, $arrOrder, $this->widthCell);
    }

    protected function renderOrderDataByFront(Order $Order)
    {
        // フォント情報のバックアップ
        $this->backupFont();

        // 開始座標の設定
        $this->setBasePosition(0, 90);

        // Colors, line width and bold font
        $this->SetFillColor(216, 216, 216);
        $this->SetTextColor(0);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont(self::FONT_SJIS, 'B', 9); //8
        // $this->SetFont('', 'B');

        // Header
        $count = count($this->labelCellByFront);
        for ($i = 0; $i < $count; ++$i) {
            $this->Cell($this->widthCellByFront[$i], 7, $this->labelCellByFront[$i], 1, 0, 'C', 1);
        }
        $this->Ln();

        $totalMergeWidth = 0;
        for ($i = 0; $i < $count; ++$i) {
            $totalMergeWidth = $totalMergeWidth + $this->widthCellByFront[$i];
        }
        $this->SetFont(self::FONT_SJIS, 'B', 9); //8
        $this->Cell($totalMergeWidth, 6, '軽減税率対象外商品', 1, 0, 'C', 0);
        $this->Ln();

        $arrOrder = array();
        // テーブルの微調整を行うための購入商品詳細情報をarrayに変換する

        // =========================================
        // 受注詳細情報
        // =========================================
        $i = 0;
        /* @var OrderDetail $OrderDetail */
        foreach ($Order->getOrderDetails() as $OrderDetail) {
            // class categoryの生成
            $classCategory = '';
            if ($OrderDetail->getClassCategoryName1()) {
                $classCategory .= ' [ ' . $OrderDetail->getClassCategoryName1();
                if ($OrderDetail->getClassCategoryName2() == '') {
                    $classCategory .= ' ]';
                } else {
                    $classCategory .= ' * ' . $OrderDetail->getClassCategoryName2() . ' ]';
                }
            }
            // 税
            $tax = $this->app['eccube.service.tax_rule']->calcTax($OrderDetail->getPrice(), $OrderDetail->getTaxRate(), $OrderDetail->getTaxRule());
            $OrderDetail->setPriceIncTax($OrderDetail->getPrice() + $tax);

            // product
            $productName = $OrderDetail->getProductName();
            // if (null !== $OrderDetail->getProductCode()) {
            //     $productName .= ' / '.$OrderDetail->getProductCode();
            // }
            // if ($classCategory) {
            //     $productName .= ' / '.$classCategory;
            // }
            if ($this->isReducedTaxRate($OrderDetail)) {
                // $productName .= ' ※';
                $arrOrder[$i][0] = 1;
            } else {
                $arrOrder[$i][0] = 0;
            }
            $arrOrder[$i][1] = $productName;
            // 購入数量
            $arrOrder[$i][2] = number_format($OrderDetail->getQuantity());
            // 税込金額（単価）
            $arrOrder[$i][3] = $this->getPriceFilter($OrderDetail->getPrice());
            // 小計（商品毎）
            $arrOrder[$i][4] = $this->getPriceFilter($OrderDetail->getQuantity() * $OrderDetail->getPrice());
            $arrOrder[$i][5] = $this->getPriceFilter($tax);
            $arrOrder[$i][6] = $OrderDetail->getQuantity() * $OrderDetail->getPrice(); //$OrderDetail->getPrice();
            ++$i;
        }

        $this->SetFont(self::FONT_SJIS, '', 8); //7
        $rowIndex = 0;
        $price10 = 0;
        foreach ($arrOrder as $row) {
            if ($row[0] == 0) {
                if ($rowIndex == 0) {
                    $this->Cell($this->widthCellByFront[0], 7, $Order->getOrderDate()->format('Y/m/d'), 1, 0, 'C', 0);
                    $rowIndex++;
                } else {
                    $this->Cell($this->widthCellByFront[0], 7, '', 1, 0, 'L', 0);
                }
                $this->Cell($this->widthCellByFront[1], 7, $row[1], 1, 0, 'L', 0);
                $this->Cell($this->widthCellByFront[2], 7, $row[2], 1, 0, 'C', 0);
                $this->Cell($this->widthCellByFront[3], 7, $row[3], 1, 0, 'R', 0);
                $this->Cell($this->widthCellByFront[4], 7, $row[4], 1, 0, 'R', 0);
                // $this->Cell($this->widthCellByFront[5], 7, $row[5], 1, 0, 'R', 0);
                $this->Ln();

                // $price10 = $this->getPriceFilter($price10 + $row[6]);
                $price10 += $row[6];
            }
        }
        /**
        //only when the delivery fee is not 0 yen
        if ($Order->getDeliveryFeeTotal() != 0) {
            $this->Cell($this->widthCellByFront[0], 7, '', 1, 0, 'L', 0);
            $this->Cell($this->widthCellByFront[1], 7, '送料', 1, 0, 'L', 0);
            $this->Cell($this->widthCellByFront[2], 7, '1', 1, 0, 'C', 0);
            $this->Cell($this->widthCellByFront[3], 7, $this->getPriceFilter($Order->getDeliveryFeeTotal()), 1, 0, 'R', 0);
            $this->Cell($this->widthCellByFront[4], 7, $this->getPriceFilter($Order->getDeliveryFeeTotal()), 1, 0, 'R', 0);
            $this->Ln();

            $price10 += $Order->getDeliveryFeeTotal();
        }
        */
        for ($i = 0; $i < $count; ++$i) {
            $this->Cell($this->widthCellByFront[$i], 7, '', 1, 0, 'C', 0);
        }
        $this->Ln();
        for ($i = 0; $i < $count; ++$i) {
            $this->Cell($this->widthCellByFront[$i], 7, '', 1, 0, 'C', 0);
        }
        $this->Ln();

        //軽減税率対象商品
        $this->SetFont(self::FONT_SJIS, 'B', 9); //8
        $this->Cell($totalMergeWidth, 6, '軽減税率対象商品', 1, 0, 'C', 0);
        $this->Ln();

        $this->SetFont(self::FONT_SJIS, '', 8); //7
        $price8 = 0;
        foreach ($arrOrder as $row) {
            if ($row[0] == 1) {
                $this->Cell($this->widthCellByFront[0], 7, '', 1, 0, 'L', 0);
                $this->Cell($this->widthCellByFront[1], 7, $row[1], 1, 0, 'L', 0);
                $this->Cell($this->widthCellByFront[2], 7, $row[2], 1, 0, 'C', 0);
                $this->Cell($this->widthCellByFront[3], 7, $row[3], 1, 0, 'R', 0);
                $this->Cell($this->widthCellByFront[4], 7, $row[4], 1, 0, 'R', 0);
                // $this->Cell($this->widthCellByFront[5], 7, $row[5], 1, 0, 'R', 0);
                $this->Ln();
                // $price8 = $this->getPriceFilter($price8 + $row[6]);
                $price8 +=  $row[6];
            }
        }

        for ($i = 0; $i < $count; ++$i) {
            $this->Cell($this->widthCellByFront[$i], 7, '', 1, 0, 'C', 0);
        }
        $this->Ln();
        for ($i = 0; $i < $count; ++$i) {
            $this->Cell($this->widthCellByFront[$i], 7, '', 1, 0, 'C', 0);
        }
        $this->Ln();
        for ($i = 0; $i < $count; ++$i) {
            $this->Cell($this->widthCellByFront[$i], 7, '', 1, 0, 'C', 0);
        }
        $this->Ln();
        for ($i = 0; $i < $count; ++$i) {
            $this->Cell($this->widthCellByFront[$i], 7, '', 1, 0, 'C', 0);
        }
        $this->Ln();
        //font increase
        $this->SetFont(self::FONT_SJIS, '', 9); //8
        $this->SetFillColor(255, 255, 255);
        $this->MultiCell(($this->widthCellByFront[0] + $this->widthCellByFront[1]), 7 * 9, '＜備考欄＞ ご利用ありがとうございました。                                                            ', 1, 0, 'L', 0);
        //font restore
        $this->SetFont(self::FONT_SJIS, '', 8); //7
        $this->Cell(($this->widthCellByFront[2] + $this->widthCellByFront[3]), 7, '10%対象税抜金額', 1, 0, 'C', 0);
        $this->Cell($this->widthCellByFront[4], 7, $price10 !== 0 ? $this->getPriceFilter($price10) : '', 1, 0, 'R', 0);
        $this->Ln();

        $this->Cell(($this->widthCellByFront[0] + $this->widthCellByFront[1]), 7, '', 0, 0, 'C', 0);
        $this->Cell(($this->widthCellByFront[2] + $this->widthCellByFront[3]), 7, '8%対象税抜金額', 1, 0, 'C', 0);
        $this->Cell($this->widthCellByFront[4], 7, $price8 !== 0 ? $this->getPriceFilter($price8) : '', 1, 0, 'R', 0);
        $this->Ln();

        // $taxSum = $this->getTaxTotalByTaxRate($Order);
        $this->Cell(($this->widthCellByFront[0] + $this->widthCellByFront[1]), 7, '', 0, 0, 'C', 0);
        $this->Cell(($this->widthCellByFront[2] + $this->widthCellByFront[3]), 7, '10%対象消費税', 1, 0, 'C', 0);
        $this->Cell($this->widthCellByFront[4], 7, $price10 != 0 ? $this->getPriceFilter($price10 * 0.1) : '', 1, 0, 'R', 0);
        // if (isset($taxSum[10])) {
        //     // 消費税（10％）
        //     $this->Cell($this->widthCellByFront[5], 7, $this->getPriceFilter($taxSum[10]), 1, 0, 'R', 0);
        // } else {
        //     $this->Cell($this->widthCellByFront[5], 7, $this->getPriceFilter(0), 1, 0, 'R', 0);
        // }
        $this->Ln();

        $this->Cell(($this->widthCellByFront[0] + $this->widthCellByFront[1]), 7, '', 0, 0, 'C', 0);
        $this->Cell(($this->widthCellByFront[2] + $this->widthCellByFront[3]), 7, '8%対象消費税', 1, 0, 'C', 0);
        $this->Cell($this->widthCellByFront[4], 7, $price8 !== 0 ? $this->getPriceFilter($price8 * 0.08) : '', 1, 0, 'R', 0);
        // if (isset($taxSum[8])) {
        //     // 消費税（8％）
        //     $this->Cell($this->widthCellByFront[5], 7, $this->getPriceFilter($taxSum[8]), 1, 0, 'R', 0);
        // } else {
        //     $this->Cell($this->widthCellByFront[5], 7, $this->getPriceFilter(0), 1, 0, 'R', 0);
        // }
        $this->Ln();
        //小計		

        // 		小計	            ¥4,060        $Order->getSubtotal() ? $Order->getCharge() 
            // $price10*1.1 + $price8*1.08   -------------- financially incorrect??????????????
        $this->SetFont(self::FONT_SJIS, 'B', 9); //8
        $this->Cell(($this->widthCellByFront[0] + $this->widthCellByFront[1]), 7, '', 0, 0, 'C', 0);
        $this->Cell(($this->widthCellByFront[2] + $this->widthCellByFront[3]), 7, '小計', 1, 0, 'C', 0);
        $this->Cell($this->widthCellByFront[4], 7, $this->getPriceFilter($price10*1.1 + $price8*1.08), 1, 0, 'R', 0);
        $this->Ln();
        // 10％対象値引き			¥-300
        // Discount   ----------   $Order->getDiscount()
        $this->SetFont(self::FONT_SJIS, '', 8); //7
        $this->Cell(($this->widthCellByFront[0] + $this->widthCellByFront[1]), 7, '', 0, 0, 'C', 0);
        $this->Cell(($this->widthCellByFront[2] + $this->widthCellByFront[3]), 7, '10％対象値引き', 1, 0, 'C', 0);
        //calculate discount amount
        //if the total amount exceeds $price10*1.1 that is total price + tax for 10% , discount will be $price10*1.1 which is its max val
        $discount10 = 0;
        $discount8 = 0;
        if ($Order->getDiscount() > $price10 * 1.1) {
            $discount10 = 0 - $price10 * 1.1;
            $discount8 =  $price10 * 1.1 - $Order->getDiscount();
        } else {
            $discount10 = 0 - $Order->getDiscount();
            $discount8 = 0;
        }
        
        $this->SetTextColor(255, 0, 0);
        $this->Cell($this->widthCellByFront[4], 7, $discount10 == 0 ? '' : $this->getPriceFilter($discount10), 1, 0, 'R', 0);
        $this->Ln();
        $this->SetTextColor(0, 0, 0);
        // 8％対象値引き			
        // manually calculated as above
        $this->Cell(($this->widthCellByFront[0] + $this->widthCellByFront[1]), 7, '', 0, 0, 'C', 0);
        $this->Cell(($this->widthCellByFront[2] + $this->widthCellByFront[3]), 7, '8％対象値引き', 1, 0, 'C', 0);
        $this->SetTextColor(255, 0, 0);
        $this->Cell($this->widthCellByFront[4], 7, $discount8 == 0 ? '' : $this->getPriceFilter($discount8), 1, 0, 'R', 0);
        $this->Ln();
        //送料（税込１０％）
        $this->SetTextColor(0, 0, 0);        
        $this->Cell(($this->widthCellByFront[0] + $this->widthCellByFront[1]), 7, '', 0, 0, 'C', 0);
        $this->Cell(($this->widthCellByFront[2] + $this->widthCellByFront[3]), 7, '送料(税込10%)', 1, 0, 'C', 0);
        // $this->SetTextColor(255, 0, 0);//this color is red
        $this->Cell($this->widthCellByFront[4], 7, $Order->getDeliveryFeeTotal() == 0 ? '' : $this->getPriceFilter($Order->getDeliveryFeeTotal()), 1, 0, 'R', 0);
        $this->Ln();

        //total payment   合計     $Order->getCharge() - $Order->getDiscount() ------  $Order->getPaymentTotal      Without Delivery fee 
        //-------------    $price10*1.1 + $price8*1.08 + $discount10 + $discount8 ------------- 
        //----------- this is different from getPaymentTotal(), --------- reason ---- delivery fee*0.1 that is 10% tax for delivery fee is not included here
        $this->SetTextColor(0, 0, 0);
        $this->SetFont(self::FONT_SJIS, 'B', 9); //8
        $this->Cell(($this->widthCellByFront[0] + $this->widthCellByFront[1]), 7, '', 0, 0, 'C', 0);
        $this->Cell(($this->widthCellByFront[2] + $this->widthCellByFront[3]), 7, '合計', 1, 0, 'C', 0);
        $this->Cell($this->widthCellByFront[4], 7, $this->getPriceFilter($price10*1.1 + $price8*1.08 + $discount10 + $discount8+$Order->getDeliveryFeeTotal()), 1, 0, 'R', 0);
        $this->Ln();

        // フォント情報の復元
        $this->restoreFont();
    }

    protected function getNumberFromPrice($str)
    {
        $str = str_replace($str, ",", "");
        $str = str_replace($str, ",", "");
        return $str * 1;
    }

    /**
     * PDFへのテキスト書き込み
     *
     * @param int    $x     X座標
     * @param int    $y     Y座標
     * @param string $text  テキスト
     * @param int    $size  フォントサイズ
     * @param string $style フォントスタイル
     */
    protected function lfText($x, $y, $text, $size = 0, $style = '')
    {
        // 退避
        $bakFontStyle = $this->FontStyle;
        $bakFontSize = $this->FontSizePt;

        $this->SetFont('', $style, $size);
        // $this->Text($x + $this->baseOffsetX, $y + $this->baseOffsetY, $text);
        $this->Text($x + $this->baseOffsetX, $y + $this->baseOffsetY, $text);

        // 復元
        $this->SetFont('', $bakFontStyle, $bakFontSize);
    }

    /**
     * Colored table.
     *
     * TODO: 後の列の高さが大きい場合、表示が乱れる。
     *
     * @param array $header 出力するラベル名一覧
     * @param array $data   出力するデータ
     * @param array $w      出力するセル幅一覧
     */
    protected function setFancyTable($header, $data, $w)
    {
        // フォント情報のバックアップ
        $this->backupFont();

        // 開始座標の設定
        $this->setBasePosition(0, 149);

        // Colors, line width and bold font
        $this->SetFillColor(216, 216, 216);
        $this->SetTextColor(0);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont(self::FONT_SJIS, 'B', 8);
        $this->SetFont('', 'B');

        // Header
        $this->Cell(5, 7, '', 0, 0, '', 0, '');
        $count = count($header);
        for ($i = 0; $i < $count; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();

        // Color and font restoration
        $this->SetFillColor(235, 235, 235);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;
        $h = 4;
        foreach ($data as $row) {
            // 行のの処理
            $i = 0;
            $h = 4;
            $this->Cell(5, $h, '', 0, 0, '', 0, '');

            // Cellの高さを保持
            $cellHeight = 0;
            foreach ($row as $col) {
                // 列の処理
                // TODO: 汎用的ではない処理。この指定は呼び出し元で行うようにしたい。
                // テキストの整列を指定する
                $align = ($i == 0) ? 'L' : 'R';

                // セル高さが最大値を保持する
                if ($h >= $cellHeight) {
                    $cellHeight = $h;
                }

                // 最終列の場合は次の行へ移動
                // (0: 右へ移動(既定)/1: 次の行へ移動/2: 下へ移動)
                $ln = ($i == (count($row) - 1)) ? 1 : 0;

                $this->MultiCell(
                    $w[$i],             // セル幅
                    $cellHeight,        // セルの最小の高さ
                    $col,               // 文字列
                    1,                  // 境界線の描画方法を指定
                    $align,             // テキストの整列
                    $fill,              // 背景の塗つぶし指定
                    $ln                 // 出力後のカーソルの移動方法
                );
                $h = $this->getLastH();

                ++$i;
            }
            $fill = !$fill;
        }
        $this->Cell(5, $h, '', 0, 0, '', 0, '');
        $this->Cell(array_sum($w), 0, '', 'T');
        $this->SetFillColor(255);

        // フォント情報の復元
        $this->restoreFont();
    }

    protected function setFancyTableByFront($header, $data, $w)
    {
        // フォント情報のバックアップ
        $this->backupFont();

        // 開始座標の設定
        $this->setBasePosition(0, 100);

        // Colors, line width and bold font
        $this->SetFillColor(216, 216, 216);
        $this->SetTextColor(0);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont(self::FONT_SJIS, 'B', 8);
        $this->SetFont('', 'B');

        // Header
        // $this->Cell(5, 7, '', 0, 0, '', 0, '');
        $count = count($header);
        for ($i = 0; $i < $count; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();

        // Color and font restoration
        $this->SetFillColor(235, 235, 235);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;
        $h = 4;
        foreach ($data as $row) {
            // 行のの処理
            $i = 0;
            $h = 4;
            // $this->Cell(5, $h, '', 0, 0, '', 0, '');

            // Cellの高さを保持
            $cellHeight = 0;
            foreach ($row as $col) {
                // 列の処理
                // TODO: 汎用的ではない処理。この指定は呼び出し元で行うようにしたい。
                // テキストの整列を指定する
                $align = ($i == 0) ? 'L' : 'R';

                // セル高さが最大値を保持する
                if ($h >= $cellHeight) {
                    $cellHeight = $h;
                }

                // 最終列の場合は次の行へ移動
                // (0: 右へ移動(既定)/1: 次の行へ移動/2: 下へ移動)
                $ln = ($i == (count($row) - 1)) ? 1 : 0;

                $this->MultiCell(
                    $w[$i],             // セル幅
                    $cellHeight,        // セルの最小の高さ
                    $col,               // 文字列
                    1,                  // 境界線の描画方法を指定
                    $align,             // テキストの整列
                    $fill,              // 背景の塗つぶし指定
                    $ln                 // 出力後のカーソルの移動方法
                );
                $h = $this->getLastH();

                ++$i;
            }
            // $fill = !$fill;
        }
        $this->Cell(5, $h, '', 0, 0, '', 0, '');
        $this->Cell(array_sum($w), 0, '', 'T');
        $this->SetFillColor(255);

        // フォント情報の復元
        $this->restoreFont();
    }

    /**
     * 基準座標を設定する.
     *
     * @param int $x
     * @param int $y
     */
    protected function setBasePosition($x = null, $y = null)
    {
        // 現在のマージンを取得する
        $result = $this->getMargins();

        // 基準座標を指定する
        $actualX = is_null($x) ? $result['left'] : $x;
        $this->SetX($actualX);
        $actualY = is_null($y) ? $result['top'] : $y;
        $this->SetY($actualY);
    }

    /**
     * データが設定されていない場合にデフォルト値を設定する.
     *
     * @param array $formData
     */
    protected function setDefaultData(array &$formData)
    {
        $defaultList = array(
            'title' => $this->app->trans('admin.plugin.receipt_pdf.title.default'),
            'message1' => $this->app->trans('admin.plugin.receipt_pdf.message1.default'),
            'message2' => $this->app->trans('admin.plugin.receipt_pdf.message2.default'),
            'message3' => $this->app->trans('admin.plugin.receipt_pdf.message3.default'),
        );
        foreach ($defaultList as $key => $value) {
            if (is_null($formData[$key])) {
                $formData[$key] = $value;
            }
        }
    }

    /**
     * Font情報のバックアップ.
     */
    protected function backupFont()
    {
        // フォント情報のバックアップ
        $this->bakFontFamily = $this->FontFamily;
        $this->bakFontStyle = $this->FontStyle;
        $this->bakFontSize = $this->FontSizePt;
    }

    /**
     * Font情報の復元.
     */
    protected function restoreFont()
    {
        $this->SetFont($this->bakFontFamily, $this->bakFontStyle, $this->bakFontSize);
    }

    /**
     * 課税対象の明細の合計金額を返す.
     * 商品合計 + 送料 + 手数料 + 値引き(課税).
     * ※src\Eccube\Entity\Order.phpから移植
     */
    public function getTaxableTotal($Order)
    {
        $total = 0;

        foreach ($this->getTaxableItems($Order) as $Item) {
            $total += $Item->getTotalPrice();
        }

        $total += $Order->getDeliveryFeeTotal() + $Order->getCharge() - $Order->getDiscount();

        return $total;
    }

    /**
     * 課税対象の明細を返す.
     * ※src\Eccube\Entity\Order.phpから移植
     *
     * @return array
     */
    public function getTaxableItems($Order)
    {
        $Items = [];

        foreach ($Order->getOrderDetails() as $Item) {
            // OrderDetailにTaxTypeフィールドが存在しないためコメントアウト
            // if ($Item->getTaxType()->getId() == TaxType::TAXATION) {
            $Items[] = $Item;
            // }
        }

        return $Items;
    }

    /**
     * 課税対象の明細の合計金額を、税率ごとに集計する.
     * ※src\Eccube\Entity\Order.phpから移植
     *
     * @return array
     */
    public function getTaxableTotalByTaxRate($Order)
    {
        $total = [];

        foreach ($this->getTaxableItems($Order) as $Item) {
            $totalPrice = $Item->getTotalPrice();
            $taxRate = $Item->getTaxRate();
            $total[$taxRate] = isset($total[$taxRate])
                ? $total[$taxRate] + $totalPrice
                : $totalPrice;
        }

        // 送料分の税込金額を計上
        $taxRatePostage = $this->getTaxRate($Order);
        $total[$taxRatePostage] = isset($total[$taxRatePostage])
            ? $total[$taxRatePostage] + $Order->getDeliveryFeeTotal()
            : $Order->getDeliveryFeeTotal();

        // 手数料分の税込金額を計上
        $taxRatePostage = $this->getTaxRate($Order);
        $total[$taxRatePostage] = isset($total[$taxRatePostage])
            ? $total[$taxRatePostage] + $Order->getCharge()
            : $Order->getCharge();

        // 値引き分の税込金額を計上
        $taxRatePostage = $this->getTaxRate($Order);
        $total[$taxRatePostage] = isset($total[$taxRatePostage])
            ? $total[$taxRatePostage] + ($Order->getDiscount() * -1)
            : ($Order->getDiscount() * -1);

        krsort($total);

        return $total;
    }

    /**
     * 課税対象の明細の消費税合計金額を、税率ごとに集計する.
     * ※src\Eccube\Entity\Order.phpから移植し一部修正
     *
     * @return array
     */
    public function getTaxTotalByTaxRate($Order)
    {
        $total = [];

        foreach ($this->getTaxableItems($Order) as $Item) {
            $totalTax = ($Item->getPriceIncTax() - $Item->getPrice()) * $Item->getQuantity();
            $taxRate = $Item->getTaxRate();
            $total[$taxRate] = isset($total[$taxRate])
                ? $total[$taxRate] + $totalTax
                : $totalTax;
        }

        // 送料分の消費税を計上
        $taxRatePostage = $this->getTaxRate($Order);
        $tax = $this->calcTax($Order->getDeliveryFeeTotal(), $taxRatePostage, \Eccube\Entity\Master\Taxrule::ROUND);
        $total[$taxRatePostage] = isset($total[$taxRatePostage])
            ? $total[$taxRatePostage] + $tax
            : $tax;

        // 手数料分の消費税を計上
        $taxRatePostage = $this->getTaxRate($Order);
        $tax = $this->calcTax($Order->getCharge(), $taxRatePostage, \Eccube\Entity\Master\Taxrule::ROUND);
        $total[$taxRatePostage] = isset($total[$taxRatePostage])
            ? $total[$taxRatePostage] + $tax
            : $tax;

        // 値引き分の消費税を計上
        $taxRatePostage = $this->getTaxRate($Order);
        $tax = $this->calcTax($Order->getDiscount(), $taxRatePostage, \Eccube\Entity\Master\Taxrule::ROUND);
        $total[$taxRatePostage] = isset($total[$taxRatePostage])
            ? $total[$taxRatePostage] + ($tax * -1)
            : ($tax * -1);

        krsort($total);

        return $total;
    }

    /**
     * 明細が軽減税率対象かどうかを返す.
     *
     * 受注作成時点での標準税率と比較し, 異なれば軽減税率として判定する.
     * ※src\Eccube\Twig\Extension\TaxExtension.phpから移植
     *
     * @param null $OrderItem
     * @return bool
     */
    public function isReducedTaxRate($OrderItem = null)
    {
        if (null === $OrderItem) {
            return false;
        }

        $Order = $OrderItem->getOrder();

        $qb = $this->taxRuleRepository->createQueryBuilder('t');
        try {
            $TaxRule = $qb
                ->where('t.Product IS NULL AND t.ProductClass IS NULL AND t.apply_date < :apply_date')
                ->orderBy('t.apply_date', 'DESC')
                ->setParameter('apply_date', $Order->getCreateDate())
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (\Exception $e) {
            return false;
        }

        return $TaxRule && $TaxRule->getTaxRate() != $OrderItem->getTaxRate();
    }


    /**
     * 受注作成時点での標準税率を取得する.
     * ※src\Eccube\Twig\Extension\TaxExtension.phpから移植し、一部修正・・・消費税額が取得したかったため
     *
     * @param null $Order
     * @return double 税率(%)
     */
    public function getTaxRate($Order = null)
    {
        if (null === $Order) {
            return 0;
        }

        // $Order = $OrderItem->getOrder();
        $qb = $this->taxRuleRepository->createQueryBuilder('t');
        $TaxRule = $qb
            ->where('t.Product IS NULL AND t.ProductClass IS NULL AND t.apply_date < :apply_date')
            ->orderBy('t.apply_date', 'DESC')
            ->setParameter('apply_date', $Order->getCreateDate())
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
        return $TaxRule->getTaxRate();
    }

    /**
     * 税金額を計算する(税込金額から)
     * ※src\Eccube\Service\TaxRuleService.phpから移植し、一部修正
     *
     * @param  int    $price     計算対象の金額（税込）
     * @param  int    $taxRate   税率(%単位)
     * @param  int    $calcRule  端数処理
     * @param  int    $taxAdjust 調整額
     * @return double 税金額
     */
    public function calcTax($price, $taxRate, $calcRule, $taxAdjust = 0)
    {
        $tax = $price * $taxRate / (100 + $taxRate);
        $roundTax = $this->roundByCalcRule($tax, $calcRule);

        return $roundTax + $taxAdjust;
    }

    /**
     * 課税規則に応じて端数処理を行う
     * ※src\Eccube\Service\TaxRuleService.phpから移植
     * 
     * @param  float|integer $value    端数処理を行う数値
     * @param  integer       $calcRule 課税規則
     * @return double        端数処理後の数値
     */
    public function roundByCalcRule($value, $calcRule)
    {
        switch ($calcRule) {
                // 四捨五入
            case \Eccube\Entity\Master\Taxrule::ROUND:
                $ret = round($value);
                break;
                // 切り捨て
            case \Eccube\Entity\Master\Taxrule::FLOOR:
                $ret = floor($value);
                break;
                // 切り上げ
            case \Eccube\Entity\Master\Taxrule::CEIL:
                $ret = ceil($value);
                break;
                // デフォルト:切り上げ
            default:
                $ret = ceil($value);
                break;
        }

        return $ret;
    }

    /**
     * 金額出力用文字列の生成を行う.
     * ※src\Eccube\Twig\Extension\EccubeExtension.phpから移植
     *
     * @return string
     */
    public function getPriceFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = '￥' . $price;

        return $price;
    }
}
