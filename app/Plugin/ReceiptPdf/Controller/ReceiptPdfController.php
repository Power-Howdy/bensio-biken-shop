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

namespace Plugin\ReceiptPdf\Controller;

use Eccube\Application;
use Eccube\Controller\AbstractController;
use Eccube\Util\EntityUtil;
use Plugin\ReceiptPdf\Entity\ReceiptPdf;
use Plugin\ReceiptPdf\Repository\ReceiptPdfRepository;
use Plugin\ReceiptPdf\Service\ReceiptPdfService;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class ReceiptPdfController.
 */
class ReceiptPdfController extends AbstractController
{
    /**
     * 納品書の設定画面表示.
     *
     * @param Application $app
     * @param Request     $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     *
     * @throws NotFoundHttpException
     */
    public function index(Application $app, Request $request)
    {
        // requestから受注番号IDの一覧を取得する.
        $ids = $this->getIds($request);

        if (count($ids) == 0) {
            $app->addError('admin.plugin.receipt_pdf.parameter.notfound', 'admin');
            log_info('The Order cannot found!');

            return $app->redirect($app->url('admin_order'));
        }

        /* @var ReceiptPdfRepository $repos */
        $repos = $app['ReceiptPdf.repository.receipt_pdf'];

        $ReceiptPdf = $repos->find($app->user());

        if (EntityUtil::isEmpty($ReceiptPdf)) {
            $ReceiptPdf = new ReceiptPdf();
            $ReceiptPdf
                ->setTitle($app->trans('admin.plugin.receipt_pdf.title.default'))
                ->setMessage1($app->trans('admin.plugin.receipt_pdf.message1.default'))
                ->setMessage2($app->trans('admin.plugin.receipt_pdf.message2.default'))
                ->setMessage3($app->trans('admin.plugin.receipt_pdf.message3.default'))
                ->setAddressNameFlg(true);
        }

        /**
         * @var FormBuilder $builder
         */
        $builder = $app['form.factory']->createBuilder('admin_receipt_pdf', $ReceiptPdf);

        /* @var Form $form */
        $form = $builder->getForm();

        // Formへの設定
        $form->get('ids')->setData(implode(',', $ids));

        return $app->render('ReceiptPdf/Resource/template/admin/receipt_pdf.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * 作成ボタンクリック時の処理
     * 帳票のPDFをダウンロードする.
     *
     * @param Application $app
     * @param Request     $request
     *
     * @return Response
     *
     * @throws BadRequestHttpException
     */
    public function download(Application $app, Request $request)
    {
        /**
         * @var FormBuilder $builder
         */
        $builder = $app['form.factory']->createBuilder('admin_receipt_pdf');

        /* @var Form $form */
        $form = $builder->getForm();
        $form->handleRequest($request);

        // Validation
        if (!$form->isValid()) {
            log_info('The parameter is invalid!');

            return $app->render('ReceiptPdf/Resource/template/admin/receipt_pdf.twig', array(
                'form' => $form->createView(),
            ));
        }


        // サービスの取得
        /* @var ReceiptPdfService $service */
        $service = $app['ReceiptPdf.service.receipt_pdf'];

        $arrData = $form->getData();

        // 購入情報からPDFを作成する
        $status = $service->makePdf($arrData);

        // 異常終了した場合の処理
        if (!$status) {
            $app->addError('admin.plugin.receipt_pdf.download.failure', 'admin');
            log_info('Unable to create pdf files! Process have problems!');

            return $app->render('ReceiptPdf/Resource/template/admin/receipt_pdf.twig', array(
                'form' => $form->createView(),
            ));
        }

        // ダウンロードする
        $response = new Response(
            $service->outputPdf($arrData),
            200,
            array('content-type' => 'application/pdf')
        );

        // レスポンスヘッダーにContent-Dispositionをセットし、ファイル名をreceipt.pdfに指定
        if($arrData['specification_flg'] && !$arrData['receipt_flg']){
            $response->headers->set('Content-Disposition', 'attachment; filename="'.$service->getDetailName().'"');
        }elseif(!$arrData['specification_flg'] && $arrData['receipt_flg']){
            $response->headers->set('Content-Disposition', 'attachment; filename="'.$service->getReceiptName().'"');
        }elseif($arrData['specification_flg'] && $arrData['receipt_flg']){
            $response->headers->set('Content-Disposition', 'attachment; filename="tyouhyou.pdf"');
        }else{
            return $app->render('ReceiptPdf/Resource/template/admin/receipt_pdf.twig', array(
                'form' => $form->createView(),
            ));
        }
        log_info('ReceiptPdf download success!', array('Order ID' => implode(',', $this->getIds($request))));

        $isDefault = isset($arrData['default']) ? $arrData['default'] : false;
        if ($isDefault) {
            // Save input to DB
            $arrData['admin'] = $app->user();
            /* @var ReceiptPdfRepository $repos */
            $repos = $app['ReceiptPdf.repository.receipt_pdf'];
            $repos->save($arrData);
        }

        return $response;
    }

    /**
     * requestから注文番号のID一覧を取得する.
     *
     * @param Request $request
     *
     * @return array $isList
     */
    protected function getIds(Request $request)
    {
        $isList = array();

        // その他メニューのバージョン
        $queryString = $request->getQueryString();

        if (empty($queryString)) {
            return $isList;
        }

        // クエリーをparseする
        // idsX以外はない想定
        parse_str($queryString, $ary);

        foreach ($ary as $key => $val) {
            // キーが一致
            if (preg_match('/^ids\d+$/', $key)) {
                if (!empty($val) && $val == 'on') {
                    $isList[] = intval(str_replace('ids', '', $key));
                }
            }
        }

        // id順にソートする
        sort($isList);

        return $isList;
    }
    public function config(Application $app)
    {
        /**
         * @var FormBuilder $builder
         */
         $builder = $app['form.factory']->createBuilder('admin_receipt_pdf', $ReceiptPdf);

         /* @var Form $form */
         $form = $builder->getForm();
 
         // Formへの設定
         $form->get('ids')->setData(implode(',', $ids));
         
        return $app->render('ReceiptPdf/Resource/template/admin/repocustomconfig.twig', array(
            'form' => $form->createView(),
        ));
    }
}
