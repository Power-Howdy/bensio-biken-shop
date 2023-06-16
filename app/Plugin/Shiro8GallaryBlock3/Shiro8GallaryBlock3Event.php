<?php
/*
* This file is part of EC-CUBE
*
* Copyright(c) 2000-2015 LOCKON CO.,LTD. All Rights Reserved.
* http://www.lockon.co.jp/
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Plugin\Shiro8GallaryBlock3;

use Eccube\Event\EventArgs;
use Symfony\Component\DomCrawler\Crawler;
use Eccube\Event\TemplateEvent;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Component\Filesystem\Filesystem;
use Eccube\Util\Str;
use Plugin\Shiro8GallaryBlock3\Entity\Shiro8ProductGallary;
use Symfony\Component\Validator\Constraints as Assert;

class Shiro8GallaryBlock3Event
{

    /**
     * プラグインが追加するフォーム名.
     */
    const PRODUCT_GALLARY_CONTENT = 'plg_shiro8_product_gallary';

    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * 管理画面：商品登録画面に, 商品コンテンツのフォームを追加する.
     *
     * @param EventArgs $event
     */
    public function onAdminProductFormInitialize(EventArgs $event)
    {
        //log_info('Shiro8GallaryBlock3 admin.product.edit.initialize start');

        /* @var Category $TargetCategory */
        $Product = $event->getArgument('Product');
        $id = $Product->getId();

        $ProductGallary = null;

        if ($id) {
            // 商品編集時は初期値を取得
            $ProductGallary = $this->app['shiro8_gallary_block.repository.shiro8_product_gallary']->find($id);
        }

        // 商品新規登録またはコンテンツが未登録の場合
        if (!$ProductGallary) {
            $ProductGallary = new Shiro8ProductGallary();
        }

        // フォームの追加
        /** @var FormInterface $builder */
        $builder = $event->getArgument('builder');
        $builder->add(
            self::PRODUCT_GALLARY_CONTENT,
            'choice',
            array(
                'required' => false,
                'label' => 'ギャラリーに表示する',
                'choices' => array(
                	'1' => '表示',
                    '0' => '非表示',
                ),
                'empty_value' => false,
                'expanded' => true,
                'mapped' => false,
                'multiple' => false,
            )
        );

        // 初期値を設定
        if ($ProductGallary->getUseFlg() > 0) {
            $builder->get(self::PRODUCT_GALLARY_CONTENT)->setData(1);
        } else {
        	$builder->get(self::PRODUCT_GALLARY_CONTENT)->setData(0);
        }
        //log_info('Shiro8GallaryBlock3 admin.product.edit.initialize end');
    }

    /**
     * 管理画面：商品登録画面で、登録処理を行う.
     *
     * @param EventArgs $event
     */
    public function onAdminProductEditComplete(EventArgs $event)
    {
        //log_info('Shiro8GallaryBlock3 admin.product.edit.complete start');
        /** @var Application $app */
        $app = $this->app;
        
        //イベント元からの値を取得
        $Product = $event->getArgument('Product');
        $form = $event->getArgument('form');

        // 現在のエンティティを取得
        $id = $Product->getId();
        $ProductGallary = $app['shiro8_gallary_block.repository.shiro8_product_gallary']->find($id);
        if (!$ProductGallary) {
            $ProductGallary = new Shiro8ProductGallary();
        }
        
        $Category = $form[self::PRODUCT_GALLARY_CONTENT]->getData();
        if (!$Category) {
            // エンティティを更新
	        $ProductGallary
	            ->setId($id)
	            ->setUseFlg(null);

	        // DB更新
	        $app['orm.em']->persist($ProductGallary);
	        $app['orm.em']->flush($ProductGallary);

        } else {

	        // エンティティを更新
	        $ProductGallary
	            ->setId($id)
	            ->setUseFlg(1);

	        // DB更新
	        $app['orm.em']->persist($ProductGallary);
	        $app['orm.em']->flush($ProductGallary);
        }

        //log_info('Shiro8 Product Content Detail save successful !', array('product id' => $id));
        //log_info('Shiro8GallaryBlock3 admin.product.edit.complete end');
    }
    
}
