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
use Plugin\MailMagazine\Entity\MailMagazineSendHistory;
use Plugin\MailMagazine\Entity\MailMagazineTemplate;
use Plugin\MailMagazine\Service\MailMagazineService;
use Plugin\MailMagazine\Util\Version;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class MailMagazineController.
 */
class MailMagazineController
{
    /**
     * 配信内容設定検索画面を表示する.
     * 左ナビゲーションの選択はGETで遷移する.
     *
     * @param Application $app
     * @param Request     $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Application $app, Request $request)
    {
        $session = $request->getSession();
        $page_no = $request->get('page_no');
        $pageMaxis = $app['eccube.repository.master.page_max']->findAll();
        $page_max = $app['config']['default_page_count'];

        $pagination = null;
        $searchForm = $app['form.factory']
            ->createBuilder('mail_magazine')
            ->getForm();

        if ('POST' === $request->getMethod()) {
            $searchForm->handleRequest($request);
            $searchData = array();
            if ($searchForm->isValid()) {
                $searchData = $searchForm->getData();
            }

            // sessionのデータ保持
            if (Version::isSupportNewSession()) {
                // Change new session rule
                $viewData = \Eccube\Util\FormUtil::getViewData($searchForm);
                $session->set('plugin.mailmagazine.search', $viewData);
            } else {
                $session->set('plugin.mailmagazine.search', $searchData);
            }

            // 検索ボタンクリック時の処理
            $app['eccube.plugin.mail_magazine.repository.mail_magazine_customer']->setApplication($app);
            $qb = $app['eccube.plugin.mail_magazine.repository.mail_magazine_customer']
                ->getQueryBuilderBySearchData($searchData);

            $pagination = $app['paginator']()->paginate(
                $qb,
                empty($searchData['pageno']) ? 1 : $searchData['pageno'],
                $page_max
            );
        } else {
            if (is_null($page_no)) {
                // sessionを削除
                $session->remove('plugin.mailmagazine.search');
            } else {
                // pagingなどの処理
                $searchData = $session->get('plugin.mailmagazine.search');
                if (!is_null($searchData)) {
                    $pcount = $request->get('page_max');
                    $page_max = empty($pcount) ? $page_max : $pcount;

                    if (Version::isSupportNewSession()) {
                        $searchData = \Eccube\Util\FormUtil::submitAndGetData($searchForm, $searchData);
                    }

                    $app['eccube.plugin.mail_magazine.repository.mail_magazine_customer']->setApplication($app);
                    $qb = $app['eccube.plugin.mail_magazine.repository.mail_magazine_customer']
                        ->getQueryBuilderBySearchData($searchData);

                    $pagination = $app['paginator']()->paginate(
                        $qb,
                        $page_no,
                        $page_max
                    );

                    if (!Version::isSupportNewSession()) {
                        if (isset($searchData['sex']) && (count($searchData['sex']) > 0)) {
                            $sex_ids = array();
                            foreach ($searchData['sex'] as $Sex) {
                                $sex_ids[] = $Sex->getId();
                            }
                            $searchData['sex'] = $app['eccube.repository.master.sex']
                                ->findBy(array('id' => $sex_ids));
                        }

                        if (isset($searchData['pref'])) {
                            $searchData['pref'] = $app['eccube.repository.master.pref']
                                ->find($searchData['pref']->getId());
                        }

                        if (isset($searchData['pagemax'])) {
                            $searchData['pagemax'] = $app['eccube.repository.master.page_max']
                                ->find($searchData['pagemax']->getId());
                        }

                        $searchForm->setData($searchData);
                    }
                }
            }
        }

        return $app->render(
            'MailMagazine/Resource/template/admin/index.twig',
            array('searchForm' => $searchForm->createView(),
                'pagination' => $pagination,
                'pageMaxis' => $pageMaxis,
                'page_count' => $page_max,
            )
        );
    }

    /**
     * テンプレート選択
     * RequestがPOST以外の場合はBadRequestHttpExceptionを発生させる.
     *
     * @param Application $app
     * @param Request     $request
     * @param string      $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function select(Application $app, Request $request, $id = null)
    {
        /** @var MailMagazineTemplate $Template */
        $Template = null;

        // POSTでない場合は終了する
        if ('POST' !== $request->getMethod()) {
            throw new BadRequestHttpException();
        }

        // Formの取得
        $form = $app['form.factory']
            ->createBuilder('mail_magazine', null)
            ->getForm();

        $form->handleRequest($request);

        // テンプレート選択によるPOSTの場合はテンプレートからデータを取得する
        if ($request->get('mode') == 'select') {
            $newTemplate = $form->get('template')->getData();
            $data = $form->getData();
            $form = $app['form.factory']->createBuilder('mail_magazine', null)->getForm();
            $form->setData($data);

            if ($id) {
                // テンプレート「無し」が選択された場合は、選択されたテンプレートのデータを取得する
                $Template = $app['eccube.plugin.mail_magazine.repository.mail_magazine']->find($id);

                if (is_null($Template)) {
                    throw new NotFoundHttpException();
                }

                // テンプレートを表示する
                $newSubject = $Template->getSubject();
                $newBody = $Template->getBody();
                $newHtmlBody = $Template->getHtmlBody();

                $form->get('template')->setData($newTemplate);
                $form->get('subject')->setData($newSubject);
                $form->get('body')->setData($newBody);
                $form->get('htmlBody')->setData($newHtmlBody);
            } else {
                // テンプレート「無し」が選択された場合は、フォームをクリアする
                $form->get('subject')->setData('');
                $form->get('body')->setData('');
                $form->get('htmlBody')->setData('');
            }
        }

