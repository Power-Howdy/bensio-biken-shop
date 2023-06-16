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
use Eccube\Controller\AbstractController;
use Plugin\MailMagazine\Entity\MailMagazineTemplate;
use Plugin\MailMagazine\Repository\MailMagazineTemplateRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class MailMagazineTemplateController extends AbstractController
{
    public function __construct()
    {
    }

    /**
     * 一覧表示.
     */
    public function index(Application $app, Request $request)
    {
        // dtb_mailmagazine_templateからdel_flg != 0のデータを引っ張る
        // 下のarrayにViewの変数名と共に突っ込む
        $templateList = $app['eccube.plugin.mail_magazine.repository.mail_magazine']->findAll();

        return $app->render('MailMagazine/Resource/template/admin/template_list.twig', array(
                'TemplateList' => $templateList,
        ));
    }

    /**
     * preview画面表示.
     *
     * @param Application $app
     * @param Request     $request
     * @param unknown     $id
     *
     * @return void|\Symfony\Component\HttpFoundation\Response
     */
    public function preview(Application $app, Request $request, $id)
    {
        // id の存在確認
        // nullであれば一覧に戻る
        if (is_null($id) || strlen($id) == 0) {
            $app->addError('admin.plugin.mailmagazine.template.data.illegalaccess', 'admin');

            // メルマガテンプレート一覧へリダイレクト
            return $app->redirect($app->url('plugin_mail_magazine_template'));
        }

        // パラメータ$idにマッチするデータが存在するか判定
        // あれば、subject/bodyを取得
        $template = $app['eccube.plugin.mail_magazine.repository.mail_magazine']->find($id);
        if (is_null($template)) {
            // データが存在しない場合はメルマガテンプレート一覧へリダイレクト
            $app->addError('admin.plugin.mailmagazine.template.data.notfound', 'admin');

            return $app->redirect($app->url('plugin_mail_magazine_template'));
        }

        // プレビューページ表示
        return $app->render('MailMagazine/Resource/template/admin/preview.twig', array(
                'Template' => $template,
        ));
    }

    /**
     * メルマガテンプレートを論理削除.
     *
     * @param Application $app
     * @param Request     $request
     * @param unknown     $id
     */
    public function delete(Application $app, Request $request, $id)
    {
        // POSTかどうか判定
        // パラメータ$idにマッチするデータが存在するか判定
        // POSTかつ$idに対応するdtb_mailmagazine_templateのレコードがあれば、del_flg = 1に設定して更新
        $this->isTokenValid($app);
        if ('POST' === $request->getMethod()) {
            // idがからの場合はメルマガテンプレート一覧へリダイレクト
            if (is_null($id) || strlen($id) == 0) {
                $app->addError('admin.plugin.mailmagazine.template.data.illegalaccess', 'admin');

                return $app->redirect($app->url('plugin_mail_magazine_template'));
            }

            // メルマガテンプレートを取得する
            $template = $app['eccube.plugin.mail_magazine.repository.mail_magazine']->find($id);

            if (is_null($template)) {
                // データが存在しない場合はメルマガテンプレート一覧へリダイレクト
                $app->addError('admin.plugin.mailmagazine.template.data.notfound', 'admin');

                return $app->redirect($app->url('plugin_mail_magazine_template'));
            }

            // メルマガテンプレートを削除する
            $app['eccube.plugin.mail_magazine.repository.mail_magazine']->delete($template);
        }

        // メルマガテンプレート一覧へリダイレクト
        return $app->redirect($app->url('plugin_mail_magazine_template'));
    }

    /**
     * テンプレート編集画面表示.
     *
     * @param Application $app
     * @param Request     $request
     * @param unknown     $id
     */
    public function edit(Application $app, Request $request, $id)
    {
        // POST以外はエラーにする
        if ('POST' !== $request->getMethod()) {
            throw new BadRequestHttpException();
        }
        // id の存在確認
        // nullであれば一覧に戻る
        if (is_null($id) || strlen($id) == 0) {
            $app->addError('admin.plugin.mailmagazine.template.data.illegalaccess', 'admin');

            // メルマガテンプレート一覧へリダイレクト
            return $app->redirect($app->url('plugin_mail_magazine_template'));
        }

        // 選択したメルマガテンプレートを検索
        // 存在しなければメッセージを表示
        $Template = $app['eccube.plugin.mail_magazine.repository.mail_magazine']->find($id);

        if (is_null($Template)) {
            // データが存在しない場合はメルマガテンプレート一覧へリダイレクト
            $app->addError('admin.plugin.mailmagazine.template.data.notfound', 'admin');

            return $app->redirect($app->url('plugin_mail_magazine_template'));
        }

        // formの作成
        $form = $app['form.factory']
            ->createBuilder('mail_magazine_template_edit', $Template)
            ->getForm();

        return $app->render('MailMagazine/Resource/template/admin/template_edit.twig', array(
                'form' => $form->createView(),
                'Template' => $Template,
        ));
    }

    /**
     * テンプレート編集確定処理.
     *
     * @param Application $app
     * @param Request     $request
     * @param unknown     $id
     */
    public function commit(Application $app, Request $request, $id)
    {
        /** @var MailMagazineTemplateRepository $templateRepository */
        $templateRepository = $app['eccube.plugin.mail_magazine.repository.mail_magazine'];
        $Template = $id ? $templateRepository->find($id) : new MailMagazineTemplate();

        // データが存在しない場合はメルマガテンプレート一覧へリダイレクト
        if (is_null($Template)) {
            $app->addError('admin.plugin.mailmagazine.template.data.notfound', 'admin');

            return $app->redirect($app->url('plugin_mail_magazine_template'));
        }

        // Formを取得
        $builder = $app['form.factory']->createBuilder('mail_magazine_template_edit', $Template);
        $form = $builder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // 入力項目確認処理を行う.
            // エラーであれば元の画面を表示する
            if (!$form->isValid()) {
                $app->addError('validate error');

                return $app->render('MailMagazine/Resource/template/admin/template_edit.twig', array(
                        'form' => $form->createView(),
                    'Template' => $Template,
                ));
            }

            if (!$id) {
                // =============
                // 登録処理
                // =============
                $status = $templateRepository->create($Template);
                if (!$status) {
                    $app->addError('admin.plugin.mailmagazine.template.save.failure', 'admin');

                    return $app->render('MailMagazine/Resource/template/admin/template_edit.twig', array(
                            'form' => $form->createView(),
                            'Template' => $Template,
                    ));
                }
            } else {
                // =============
                // 更新処理
                // =============
                $status = $app['eccube.plugin.mail_magazine.repository.mail_magazine']->update($Template);
                if (!$status) {
                    $app->addError('admin.plugin.mailmagazine.template.save.failure', 'admin');

                    return $app->render('MailMagazine/Resource/template/admin/template_edit.twig', array(
                        'form' => $form->createView(),
                        'Template' => $Template,
                    ));
                }
            }

            // 成功時のメッセージを登録する
            $app->addSuccess('admin.plugin.mailmagazine.template.save.complete', 'admin');
        }

        // メルマガテンプレート一覧へリダイレクト
        return $app->redirect($app->url('plugin_mail_magazine_template'));
    }

    /**
     * メルマガテンプレート登録画面を表示する.
     *
     * @param Application $app
     * @param Request     $request
     */
    public function regist(Application $app, Request $request)
    {
        $Template = new MailMagazineTemplate();

        // formの作成
        $form = $app['form.factory']
            ->createBuilder('mail_magazine_template_edit', $Template)
            ->getForm();

        return $app->render('MailMagazine/Resource/template/admin/template_edit.twig', array(
                'form' => $form->createView(),
                'Template' => $Template,
        ));
    }
}
