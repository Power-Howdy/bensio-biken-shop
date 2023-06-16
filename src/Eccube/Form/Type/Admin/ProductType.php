<?php
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) EC-CUBE CO.,LTD. All Rights Reserved.
 *
 * http://www.ec-cube.co.jp/
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


namespace Eccube\Form\Type\Admin;

use Doctrine\Common\Collections\ArrayCollection;
use Eccube\Application;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ProductType.
 */
class ProductType extends AbstractType
{
    /**
     * @var Application
     */
    public $app;

    /**
     * ProductType constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /**
         * @var ArrayCollection $arrCategory array of category
         */
        $arrCategory = $this->app['eccube.repository.category']->getList(null, true);

        $builder
            // 商品規格情報
            ->add('class', 'admin_product_class', array(
                'mapped' => false,
            ))
            // 基本情報
            ->add('name', 'text', array(
                'label' => '商品名',
                'constraints' => array(
                    new Assert\NotBlank(),
                ),
            ))
            ->add('product_image', 'file', array(
                'label' => '商品画像',
                'multiple' => true,
                'required' => false,
                'mapped' => false,
            ))
            ->add('description_detail', 'textarea', array(
                'label' => '商品説明',
            ))
            ->add('description_list', 'textarea', array(
                'label' => '商品説明(一覧)',
                'required' => false,
            ))
            ->add('Category', 'entity', array(
                'class' => 'Eccube\Entity\Category',
                'property' => 'NameWithLevel',
                'label' => '商品カテゴリ',
                'multiple' => true,
                'mapped' => false,
                // Choices list (overdrive mapped)
                'choices' => $arrCategory,
            ))

            // 詳細な説明
            ->add('Tag', 'tag', array(
                'required' => false,
                'multiple' => true,
                'expanded' => true,
                'mapped' => false,
            ))
            ->add('search_word', 'textarea', array(
                'label' => "検索ワード",
                'required' => false,
            ))
            // サブ情報
            ->add('free_area', 'textarea', array(
                'label' => 'サブ情報',
                'required' => false,
            ))

            // 右ブロック
            ->add('Status', 'disp', array(
                'constraints' => array(
                    new Assert\NotBlank(),
                ),
            ))
            ->add('note', 'textarea', array(
                'label' => 'ショップ用メモ帳',
                'required' => false,
            ))

            // タグ
            ->add('tags', 'collection', array(
                'type' => 'hidden',
                'prototype' => true,
                'mapped' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ))
            // 画像
            ->add('images', 'collection', array(
                'type' => 'hidden',
                'prototype' => true,
                'mapped' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ))
            ->add('add_images', 'collection', array(
                'type' => 'hidden',
                'prototype' => true,
                'mapped' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ))
            ->add('delete_images', 'collection', array(
                'type' => 'hidden',
                'prototype' => true,
                'mapped' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ))

            ->add('video_url1', 'text', array(
                'label' => '動画ID（1）',
                'required' => false,
            ))
            ->add('video_url2', 'text', array(
                'label' => '動画ID（2）',
                'required' => false,
            ))
            ->add('video_url3', 'text', array(
                'label' => '動画ID（3）',
                'required' => false,
            ))
            ->add('video_url4', 'text', array(
                'label' => '動画ID（4）',
                'required' => false,
            ))
            ->add('video_url5', 'text', array(
                'label' => '動画ID（5）',
                'required' => false,
            ))
            ->add('video_url6', 'text', array(
                'label' => '動画ID（6）',
                'required' => false,
            ))
            ->add('video_url7', 'text', array(
                'label' => '動画ID（7）',
                'required' => false,
            ))
            ->add('video_url8', 'text', array(
                'label' => '動画ID（8）',
                'required' => false,
            ))
            ->add('video_url9', 'text', array(
                'label' => '動画ID（9）',
                'required' => false,
            ))
            ->add('video_url10', 'text', array(
                'label' => '動画ID（10）',
                'required' => false,
            ))
            ->add('video_url11', 'text', array(
                'label' => '動画ID（11）',
                'required' => false,
            ))
            ->add('video_url12', 'text', array(
                'label' => '動画ID（12）',
                'required' => false,
            ))
            ->add('video_url13', 'text', array(
                'label' => '動画ID（13）',
                'required' => false,
            ))
            ->add('video_url14', 'text', array(
                'label' => '動画ID（14）',
                'required' => false,
            ))
            ->add('video_url15', 'text', array(
                'label' => '動画ID（15）',
                'required' => false,
            ))
            ->add('video_url16', 'text', array(
                'label' => '動画ID（16）',
                'required' => false,
            ))
            ->add('video_url17', 'text', array(
                'label' => '動画ID（17）',
                'required' => false,
            ))
            ->add('video_url18', 'text', array(
                'label' => '動画ID（18）',
                'required' => false,
            ))
            ->add('video_url19', 'text', array(
                'label' => '動画ID（19）',
                'required' => false,
            ))
            ->add('video_url20', 'text', array(
                'label' => '動画ID（20）',
                'required' => false,
            ))

