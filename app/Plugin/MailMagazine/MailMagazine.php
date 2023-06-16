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

namespace Plugin\MailMagazine;

use Eccube\Event\EventArgs;
use Eccube\Event\TemplateEvent;
use Plugin\MailMagazine\Event\MailMagazineLegacy;
use Plugin\MailMagazine\Util\Version;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class MailMagazine
{
    private $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * 3.0.9以降用のイベントハンドラ.
     *
     * @return \Plugin\MailMagazine\Event\MailMagazine
     */
    private function getEventHandler()
    {
        return $this->app['eccube.plugin.mail_magazine.event.mail_magazine'];
    }

    /**
     * 3.0.8以前用のイベントハンドラ.
     *
     * @return MailMagazineLegacy
     */
    private function getLegacyEventHandler()
    {
        return $this->app['eccube.plugin.mail_magazine.event.mail_magazine_legacy'];
    }

    /**
     * 新規会員登録画面のイベント処理.
     *
     * @param TemplateEvent $event
     */
    public function onRenderEntryIndex(TemplateEvent $event)
    {
        $this->getEventHandler()->onRenderEntryIndex($event);
    }

    /**
     * 新規会員登録確認画面のイベント処理.
     *
     * @param TemplateEvent $event
     */
    public function onRenderEntryConfirm(TemplateEvent $event)
    {
        $this->getEventHandler()->onRenderEntryConfirm($event);
    }

    /**
     * 新規会員登録完了時のイベント処理.
     *
     * @param EventArgs $event
     */
    public function onFrontEntryIndexComplete(EventArgs $event)
    {
        $this->getEventHandler()->onFrontEntryIndexComplete($event);
    }

    /**
     * 会員情報編集画面のイベント処理.
     *
     * @param TemplateEvent $event
     */
    public function onRenderMypageChange(TemplateEvent $event)
    {
        $this->getEventHandler()->onRenderMypageChange($event);
    }

    /**
     * 会員情報編集完了時のイベント処理.
     *
     * @param EventArgs $event
     */
    public function onFrontMypageChangeIndexComplete(EventArgs $event)
    {
        $this->getEventHandler()->onFrontMypageChangeIndexComplete($event);
    }

    /**
     * 管理用会員編集画面のイベント処理.
     *
     * @param TemplateEvent $event
     */
    public function onRenderAdminCustomerEdit(TemplateEvent $event)
    {
        $this->getEventHandler()->onRenderAdminCustomerEdit($event);
    }

    /**
     * 管理用会員編集完了時のイベント処理.
     *
     * @param EventArgs $event
     */
    public function onAdminCustomerEditIndexComplete(EventArgs $event)
    {
        $this->getEventHandler()->onAdminCustomerEditIndexComplete($event);
    }

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
        if ($this->isSupportNewHookPoint()) {
            return;
        }
        $this->getLegacyEventHandler()->onRenderMypageChangeBefore($event);
    }

    /**
     * マイページ会員情報編集 controll after
     * メルマガ送付情報を保存する.
     */
    public function onControllMypageChangeAfter()
    {
        if ($this->isSupportNewHookPoint()) {
            return;
        }
        $this->getLegacyEventHandler()->onControllMypageChangeAfter();
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
        if ($this->isSupportNewHookPoint()) {
            return;
        }
        $this->getLegacyEventHandler()->onRenderEntryBefore($event);
    }

    /**
     * 新規会員登録確認画面の後処理.
     * メールマガジン送付情報を保存する.
     */
    public function onControllerEntryAfter()
    {
        if ($this->isSupportNewHookPoint()) {
            return;
        }
        $this->getLegacyEventHandler()->onControllerEntryAfter();
    }

    /**
     * 会員管理 会員登録・編集のbefore.
     *
     * @param FilterResponseEvent $event
     */
    public function onRenderAdminCustomerBefore(FilterResponseEvent $event)
    {
        if ($this->isSupportNewHookPoint()) {
            return;
        }
        $this->getLegacyEventHandler()->onRenderAdminCustomerBefore($event);
    }

    /**
     * v3.0.9以降のフックポイントに対応しているのか.
     *
     * @return bool
     */
    private function isSupportNewHookPoint()
    {
        return Version::isSupport();
    }
}
