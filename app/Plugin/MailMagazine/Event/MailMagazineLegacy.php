<?php

namespace Plugin\MailMagazine\Event;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class MailMagazineLegacy extends CommonEvent
{
    // ===========================================================
    // マイページ画面
    // ===========================================================

    /**
     * マイページ会員情報編集のrender before
     * メルマガ送付項目を表示する.
     *
     * @param FilterResponseEvent $event
     */
    public function onRenderMypageChangeBefore(FilterResponseEvent $event)
    {
        if (!$this->app->isGranted('IS_AUTHENTICATED_FULLY')) {
            return;
        }

        $request = $event->getRequest();
        $response = $event->getResponse();

        // メールマガジンの送付についての項目を追加したHTMLを取得する
        $html = $this->getNewMypageChangeHtml($request, $response);

        $response->setContent($html);
        $event->setResponse($response);
    }

    /**
     * マイページ会員情報編集 controll after
     * メルマガ送付情報を保存する.
     */
    public function onControllMypageChangeAfter()
    {
        if (!$this->app->isGranted('IS_AUTHENTICATED_FULLY')) {
            return;
        }

        $app = $this->app;
        $request = $this->app['request'];

        // POST以外では処理を行わない
        if ('POST' !== $request->getMethod()) {
            return;
        }

        // Controller側のvalidationでエラーの場合には処理を続行しない
        $Customer = $app->user();
        if (is_null($Customer)) {
            return;
        }

        // メルマガFormを取得する
        $builder = $app['form.factory']->createBuilder('entry');
        $form = $builder->getForm();

        $form->handleRequest($request);

        // カスタマIDの取得
        $Customer = $app->user();
        $customerId = $Customer->getId();

        // メルマガ送付情報を保存する
        $mailmagaFlg = $form->get('mailmaga_flg')->getData();
        $this->saveMailmagaCustomer($customerId, $mailmagaFlg);
    }

    // ===========================================================
    // 新規会員登録画面
    // ===========================================================

    /**
     * 新規会員登録のBefore.
     *
     * @param FilterResponseEvent $event
     */
    public function onRenderEntryBefore(FilterResponseEvent $event)
    {
        $request = $event->getRequest();
        $response = $event->getResponse();

        // 登録完了画面の場合は終了
        if ('POST' === $request->getMethod() && $request->get('mode') == 'complete') {
            return;
        }

        // メールマガジンの送付についての項目を追加したHTMLを取得する
        $html = $this->getNewEntryHtml($request, $response);

        $response->setContent($html);
        $event->setResponse($response);
    }

    /**
     * 新規会員登録確認画面の後処理.
     * メールマガジン送付情報を保存する.
     */
    public function onControllerEntryAfter()
    {
        $app = $this->app;
        $request = $this->app['request'];

        // POST以外では処理を行わない
        if ('POST' !== $request->getMethod()) {
            return;
        }
        $mode = $request->get('mode');
        if ($mode != 'complete') {
            return;
        }

        // 今が登録確認画面か確認する
        $confirmFlg = $this->isEntryConfirm($request);

        // メールマガジン送付フラグを取得する
        $builder = $app['form.factory']->createBuilder('entry');
        $form = $builder->getForm();

        $form->handleRequest($request);

        if ($confirmFlg) {
            $builder->setAttribute('freeze', true);
            $form = $builder->getForm();
            $form->handleRequest($request);
        }

        if ($mode == 'complete') {
            // カスタマーIDを取得する
            $customerId = $this->getEntryCustomerId($request);

            // メルマガ送付情報を保存する
            if (!is_null($customerId)) {
                $mailmagaFlg = $form->get('mailmaga_flg')->getData();
                $this->saveMailmagaCustomer($customerId, $mailmagaFlg);
            }
        }
    }

    /**
     * 会員管理 会員登録・編集のbefore.
     *
     * @param FilterResponseEvent $event
     */
    public function onRenderAdminCustomerBefore(FilterResponseEvent $event)
    {
        if (!$this->app->isGranted('ROLE_ADMIN')) {
            return;
        }

        $request = $event->getRequest();
        $response = $event->getResponse();

        $form = $this->app['form.factory']->createBuilder('admin_customer')->getForm();

        if ('POST' === $request->getMethod() && $response->headers->has('location')) {
            // 保存成功時
            // 3.0.9 未満では、EccubeEvents::ADMIN_CUSTOMER_EDIT_INDEX_COMPLETE
            // が利用できないためPOST & リダイレクトありで保存成功とみなす

            if ($request->attributes->get('id')) {
                $id = $request->attributes->get('id');
            } else {
                $location = explode('/', $response->headers->get('location'));
                $url = explode('/', $this->app->url('admin_customer_edit', array('id' => '0')));
                $diffs = array_values(array_diff($location, $url));
                $id = $diffs[0];
            }
            $Customer = $this->app['eccube.repository.customer']->find($id);

            // メルマガFormを取得する
            $builder = $this->app['form.factory']->createBuilder('admin_customer');
            $form = $builder->getForm();

            $form->handleRequest($request);

            // カスタマIDの取得
            $customerId = $Customer->getId();

            // // メルマガ送付情報を保存する
            $mailmagaFlg = $form->get('mailmaga_flg')->getData();
            $this->saveMailmagaCustomer($customerId, $mailmagaFlg);
        } else {
            $id = $request->get('id');
            if ($id) {
                $Customer = $this->app['orm.em']
                    ->getRepository('Eccube\Entity\Customer')
                    ->find($id);

                if (is_null($Customer)) {
                    return;
                }

                // DBからメルマガ送付情報を取得する
                $MailmagaCustomerRepository = $this->app['eccube.plugin.mail_magazine.repository.mail_magazine_mailmaga_customer'];
                $MailmagaCustomer = $MailmagaCustomerRepository->findOneBy(array('customer_id' => $Customer->getId()));

                if (!is_null($MailmagaCustomer)) {
                    $form->get('mailmaga_flg')->setData($MailmagaCustomer->getMailmagaFlg());
                }
            }

            $form->handleRequest($request);

            $document = \DOMDocument::loadHTML($response->getContent());
            $xpath = new \DOMXPath($document);
            $table = $xpath->query('//div[@class="form-horizontal"]', $document)->item(0);

            if (!$table) {
                return $response->getContent();
            }

            $parts = $this->app->renderView('MailMagazine/Resource/template/admin/mailmagazine.twig', array(
                'form' => $form->createView(),
            ));

            $dom = \DOMDocument::loadHtml('<?xml encoding="utf-8" ?>'.$parts);
            $newNode = $dom->getElementsByTagName('div')->item(0);
            $table->appendChild($document->importNode($newNode, true));

            $crawler = new Crawler($document);
            $response->setContent($crawler->html());
            $event->setResponse($response);
        }
    }