            ->add('video_title1', 'text', array(
                'label' => 'タイトル（1）',
                'required' => false,
            ))
            ->add('video_title2', 'text', array(
                'label' => 'タイトル（2）',
                'required' => false,
            ))
            ->add('video_title3', 'text', array(
                'label' => 'タイトル（3）',
                'required' => false,
            ))
            ->add('video_title4', 'text', array(
                'label' => 'タイトル（4）',
                'required' => false,
            ))
            ->add('video_title5', 'text', array(
                'label' => 'タイトル（5）',
                'required' => false,
            ))
            ->add('video_title6', 'text', array(
                'label' => 'タイトル（6）',
                'required' => false,
            ))
            ->add('video_title7', 'text', array(
                'label' => 'タイトル（7）',
                'required' => false,
            ))
            ->add('video_title8', 'text', array(
                'label' => 'タイトル（8）',
                'required' => false,
            ))
            ->add('video_title9', 'text', array(
                'label' => 'タイトル（9）',
                'required' => false,
            ))
            ->add('video_title10', 'text', array(
                'label' => 'タイトル（10）',
                'required' => false,
            ))
            ->add('video_title11', 'text', array(
                'label' => 'タイトル（11）',
                'required' => false,
            ))
            ->add('video_title12', 'text', array(
                'label' => 'タイトル（12）',
                'required' => false,
            ))
            ->add('video_title13', 'text', array(
                'label' => 'タイトル（13）',
                'required' => false,
            ))
            ->add('video_title14', 'text', array(
                'label' => 'タイトル（14）',
                'required' => false,
            ))
            ->add('video_title15', 'text', array(
                'label' => 'タイトル（15）',
                'required' => false,
            ))
            ->add('video_title16', 'text', array(
                'label' => 'タイトル（16）',
                'required' => false,
            ))
            ->add('video_title17', 'text', array(
                'label' => 'タイトル（17）',
                'required' => false,
            ))
            ->add('video_title18', 'text', array(
                'label' => 'タイトル（18）',
                'required' => false,
            ))
            ->add('video_title19', 'text', array(
                'label' => 'タイトル（19）',
                'required' => false,
            ))
            ->add('video_title20', 'text', array(
                'label' => 'タイトル（20）',
                'required' => false,
            ))

            ->add('video_text1', 'textarea', array(
                'label' => '補足・コメント（1）',
                'required' => false,
            ))
            ->add('video_text2', 'textarea', array(
                'label' => '補足・コメント（2）',
                'required' => false,
            ))
            ->add('video_text3', 'textarea', array(
                'label' => '補足・コメント（3）',
                'required' => false,
            ))
            ->add('video_text4', 'textarea', array(
                'label' => '補足・コメント（4）',
                'required' => false,
            ))
            ->add('video_text5', 'textarea', array(
                'label' => '補足・コメント（5）',
                'required' => false,
            ))
            ->add('video_text6', 'textarea', array(
                'label' => '補足・コメント（6）',
                'required' => false,
            ))
            ->add('video_text7', 'textarea', array(
                'label' => '補足・コメント（7）',
                'required' => false,
            ))
            ->add('video_text8', 'textarea', array(
                'label' => '補足・コメント（8）',
                'required' => false,
            ))
            ->add('video_text9', 'textarea', array(
                'label' => '補足・コメント（9）',
                'required' => false,
            ))
            ->add('video_text10', 'textarea', array(
                'label' => '補足・コメント（10）',
                'required' => false,
            ))
            ->add('video_text11', 'textarea', array(
                'label' => '補足・コメント（11）',
                'required' => false,
            ))
            ->add('video_text12', 'textarea', array(
                'label' => '補足・コメント（12）',
                'required' => false,
            ))
            ->add('video_text13', 'textarea', array(
                'label' => '補足・コメント（13）',
                'required' => false,
            ))
            ->add('video_text14', 'textarea', array(
                'label' => '補足・コメント（14）',
                'required' => false,
            ))
            ->add('video_text15', 'textarea', array(
                'label' => '補足・コメント（15）',
                'required' => false,
            ))
            ->add('video_text16', 'textarea', array(
                'label' => '補足・コメント（16）',
                'required' => false,
            ))
            ->add('video_text17', 'textarea', array(
                'label' => '補足・コメント（17）',
                'required' => false,
            ))
            ->add('video_text18', 'textarea', array(
                'label' => '補足・コメント（18）',
                'required' => false,
            ))
            ->add('video_text19', 'textarea', array(
                'label' => '補足・コメント（19）',
                'required' => false,
            ))
            ->add('video_text20', 'textarea', array(
                'label' => '補足・コメント（20）',
                'required' => false,
            ))

            ->add('video_comment', 'textarea', array(
                'label' => 'ビデオコメント',
                'required' => false,
            ))
            ->add('video_file', 'text', array(
                'label' => 'ビデオテキスト',
                'required' => false,
            ))
            ->add('video_userid', 'text', array(
                'label' => 'ユーザID',
                'required' => false,
            ))
            ->add('video_userpass', 'text', array(
                'label' => 'パスワード',
                'required' => false,
            ))
        ;

        $that = $this;
        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($that) {
            /** @var FormInterface $form */
            $form = $event->getForm();
            $saveImgDir = $that->app['config']['image_save_realdir'];
            $tempImgDir = $that->app['config']['image_temp_realdir'];
            $that->validateFilePath($form->get('delete_images'), array($saveImgDir, $tempImgDir));
            $that->validateFilePath($form->get('add_images'), array($tempImgDir));
        });
    }

    /**
     * 指定された複数ディレクトリのうち、いずれかのディレクトリ以下にファイルが存在するかを確認。
     *
     * @param $form FormInterface
     * @param $dirs array
     */
    private function validateFilePath($form, $dirs)
    {
        foreach ($form->getData() as $fileName) {
            $fileInDir = array_filter($dirs, function ($dir) use ($fileName) {
                $filePath = realpath($dir.'/'.$fileName);
                $topDirPath = realpath($dir);
                return strpos($filePath, $topDirPath) === 0 && $filePath !== $topDirPath;
            });
            if (!$fileInDir) {
                $formRoot = $form->getRoot();
                $formRoot['product_image']->addError(new FormError('画像のパスが不正です。'));
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'admin_product';
    }
}
