<?php
/*
* This file is part of EC-CUBE
*
* Copyright(c) EC-CUBE CO.,LTD. All Rights Reserved.
* https://www.ec-cube.co.jp/
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Plugin\MailMagazine\Controller;

use Eccube\Application;
use Eccube\Common\Constant;
use Eccube\Controller\AbstractController;
use Eccube\Entity\Master\Pref;
use Knp\Component\Pager\Paginator;
use Plugin\MailMagazine\Entity\MailMagazineSendHistory;
use Plugin\MailMagazine\Repository\MailMagazineSendHistoryRepository;
use Plugin\MailMagazine\Service\MailMagazineService;
use Plugin\MailMagazine\Util\MailMagazineHistoryFilePaginationSubscriber;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Doctrine\Common\Collections\ArrayCollection;

class MailMagazineHistoryController extends AbstractController
{
    public function __construct()
    {
    }

    /**
     * 配信履歴一覧.
     */
    public function index(Application $app, Request $request)
    {
        // dtb_send_historyからdel_flg = 0のデータを抽出
        // リストをView変数に突っ込む
        $pagination = null;
        $searchForm = $app['form.factory']
            ->createBuilder()
            ->getForm();
        $searchForm->handleRequest($request);
        $searchData = $searchForm->getData();

        $pageNo = $request->get('page_no');

        $qb = $app['orm.em']->createQueryBuilder();
        $qb->select('d')
            ->from("\Plugin\MailMagazine\Entity\MailMagazineSendHistory", 'd')
            ->where('d.del_flg = :delFlg')
            ->setParameter('delFlg', Constant::DISABLED)
            ->orderBy('d.start_date', 'DESC');

        $pagination = $app['paginator']()->paginate(
                $qb,
                empty($pageNo) ? 1 : $pageNo,
                empty($searchData['pagemax']) ? 10 : $searchData['pagemax']->getId()
        );

        return $app->render('MailMagazine/Resource/template/admin/history_list.twig', array(
            'pagination' => $pagination,
        ));
    }

    /**
     * プレビュー
     */
    public function preview(Application $app, Request $request, $id)
    {
        // dtb_send_historyから対象レコード抽出
        // subject/bodyを抽出し、以下のViewへ渡す
        // パラメータ$idにマッチするデータが存在するか判定
        if (!$id) {
            $app->addError('admin.plugin.mailmagazine.history.datanotfound', 'admin');

            return $app->redirect($app->url('plugin_mail_magazine_history'));
        }

        // 配信履歴を取得する
        $sendHistory = $this->getMailMagazineSendHistoryRepository($app)->find($id);

        if (is_null($sendHistory)) {
            $app->addError('admin.plugin.mailmagazine.history.datanotfound', 'admin');

            return $app->redirect($app->url('plugin_mail_magazine_history'));
        }

        return $app->render('MailMagazine/Resource/template/admin/history_preview.twig', array(
            'history' => $sendHistory,
        ));
    }

    /**
     * 配信条件を表示する.
     *
     * @param Application $app
     * @param Request     $request
     * @param unknown     $id
     *
     * @throws BadRequestHttpException
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function condition(Application $app, Request $request, $id)
    {
        // dtb_send_historyから対象レコード抽出
        // dtb_send_history.search_dataを逆シリアライズした上で、各変数をViewに渡す
        if (!$id) {
            $app->addError('admin.plugin.mailmagazine.history.datanotfound', 'admin');

            return $app->redirect($app->url('plugin_mail_magazine_history'));
        }

        // 配信履歴を取得する
        $sendHistory = $this->getMailMagazineSendHistoryRepository($app)->find($id);

        if (is_null($sendHistory)) {
            $app->addError('admin.plugin.mailmagazine.history.datanotfound', 'admin');

            return $app->redirect($app->url('plugin_mail_magazine_history'));
        }

        // DBからjsonで取得したデータをオブジェクトで再生成する
        $searchData = $searchDataArray = json_decode($sendHistory->getSearchData(), true);

        if (array_key_exists('pref', $searchDataArray) && array_key_exists('id', $searchDataArray['pref']) && is_numeric($searchDataArray['pref']['id'])) {
            $searchData['pref'] = $app['eccube.repository.master.pref']->find($searchDataArray['pref']['id']);
        } else {
            $searchData['pref'] = null;
        }

        $searchData['sex'] = new ArrayCollection();
        $searchData['customer_status'] = new ArrayCollection();

        if (array_key_exists('sex', $searchDataArray) && is_array($searchDataArray['sex'])) {
            $searchData['sex'] = $app['eccube.repository.master.sex']->findBy(
                array(
                    'id' => array_filter(
                        array_map(function ($value) {
                            if (array_key_exists('id', $value)) {
                                return $value['id'];
                            }

                            return false;
                        }, $searchDataArray['sex']
                        )
                    ),
                )
            );
        }

        if (array_key_exists('customer_status', $searchDataArray) && is_array($searchDataArray['customer_status'])) {
            $searchData['customer_status'] = $app['eccube.repository.customer_status']->findBy(
                array(
                    'id' => array_filter(
                        array_map(function ($value) {
                            if (array_key_exists('id', $value)) {
                                return $value['id'];
                            }

                            return false;
                        }, $searchDataArray['customer_status']
                        )
                    ),
                )
            );
        }

        foreach ($searchDataArray as $key => $value) {
            if (!is_array($value) || !array_key_exists('date', $value)) {
                continue;
            }
            $searchData[$key] = new \DateTime($value['date']);
        }

        // 区分値を文字列に変更する
        // 必要な項目のみ
        $displayData = $this->searchDataToDisplayData($searchData);

        return $app->render('MailMagazine/Resource/template/admin/history_condition.twig', array(
            'search_data' => $displayData,
        ));
    }

    /**
     * search_dataの配列を表示用に変換する.
     *
     * @param unknown $searchData
     */
    protected function searchDataToDisplayData($searchData)
    {
        $data = $searchData;

        // 会員種別
        $val = null;
        if (!is_null($searchData['customer_status'])) {
            if (count($searchData['customer_status']) > 0) {
                $val = implode(' ', $searchData['customer_status']);
            }
        }
        $data['customer_status'] = $val;

        // 性別
        $val = null;
        if (!is_null($searchData['sex'])) {
            if (count($searchData['sex']) > 0) {
                $val = implode(' ', $searchData['sex']);
            }
        }
        $data['sex'] = $val;

        // 誕生月
        $val = null;
        if (!is_null($searchData['birth_month'])) {
            $val = $searchData['birth_month'] + 1;
        }
        $data['birth_month'] = $val;

        return $data;
    }

    /**
     * 配信履歴を論理削除する
     * RequestがPOST以外の場合はBadRequestHttpExceptionを発生させる.
     *
     * @param Application $app
     * @param Request     $request
     * @param unknown     $id
     *
     * @throws BadRequestHttpException
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Application $app, Request $request, $id)
    {
        $this->isTokenValid($app);
        // POSTかどうか判定
        if ('POST' !== $request->getMethod()) {
            throw new BadRequestHttpException();
        }

        // パラメータ$idにマッチするデータが存在するか判定
        if (!$id) {
            throw new BadRequestHttpException();
        }

        // 配信履歴を取得する
        $sendHistory = $this->getMailMagazineSendHistoryRepository($app)->find($id);

        // 配信履歴がない場合はエラーメッセージを表示する
        if (is_null($sendHistory)) {
            $app->addError('admin.plugin.mailmagazine.history.datanotfound', 'admin');

            return $app->redirect($app->url('plugin_mail_magazine_history'));
        }

        // POSTかつ$idに対応するdtb_send_historyのレコードがあれば、del_flg = 1に設定して更新
        $sendHistory->setDelFlg(Constant::ENABLED);

        $app['orm.em']->persist($sendHistory);
        $app['orm.em']->flush($sendHistory);

        $service = $this->getMailMagazineService($app);
        $service->unlinkHistoryFiles($id);

        $app->addSuccess('admin.plugin.mailmagazine.history.delete.sucesss', 'admin');

        // メルマガテンプレート一覧へリダイレクト
        return $app->redirect($app->url('plugin_mail_magazine_history'));
    }

    public function retry(Application $app, Request $request)
    {
        // Ajax/POSTでない場合は終了する
        if (!$request->isXmlHttpRequest() || 'POST' !== $request->getMethod()) {
            throw new BadRequestHttpException();
        }

        $id = $request->get('id');

        log_info('メルマガ再試行前処理開始', array('id' => $id));

        $service = $this->getMailMagazineService($app);
        $service->markRetry($id);

        log_info('メルマガ再試行前処理完了', array('id' => $id));

        return $app->json(array('status' => true));
    }

    public function result(Application $app, Request $request)
    {
        $id = $request->get('id');
        $resultFile = $this->getMailMagazineService($app)->getHistoryFileName($id, false);
        /** @var MailMagazineSendHistory $History */
        $History = $this->getMailMagazineSendHistoryRepository($app)->find($id);

        $pageMaxis = $app['eccube.repository.master.page_max']->findAll();
        $page_count = $request->get('page_count');
        $page_count = $page_count ? $page_count : $app['config']['default_page_count'];

        $pageNo = $request->get('page_no');
        $paginator = new Paginator();
        $paginator->subscribe(new MailMagazineHistoryFilePaginationSubscriber());
        $pagination = $paginator->paginate($resultFile,
            empty($pageNo) ? 1 : $pageNo,
            $page_count,
            array('total' => $History->getCompleteCount())
        );

        return $app->render('MailMagazine/Resource/template/admin/history_result.twig', array(
            'historyId' => $id,
            'pagination' => $pagination,
            'pageMaxis' => $pageMaxis,
            'page_count' => $page_count,
        ));
    }

    /**
     * @param Application $app
     *
     * @return MailMagazineService
     */
    private function getMailMagazineService(Application $app)
    {
        return $app['eccube.plugin.mail_magazine.service.mail'];
    }

    /**
     * @param Application $app
     *
     * @return MailMagazineSendHistoryRepository
     */
    private function getMailMagazineSendHistoryRepository(Application $app)
    {
        return $app['eccube.plugin.mail_magazine.repository.mail_magazine_history'];
    }
}
