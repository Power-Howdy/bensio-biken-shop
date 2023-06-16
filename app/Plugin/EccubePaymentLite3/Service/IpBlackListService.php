<?php

namespace Plugin\EccubePaymentLite3\Service;

use Eccube\Application;
use Plugin\EccubePaymentLite3\Util\PluginUtil;
use Symfony\Component\HttpFoundation\Request;

class IpBlackListService
{
    /** @var Application */
    public $app;

    /**
     * IpBlackListService constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function handle()
    {
        $error_page_flg = false;

        // ブラックリストのIPを取得
        $request = Request::createFromGlobals();
        $remoteAddress = $request->server->get('REMOTE_ADDR');

        $objPlugin =& PluginUtil::getInstance($this->app);
        $subData = $objPlugin->getSubData();
        $userSettings = !empty($subData['user_settings']) ? $subData['user_settings'] : array();
        $ipBlackList = explode(',',$userSettings['ip_black_lists']);

        foreach ($ipBlackList as $ipAddress) {
            if (trim($ipAddress) === $remoteAddress) {
                $error_page_flg = true;
                // 不正アクセスと判断
                $date = new \DateTime();
                $this->app['monolog.gmoepsilon']->addInfo(" Black list  IP ADDRESS: $remoteAddress DATE:{$date->format("Y-m-d H:i:s")}");
            }
        }

        return $error_page_flg;
    }
}
