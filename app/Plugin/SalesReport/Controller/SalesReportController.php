<?php
/*
 * This file is part of the Sales Report plugin
 *
 * Copyright (C) 2016 LOCKON CO.,LTD. All Rights Reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\SalesReport\Controller;

use Eccube\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Class SalesReportController.
 */
class SalesReportController
{
    /**
     * 期間別集計.
     *
     * @param Application $app
     * @param Request     $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function term(Application $app, Request $request)
    {
        return $this->response($app, $request, 'term');
    }

    /**
     * 商品別集計.
     *
     * @param Application $app
     * @param Request     $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function product(Application $app, Request $request)
    {
        return $this->response($app, $request, 'product');
    }

    /**
     * 年代別集計.
     *
     * @param Application $app
     * @param Request     $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function age(Application $app, Request $request)
    {
        return $this->response($app, $request, 'age');
    }

    /**
     * 商品CSVの出力.
     *
     * @param Application $app
     * @param Request     $request
     * @param string      $type
     *
     * @return StreamedResponse
     */
    public function export(Application $app, Request $request, $type)
    {
        set_time_limit(0);
        $response = new StreamedResponse();
        $session = $request->getSession();
        if ($session->has('eccube.admin.plugin.sales_report.export')) {
            $searchData = $session->get('eccube.admin.plugin.sales_report.export');
        } else {
            $searchData = array();
        }

        $data = array(
            'graph' => null,
            'raw' => null,
        );

        // Query data from database
        if ($searchData) {
            if ($searchData['term_end']) {
                $searchData['term_end'] = $searchData['term_end']->modify('- 1 day');
            }
            $data = $app['salesreport.service.sales_report']
                ->setReportType($type)
                ->setTerm($searchData['term_type'], $searchData)
                ->getData();
        }

        $response->setCallback(function () use ($data, $app, $request, $type) {
            //export data by type
            switch ($type) {
                case 'term':
                    $app['salesreport.service.sales_report']->exportTermCsv($data['raw'], $app['config']['csv_export_separator'], $app['config']['csv_export_encoding']);
                    break;
                case 'product':
                    $app['salesreport.service.sales_report']->exportProductCsv($data['raw'], $app['config']['csv_export_separator'], $app['config']['csv_export_encoding']);
                    break;
                case 'age':
                    $app['salesreport.service.sales_report']->exportAgeCsv($data['raw'], $app['config']['csv_export_separator'], $app['config']['csv_export_encoding']);
                    break;
                default:
                    $app['salesreport.service.sales_report']->exportTermCsv($data['raw'], $app['config']['csv_export_separator'], $app['config']['csv_export_encoding']);
            }
        });

        //set filename by type
        $now = new \DateTime();
        switch ($type) {
            case 'term':
                $filename = 'salesreport_term_'.$now->format('YmdHis').'.csv';
                break;
            case 'product':
                $filename = 'salesreport_product_'.$now->format('YmdHis').'.csv';
                break;
            case 'age':
                $filename = 'salesreport_age_'.$now->format('YmdHis').'.csv';
                break;
            default:
                $filename = 'salesreport_term_'.$now->format('YmdHis').'.csv';
        }

        $response->headers->set('Content-Type', 'application/octet-stream;');
        $response->headers->set('Content-Disposition', 'attachment; filename='.$filename);
        $response->send();
        log_info('商品CSV出力ファイル名', array($filename));

        return $response;
    }

    /**
     * direct by report type(default term).
     *
     * @param Application $app
     * @param Request     $request
     * @param null        $reportType
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function response(Application $app, Request $request, $reportType = null)
    {
        $builder = $app['form.factory']
            ->createBuilder('sales_report');
        if (!is_null($reportType) && $reportType !== 'term') {
            $builder->remove('unit');
        }
        /* @var $form \Symfony\Component\Form\Form */
        $form = $builder->getForm();
        $form->handleRequest($request);

        $data = array(
            'graph' => null,
            'raw' => null,
        );

        $options = array();

        if (!is_null($reportType) && $form->isValid()) {
            $session = $request->getSession();
            $searchData = $form->getData();
            $searchData['term_type'] = $form->get('term_type')->getData();
            $session->set('eccube.admin.plugin.sales_report.export', $searchData);
            $termType = $form->get('term_type')->getData();
            $data = $app['salesreport.service.sales_report']
                ->setReportType($reportType)
                ->setTerm($termType, $searchData)
                ->getData();
            $options = $this->getRenderOptions($reportType, $searchData);
        }

        $template = is_null($reportType) ? 'term' : $reportType;
        log_info('SalesReport Plugin : render ', array('template' => $template));

        return $app->render(
            'SalesReport/Resource/template/admin/'.$template.'.twig',
            array(
                'form' => $form->createView(),
                'graphData' => json_encode($data['graph']),
                'rawData' => $data['raw'],
                'type' => $reportType,
                'options' => $options,
            )
        );
    }

    /**
     * get option params for render.
     *
     * @param $termType
     * @param $searchData
     *
     * @return array options
     */
    private function getRenderOptions($termType, $searchData)
    {
        $options = array();

        switch ($termType) {
            case 'term':
                // 期間の集計単位
                if (isset($searchData['unit'])) {
                    $options['unit'] = $searchData['unit'];
                }
                break;
            default:
                // no option
                break;
        }

        return $options;
    }
}