        return $app->render('MailMagazine/Resource/template/admin/template_select.twig', array(
                'form' => $form->createView(),
                'id' => $id,
        ));
    }

    /**
     * 確認画面の表示
     * RequestがPOST以外の場合はBadRequestHttpExceptionを発生させる.
     *
     * @param Application $app
     * @param Request     $request
     * @param string      $id
     */
    public function confirm(Application $app, Request $request, $id = null)
    {
        // POSTでない場合は終了する
        if ('POST' !== $request->getMethod()) {
            throw new BadRequestHttpException();
        }

        // Formの作成
        $builder = $app['form.factory']->createBuilder('mail_magazine', null);

        // ------------------------------------------------
        // メルマガテンプレート用にvalidationを付与するため
        // 項目を削除、追加する
        // ------------------------------------------------
        // Subject
        $builder->remove('subject');
        $builder->add('subject', 'text', array(
                'label' => 'Subject',
                'required' => true,
                'constraints' => array(
                        new NotBlank(),
                ),
        ));

        // 本文
        $builder->remove('body');
        $builder->add('body', 'textarea', array(
                'label' => '本文',
                'required' => true,
                'constraints' => array(
                        new NotBlank(),
                ),
        ));

        $form = $builder->getForm();
        $form->handleRequest($request);

        // Formのデータを取得する
        $formData = $form->getData();

        // validationを実行する
        if (!$form->isValid()) {
            // エラーの場合はテンプレート選択画面に遷移する
            return $app->render('MailMagazine/Resource/template/admin/template_select.twig', array(
                    'form' => $form->createView(),
                    'new_subject' => $formData['subject'],
                    'new_body' => $formData['body'],
                    'new_htmlBody' => $formData['htmlBody'],
                    'id' => $id,
            ));
        }

        /** @var MailMagazineService $service */
        $service = $this->getMailMagazineService($app);

        return $app->render('MailMagazine/Resource/template/admin/confirm.twig', array(
                'form' => $form->createView(),
                'subject_itm' => $form['subject']->getData(),
                'body_itm' => $form['body']->getData(),
                'htmlBody_itm' => $form['htmlBody']->getData(),
                'id' => $id,
                'testMailTo' => $service->getAdminEmail(),
        ));
    }

    /**
     * 配信前処理
     * 配信履歴データを作成する.
     *
     * @param Application $app
     * @param Request     $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function prepare(Application $app, Request $request)
    {
        if ('POST' != $request->getMethod()) {
            throw new BadRequestHttpException();
        }

        log_info('メルマガ配信前処理開始');

        // Formを取得する
        $form = $app['form.factory']
            ->createBuilder('mail_magazine', null)
            ->getForm();
        $form->handleRequest($request);
        $data = $form->getData();

        if (!$form->isValid()) {
            throw new BadRequestHttpException();
        }

        // タイムアウトしないようにする
        set_time_limit(0);

        /** @var MailMagazineService $service */
        $service = $this->getMailMagazineService($app);

        // 配信履歴を登録する
        $sendId = $service->createMailMagazineHistory($data);
        if (is_null($sendId)) {
            $app->addError('admin.plugin.mailmagazine.send.register.failure', 'admin');
        }

        // フラッシュスコープにIDを保持してリダイレクト後に送信処理を開始できるようにする
        $app['session']->getFlashBag()->add('eccube.plugin.mailmagazine.history', $sendId);

        log_info('メルマガ配信前処理完了', array('sendId' => $sendId));

        // 配信履歴画面に遷移する
        return $app->redirect($app->url('plugin_mail_magazine_history'));
    }

    /**
     * 配信処理
     * 配信終了後配信履歴に遷移する
     * RequestがAjaxかつPOSTでなければBadRequestHttpExceptionを発生させる.
     *
     * @param Application $app
     * @param Request     $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function commit(Application $app, Request $request)
    {
        // Ajax/POSTでない場合は終了する
        if (!$request->isXmlHttpRequest() || 'POST' !== $request->getMethod()) {
            throw new BadRequestHttpException();
        }

        // タイムアウトしないようにする
        set_time_limit(0);

        // デフォルトの設定ではメールをスプールしてからレスポンス後にメールを一括で送信する。
        // レスポンス後に一括送信した場合、メールのエラーをハンドリングできないのでスプールしないように設定。
        $app['swiftmailer.use_spool'] = false;

        $id = $request->get('id');
        $offset = (int) $request->get('offset', 0);
        $max = (int) $request->get('max', 100);

        log_info('メルマガ配信処理開始', array('id' => $id, 'offset' => $offset, 'max' => $max));

        /** @var MailMagazineService $service */
        $service = $this->getMailMagazineService($app);
        /** @var MailMagazineSendHistory $sendHistory */
        $sendHistory = $service->sendrMailMagazine($id, $offset, $max);

        if ($sendHistory->isComplete()) {
            $service->sendMailMagazineCompleateReportMail();
        }

        log_info('メルマガ配信処理完了', array('id' => $id, 'offset' => $offset, 'max' => $max));

        return $app->json(array(
            'status' => true,
            'id' => $id,
            'total' => $sendHistory->getSendCount(),
            'count' => $sendHistory->getCompleteCount(),
        ));
    }

    /**
     * テストメール送信
     *
     * @param Application $app
     * @param Request     $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function sendTest(Application $app, Request $request)
    {
        // Ajax/POSTでない場合は終了する
        if (!$request->isXmlHttpRequest() || 'POST' !== $request->getMethod()) {
            throw new BadRequestHttpException();
        }

        log_info('テストメール配信処理開始');

        $data = $request->request->all();
        $this->getMailMagazineService($app)->sendTestMail($data);

        log_info('テストメール配信処理完了');

        return $app->json(array('status' => true));
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
}
