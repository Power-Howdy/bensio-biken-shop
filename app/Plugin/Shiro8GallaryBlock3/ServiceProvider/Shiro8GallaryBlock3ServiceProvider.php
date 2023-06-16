<?php
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2015 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

namespace Plugin\Shiro8GallaryBlock3\ServiceProvider;

use Silex\Application as BaseApplication;
use Silex\ServiceProviderInterface;
use Symfony\Component\Yaml\Yaml;

class Shiro8GallaryBlock3ServiceProvider implements ServiceProviderInterface
{

    public function register(BaseApplication $app)
    {
        
        // ブロック
        $app->match('/block/plg_shiro8_gallary_block', '\Plugin\Shiro8GallaryBlock3\Controller\Block\Shiro8GallaryController::index')
            ->bind('block_plg_shiro8_gallary_block');
            
        //Repository
        $app['shiro8_gallary_block.repository.shiro8_product_gallary'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Plugin\Shiro8GallaryBlock3\Entity\Shiro8ProductGallary');
        });

    }

    public function boot(BaseApplication $app)
    {
    }
}