    // ===========================================================
    // クラス内メソッド
    // ===========================================================

    /**
     * 会員新規登録画面に「メールマガジン送付について」項目を追加したHTMLを取得する.
     *
     * @param Request  $request
     * @param Response $response
     *
     * @return string
     */
    protected function getNewEntryHtml($request, $response)
    {
        $app = &$this->app;

        // 今が登録確認画面か確認する
        $confirmFlg = $this->isEntryConfirm($request);

        // POSTの場合はメールマガジン送付を入力不可にする
        $twigName = 'entry_add_mailmaga.twig';
        if ('POST' === $this->app['request']->getMethod() && $confirmFlg) {
            $twigName = 'entry_confirm_add_mailmaga.twig';
        }

        // Formの取得
        $builder = $app['form.factory']->createBuilder('entry');
        $form = $builder->getForm();

        $form->handleRequest($request);

        if ($confirmFlg) {
            $builder->setAttribute('freeze', true);
            $form = $builder->getForm();
            $form->handleRequest($request);
        }

        $document = \DOMDocument::loadHTML($response->getContent());
        $xpath = new \DOMXPath($document);
        $table = $xpath->query('//div[@class="dl_table not_required"]', $document)->item(0);

        if (!$table) {
            return $response->getContent();
        }

        $parts = $this->app['twig']->render(
            'MailMagazine/Resource/template/' . $twigName,
            array('form' => $form->createView())
        );

        $dom = \DOMDocument::loadHtml('<?xml encoding="utf-8" ?>'.$parts);
        $newNode = $dom->getElementsByTagName('dl')->item(0);
        $table->appendChild($document->importNode($newNode, true));

        $crawler = new Crawler($document);

        return $crawler->html();
    }

    /**
     * マイページ画面に「メールマガジン送付について」項目を追加したHTMLを取得する.
     *
     * @param Request  $request
     * @param Response $response
     *
     * @return string
     */
    protected function getNewMypageChangeHtml($request, $response)
    {
        $app = &$this->app;

        // カスタマIDの取得
        $Customer = $app->user();
        if (is_null($Customer)) {
            return $response->getContent();
        }

        // Formの取得
        $builder = $app['form.factory']->createBuilder('entry');
        $form = $builder->getForm();

        if ('POST' === $this->app['request']->getMethod()) {
            $form->handleRequest($request);
        } else {
            // DBからメルマガ送付情報を取得する
            $MailmagaCustomerRepository = $this->app['eccube.plugin.mail_magazine.repository.mail_magazine_mailmaga_customer'];
            $MailmagaCustomer = $MailmagaCustomerRepository->findOneBy(array('customer_id' => $Customer->getId()));

            if (!is_null($MailmagaCustomer)) {
                $form->get('mailmaga_flg')->setData($MailmagaCustomer->getMailmagaFlg());
            }
        }

        $document = \DOMDocument::loadHTML($response->getContent());
        $xpath = new \DOMXPath($document);
        $table = $xpath->query('//div[@class="dl_table not_required"]', $document)->item(0);

        if (!$table) {
            return $response->getContent();
        }

        // 追加する情報のHTMLを取得する.
        $parts = $this->app['twig']->render(
            'MailMagazine/Resource/template/entry_add_mailmaga.twig',
            array('form' => $form->createView())
        );

        $dom = \DOMDocument::loadHtml('<?xml encoding="utf-8" ?>'.$parts);
        $newNode = $dom->getElementsByTagName('dl')->item(0);
        $table->appendChild($document->importNode($newNode, true));

        $crawler = new Crawler($document);

        return $crawler->html();
    }

    /**
     * 会員登録確認画面が確認する.
     *
     * @param Request $request
     *
     * @return bool
     */
    protected function isEntryConfirm($request)
    {
        $mode = $request->get('mode');

        $Customer = $this->app['eccube.repository.customer']->newCustomer();
        $EntryForm = $this->app['form.factory']->createBuilder('entry', $Customer)->getForm();
        $EntryForm->handleRequest($request);
        // confirmの場合はメールマガジン送付を入力不可にする

        if ($mode == 'confirm' && $EntryForm->isValid()) {
            return true;
        }

        return false;
    }
}
