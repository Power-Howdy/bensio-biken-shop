<?php

/*
* This file is part of EC-CUBE
*
* Copyright(c) 2000-2016 LOCKON CO.,LTD. All Rights Reserved.
* http://www.lockon.co.jp/
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
namespace Plugin\Point\Event\WorkPlace;

use Eccube\Event\EventArgs;
use Eccube\Event\TemplateEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

/**
 * フックポイント定型処理コンポジションスーパークラス
 * Class AbstractWorkPlace
 * @package Plugin\Point\Event\WorkPlace
 */
abstract class AbstractWorkPlace
{
    /** @var \Eccube\Application */
    protected $app;

    /**
     * AbstractWorkPlace constructor.
     */
    public function __construct()
    {
        $this->app = \Eccube\Application::getInstance();
    }

    /**
     * フォーム拡張処理
     *
     * @param EventArgs $event
     */
    public function createForm(EventArgs $event)
    {
        throw new MethodNotAllowedException();
    }

    /**
     * レンダリング拡張処理
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function renderView(Request $request, Response $response)
    {
        throw new MethodNotAllowedException();
    }

    /**
     * Twig拡張処理
     * @param TemplateEvent $event
     * @return mixed
     */
    public function createTwig(TemplateEvent $event)
    {
        throw new MethodNotAllowedException();
    }

    /**
     * 保存拡張処理
     * @param EventArgs $event
     * @return mixed
     */
    public function save(EventArgs $event)
    {
        throw new MethodNotAllowedException();
    }

    /**
     * ビューをsearchをキーにsnippetと置き換え返却
     * @param TemplateEvent $event
     * @param $snippet
     * @param $search
     * @return bool
     */
    protected function replaceView(TemplateEvent $event, $snippet, $search)
    {
        // 必要値を判定
        if (empty($event)) {
            return false;
        }
        if (empty($snippet)) {
            return false;
        }
        if (empty($search)) {
            return false;
        }

        // Twig書き換え
        $replace = $snippet.$search;
        $source = str_replace($search, $replace, $event->getSource());
        $event->setSource($source);

        return true;
    }
}
