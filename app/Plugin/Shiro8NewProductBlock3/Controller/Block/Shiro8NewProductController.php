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

namespace Plugin\Shiro8NewProductBlock3\Controller\Block;

use Eccube\Application;
use Eccube\Entity\Master\Disp;

class Shiro8NewProductController
{
    /**
     * @param Application $app
     */
    public function index(Application $app)
    {
        //V’…‡‚Å¤•i‚ð8ŒŽæ“¾‚·‚é
        
        $builder = $app['form.factory']->createNamedBuilder('', 'search_product');
        $searchForm = $builder->getForm();
        
        $searchForm["orderby"] = 2;
        $searchForm['disp_number'] = 8;
        
        $searchForm->handleRequest($app["request"]);
        
        $searchData = $searchForm->getData();
        $qb = $app['eccube.repository.product']->getQueryBuilderBySearchData($searchData);
        
        $pagination = $app['paginator']()->paginate(
            $qb,
            1,
            8
        );
        
        return $app['view']->render('Block/plg_shiro8_new_product_block.twig', array(
            'Products' => $pagination,
        ));
    }
}
