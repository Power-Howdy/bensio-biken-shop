<?php

namespace Plugin\MailMagazine\Event;

use Eccube\Entity\Customer;
use Eccube\Event\EventArgs;
use Eccube\Event\TemplateEvent;

class MailMagazine extends CommonEvent
{
    /**
     * 新規会員登録画面のイベント処理.
     *
     * @param TemplateEvent $event
     */
    public function onRenderEntryIndex(TemplateEvent $event)
    {
        $this->replaceEntryForm($event, 'top_box__job');
    }

    /**
     * 新規会員登録確認画面のイベント処理.
     *
     * @param TemplateEvent $event
     */
    public function onRenderEntryConfirm(TemplateEvent $event)
    {
        $this->replaceTwig($event, 'MailMagazine/Resource/template/entry_confirm_add_mailmaga.twig', '<div id="confirm_box__footer" class="row no-padding">');
    }

    /**
     * 新規会員登録完了時のイベント処理.
     *
     * @param EventArgs $event
     */
    public function onFrontEntryIndexComplete(EventArgs $event)
    {
        $customerId = $this->getEntryCustomerId($event->getRequest());
        $form = $event['form'];
        $mailmagaFlg = $form->get('mailmaga_flg')->getData();
        $this->saveMailmagaCustomer($customerId, $mailmagaFlg);
    }

    /**
     * 会員情報編集画面のイベント処理.
     *
     * @param TemplateEvent $event
     */
    public function onRenderMypageChange(TemplateEvent $event)
    {
        $this->replaceEntryForm($event, 'detail_box__job');
    }

    /**
     * 会員情報編集完了時のイベント処理.
     *
     * @param EventArgs $event
     */
    public function onFrontMypageChangeIndexComplete(EventArgs $event)
    {
        /** @var Customer $Customer */
        $Customer = $event['Customer'];
        $customerId = $Customer->getId();
        $form = $event['form'];
        $mailmagaFlg = $form->get('mailmaga_flg')->getData();
        $this->saveMailmagaCustomer($customerId, $mailmagaFlg);
    }

    /**
     * 管理用会員編集画面のイベント処理.
     *
     * @param TemplateEvent $event
     */
    public function onRenderAdminCustomerEdit(TemplateEvent $event)
    {
        $this->replaceTwig($event, 'MailMagazine/Resource/template/admin/mailmagazine.twig', '<div class="extra-form">');
    }

    /**
     * 管理用会員編集完了時のイベント処理.
     *
     * @param EventArgs $event
     */
    public function onAdminCustomerEditIndexComplete(EventArgs $event)
    {
        $Customer = $event['Customer'];
        $customerId = $Customer->getId();
        $form = $event['form'];
        $mailmagaFlg = $form->get('mailmaga_flg')->getData();
        $this->saveMailmagaCustomer($customerId, $mailmagaFlg);
    }

    private function replaceTwig($event, $viewName, $search)
    {
        $snippet = $this->app['twig']->getLoader()->getSource($viewName);
        $replace = $snippet.$search;
        $source = str_replace($search, $replace, $event->getSource());
        $event->setSource($source);
    }

    private function replaceEntryForm(TemplateEvent $event, $elementId)
    {
        $snippet = $this->app['twig']->getLoader()->getSource('MailMagazine/Resource/template/entry_add_mailmaga.twig');
        $source = $event->getSource();

        $pattern = '/<dl id="'.$elementId.'.*?>.*?<\/dl>/s';
        preg_match($pattern, $source, $matches);
        $search = $matches[0];
        $replace = $search.$snippet;

        $source = str_replace($search, $replace, $source);
        $event->setSource($source);
    }
}
