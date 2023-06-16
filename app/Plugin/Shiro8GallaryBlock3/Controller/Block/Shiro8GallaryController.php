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

namespace Plugin\Shiro8GallaryBlock3\Controller\Block;

use Eccube\Application;
use Eccube\Entity\Master\Disp;

class Shiro8GallaryController
{
    /**
     * @param Application $app
     */
    public function index(Application $app)
    {
    
        $builder = $app['orm.em']->createQueryBuilder()
            ->select('pg.id')
            ->from('Plugin\Shiro8GallaryBlock3\Entity\Shiro8ProductGallary', 'pg')
            ->andWhere('pg.useFlg = 1')
        ;
    
        //V’…‡‚Å¤•i‚ð12ŒŽæ“¾‚·‚é
        $qb = $app['orm.em']->createQueryBuilder()
            ->select('p')
            ->from('\Eccube\Entity\Product', 'p');
            
        $qb->andWhere('p.Status = 1')
            ->andWhere($qb->expr()->in('p.id', $builder->getDQL()))
            ;
        
        // V’…‡
        $qb->orderBy('p.create_date', 'DESC');
        
        $pagination = $app['paginator']()->paginate(
            $qb,
            1,
            12
        );
        
        return $app['view']->render('Block/plg_shiro8_gallary_block.twig', array(
            'Products' => $pagination,
        ));
    }
}
