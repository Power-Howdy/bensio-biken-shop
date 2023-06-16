<?php

namespace Plugin\EccubePaymentLite3\Controller\Admin\Order;

use Eccube\Application;
use Eccube\Common\Constant;
use Eccube\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RegularOrderController extends AbstractController
{

    public function index(Application $app, Request $request, $page_no = null) {
        $softDeleteFilter = $app['orm.em']->getFilters()->getFilter('soft_delete');
        $softDeleteFilter->setExcludes(array(
            'Eccube\Entity\Order'
        ));
        $session = $request->getSession();

        $searchForm = $app['form.factory']
            ->createBuilder('admin_search_regular_order')
            ->getForm();

        $pagination = array();
        $nextOrderDate = array();
        $latestStatus = array();

        $disps = $app['eccube.repository.master.disp']->findAll();
        $pageMaxis = $app['eccube.repository.master.page_max']->findAll();
        $page_count = $app['config']['default_page_count'];
        $active = false;

        if ('POST' === $request->getMethod()) {

            $searchForm->handleRequest($request);

            if ($searchForm->isValid()) {
                $searchData = $searchForm->getData();

                // paginator
                $qb = $app['eccube.plugin.epsilon.repository.regular_order']->getQueryBuilderBySearchDataForAdmin($searchData);

                $page_no = 1;
                $pagination = $app['paginator']()->paginate(
                    $qb,
                    $page_no,
                    $page_count
                );

                // sessionのデータ保持
                $session->set('eccube.plugin.epsilon.admin.regular_order.search', $searchData);
                $session->set('eccube.plugin.epsilon.admin.regular_order.search.page_no', $page_no);
                $active = true;
            }
        } else {
            if (is_null($page_no)) {
                // sessionを削除
                $session->remove('eccube.plugin.epsilon.admin.regular_order.search');
                $session->remove('eccube.plugin.epsilon.admin.regular_order.search.page_no');

            } else {
                // pagingなどの処理
                $searchData = $session->get('eccube.plugin.epsilon.admin.regular_order.search');
                if (is_null($page_no)) {
                    $page_no = intval($session->get('eccube.plugin.epsilon.admin.regular_order.search.page_no'));
                } else {
                    $session->set('eccube.plugin.epsilon.admin.regular_order.search.page_no', $page_no);
                }

                if (!is_null($searchData)) {

                    // 表示件数
                    $pcount = $request->get('page_count');
                    $page_count = empty($pcount) ? $page_count : $pcount;

                    $qb = $app['eccube.plugin.epsilon.repository.regular_order']->getQueryBuilderBySearchDataForAdmin($searchData);
                    $pagination = $app['paginator']()->paginate(
                        $qb,
                        $page_no,
                        $page_count
                    );

                    // セッションから検索条件を復元
                    if (!empty($searchData['status'])) {
                        $searchData['status'] = $app['eccube.repository.master.order_status']->find($searchData['status']);
                    }
                    if (count($searchData['sex']) > 0) {
                        $sex_ids = array();
                        foreach ($searchData['sex'] as $Sex) {
                            $sex_ids[] = $Sex->getId();
                        }
                        $searchData['sex'] = $app['eccube.repository.master.sex']->findBy(array('id' => $sex_ids));
                    }
                    $searchForm->setData($searchData);
                    $active = true;
                }
            }
        }

        // 次回定期受注日を取得
        foreach ($pagination as $RegularOrder) {
            $LastOrder = $RegularOrder->getLastOrder();
            $nextOrderDate[$RegularOrder->getId()] = $app['eccube.plugin.epsilon.service.regular']->getNextOrderDate($RegularOrder->getPayment(), $LastOrder->getCreateDate());
            //$nextOrderDate[$RegularOrder->getId()] = null;
        }

        return $app->render('EccubePaymentLite3/Twig/admin/Order/regular_index.twig', array(
            'searchForm' => $searchForm->createView(),
            'pagination' => $pagination,
            'nextOrderDate' => $nextOrderDate,
            'latestStatus' => $latestStatus,
            'disps' => $disps,
            'pageMaxis' => $pageMaxis,
            'page_no' => $page_no,
            'page_count' => $page_count,
            'active' => $active,
        ));
    }

    /**
     * 定期受注から受注を作成する.
     */
    public function add(Application $app, Request $request)
    {
        // $this->isTokenValid($app);
        $session = $request->getSession();
        $page_no = intval($session->get('eccube.plugin.epsilon.admin.regular_order.search.page_no'));
        $page_no = $page_no ? $page_no : Constant::ENABLED;

        // 対象の定期受注番号を取得
        $ids = array();
        foreach ($_GET as $key => $value) {
            $ids[] = str_replace('ids', '', $key);
        }

        // 受注を作成
        foreach ($ids as $id) {
            $app['eccube.plugin.epsilon.service.regular']->registOrder($id);
        }
        $app->addSuccess('admin.order.save.complete', 'admin');

        return $app->redirect($app->url('paylite_regular_order_page', array('page_no' => $page_no)).'?resume='.Constant::ENABLED);
    }

    /**
     * 定期受注を削除する.
     */
    public function delete(Application $app, Request $request, $id)
    {
        $this->isTokenValid($app);
        $session = $request->getSession();
        $page_no = intval($session->get('eccube.plugin.epsilon.admin.regular_order.search.page_no'));
        $page_no = $page_no ? $page_no : Constant::ENABLED;

        $RegularOrder = $app['eccube.plugin.epsilon.repository.regular_order']->find($id);

        if ($RegularOrder) {
            $RegularOrder->setDelFlg(Constant::ENABLED);
            $app['orm.em']->persist($RegularOrder);
            $app['orm.em']->flush();

            $app->addSuccess('admin.order.delete.complete', 'admin');
        } else if (Constant::VERSION >= '3.0.6') {
            $app->deleteMessage();
            return $app->redirect($app->url('paylite_regular_order'));
        }

        return $app->redirect($app->url('paylite_regular_order_page', array('page_no' => $page_no)).'?resume='.Constant::ENABLED);
    }

}
