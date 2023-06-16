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


namespace Eccube\Entity;

use Eccube\Common\Constant;
use Doctrine\Common\Collections\ArrayCollection;
use Eccube\Util\EntityUtil;

/**
 * Product
 */
class Product extends \Eccube\Entity\AbstractEntity
{
    private $_calc = false;
    private $stockFinds = array();
    private $stocks = array();
    private $stockUnlimiteds = array();
    private $price01 = array();
    private $price02 = array();
    private $price01IncTaxs = array();
    private $price02IncTaxs = array();
    private $codes = array();
    private $classCategories1 = array();
    private $classCategories2 = array();
    private $className1;
    private $className2;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    public function _calc()
    {
        if (!$this->_calc) {
            $i = 0;
            foreach ($this->getProductClasses() as $ProductClass) {
                /* @var $ProductClass \Eccube\Entity\ProductClass */
                // del_flg
                if ($ProductClass->getDelFlg() === 1) {
                    continue;
                }

                // stock_find
                $this->stockFinds[] = $ProductClass->getStockFind();

                // stock
                $this->stocks[] = $ProductClass->getStock();

                // stock_unlimited
                $this->stockUnlimiteds[] = $ProductClass->getStockUnlimited();

                // price01
                if (!is_null($ProductClass->getPrice01())) {
                    $this->price01[] = $ProductClass->getPrice01();
                    // price01IncTax
                    $this->price01IncTaxs[] = $ProductClass->getPrice01IncTax();
                }

                // price02
                $this->price02[] = $ProductClass->getPrice02();

                // price02IncTax
                $this->price02IncTaxs[] = $ProductClass->getPrice02IncTax();

                // product_code
                $this->codes[] = $ProductClass->getCode();

                if ($i === 0) {
                    if ($ProductClass->getClassCategory1() && $ProductClass->getClassCategory1()->getId()) {
                        $this->className1 = $ProductClass->getClassCategory1()->getClassName()->getName();
                    }
                    if ($ProductClass->getClassCategory2() && $ProductClass->getClassCategory2()->getId()) {
                        $this->className2 = $ProductClass->getClassCategory2()->getClassName()->getName();
                    }
                }
                if ($ProductClass->getClassCategory1()) {
                    $classCategoryId1 = $ProductClass->getClassCategory1()->getId();
                    if (!empty($classCategoryId1)) {
                        $this->classCategories1[$ProductClass->getClassCategory1()->getId()] = $ProductClass->getClassCategory1()->getName();
                        if ($ProductClass->getClassCategory2()) {
                            $this->classCategories2[$ProductClass->getClassCategory1()->getId()][$ProductClass->getClassCategory2()->getId()] = $ProductClass->getClassCategory2()->getName();
                        }
                    }
                }
                $i++;
            }
            $this->_calc = true;
        }
    }

    /**
     * Is Enable
     *
     * @return bool
     */
    public function isEnable()
    {
        return $this->getStatus()->getId() === \Eccube\Entity\Master\Disp::DISPLAY_SHOW ? true : false;
    }

    /**
     * Get ClassName1
     *
     * @return string
     */
    public function getClassName1()
    {
        $this->_calc();

        return $this->className1;
    }

    /**
     * Get ClassName2
     *
     * @return string
     */
    public function getClassName2()
    {
        $this->_calc();

        return $this->className2;
    }

    /**
     * Get getClassCategories1
     *
     * @return array
     */
    public function getClassCategories1()
    {
        $this->_calc();

        return $this->classCategories1;
    }

    /**
     * Get getClassCategories2
     *
     * @return array
     */
    public function getClassCategories2($class_category1)
    {
        $this->_calc();

        return isset($this->classCategories2[$class_category1]) ? $this->classCategories2[$class_category1] : array();
    }

    /**
     * Get StockFind
     *
     * @return bool
     */
    public function getStockFind()
    {
        $this->_calc();

        return max($this->stockFinds);
    }

    /**
     * Get Stock min
     *
     * @return integer
     */
    public function getStockMin()
    {
        $this->_calc();

        return min($this->stocks);
    }

    /**
     * Get Stock max
     *
     * @return integer
     */
    public function getStockMax()
    {
        $this->_calc();

        return max($this->stocks);
    }

    /**
     * Get StockUnlimited min
     *
     * @return integer
     */
    public function getStockUnlimitedMin()
    {
        $this->_calc();

        return min($this->stockUnlimiteds);
    }

    /**
     * Get StockUnlimited max
     *
     * @return integer
     */
    public function getStockUnlimitedMax()
    {
        $this->_calc();

        return max($this->stockUnlimiteds);
    }

    /**
     * Get Price01 min
     *
     * @return integer
     */
    public function getPrice01Min()
    {
        $this->_calc();

        if (count($this->price01) == 0) {
            return null;
        }

        return min($this->price01);
    }

    /**
     * Get Price01 max
     *
     * @return integer
     */
    public function getPrice01Max()
    {
        $this->_calc();

        if (count($this->price01) == 0) {
            return null;
        }

        return max($this->price01);
    }

    /**
     * Get Price02 min
     *
     * @return integer
     */
    public function getPrice02Min()
    {
        $this->_calc();

        return min($this->price02);
    }

    /**
     * Get Price02 max
     *
     * @return integer
     */
    public function getPrice02Max()
    {
        $this->_calc();

        return max($this->price02);
    }

    /**
     * Get Price01IncTax min
     *
     * @return integer
     */
    public function getPrice01IncTaxMin()
    {
        $this->_calc();

        return min($this->price01IncTaxs);
    }

    /**
     * Get Price01IncTax max
     *
     * @return integer
     */
    public function getPrice01IncTaxMax()
    {
        $this->_calc();

        return max($this->price01IncTaxs);
    }

    /**
     * Get Price02IncTax min
     *
     * @return integer
     */
    public function getPrice02IncTaxMin()
    {
        $this->_calc();

        return min($this->price02IncTaxs);
    }

    /**
     * Get Price02IncTax max
     *
     * @return integer
     */
    public function getPrice02IncTaxMax()
    {
        $this->_calc();

        return max($this->price02IncTaxs);
    }

    /**
     * Get Product_code min
     *
     * @return integer
     */
    public function getCodeMin()
    {
        $this->_calc();

        $codes = array();
        foreach ($this->codes as $code) {
            if (!is_null($code)) {
                $codes[] = $code;
            }
        }
        return count($codes) ? min($codes) : null;
    }

    /**
     * Get Product_code max
     *
     * @return integer
     */
    public function getCodeMax()
    {
        $this->_calc();

        $codes = array();
        foreach ($this->codes as $code) {
            if (!is_null($code)) {
                $codes[] = $code;
            }
        }
        return count($codes) ? max($codes) : null;
    }

    /**
     * Get ClassCategories
     *
     * @return array
     */
    public function getClassCategories()
    {
        $this->_calc();

        $class_categories = array(
            '__unselected' => array(
                '__unselected' => array(
                    'name'              => '選択してください',
                    'product_class_id'  => '',
                ),
            ),
        );
        foreach ($this->getProductClasses() as $ProductClass) {
            /* @var $ProductClass \Eccube\Entity\ProductClass */
            $ClassCategory1 = $ProductClass->getClassCategory1();
            $ClassCategory2 = $ProductClass->getClassCategory2();

            $class_category_id1 = $ClassCategory1 ? (string) $ClassCategory1->getId() : '__unselected2';
            $class_category_id2 = $ClassCategory2 ? (string) $ClassCategory2->getId() : '';
            $class_category_name1 = $ClassCategory1 ? $ClassCategory1->getName() . ($ProductClass->getStockFind() ? '' : ' (品切れ中)') : '';
            $class_category_name2 = $ClassCategory2 ? $ClassCategory2->getName() . ($ProductClass->getStockFind() ? '' : ' (品切れ中)') : '';

            $class_categories[$class_category_id1]['#'] = array(
                'classcategory_id2' => '',
                'name'              => '選択してください',
                'product_class_id'  => '',
            );
            $class_categories[$class_category_id1]['#'.$class_category_id2] = array(
                'classcategory_id2' => $class_category_id2,
                'name'              => $class_category_name2,
                'stock_find'        => $ProductClass->getStockFind(),
                'price01'           => $ProductClass->getPrice01() === null ? '' : number_format($ProductClass->getPrice01IncTax()),
                'price02'           => number_format($ProductClass->getPrice02IncTax()),
                'product_class_id'  => (string) $ProductClass->getId(),
                'product_code'      => $ProductClass->getCode() === null ? '' : $ProductClass->getCode(),
                'product_type'      => (string) $ProductClass->getProductType()->getId(),
            );
        }

        return $class_categories;
    }

    public function getMainListImage() {
        $ProductImages = $this->getProductImage();
        return empty($ProductImages) ? null : $ProductImages[0];
    }

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $note;

    /**
     * @var string
     */
    private $description_list;

    /**
     * @var string
     */
    private $description_detail;

    /**
     * @var string
     */
    private $search_word;

    /**
     * @var string
     */
    private $free_area;

    /**
     * @var integer
     */
    private $del_flg;

    /**
     * @var \DateTime
     */
    private $create_date;

    /**
     * @var \DateTime
     */
    private $update_date;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $ProductCategories;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $ProductClasses;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $CustomerFavoriteProducts;

    /**
     * @var \Eccube\Entity\Member
     */
    private $Creator;

    /**
     * @var \Eccube\Entity\Master\Disp
     */
    private $Status;

	//▼動画配信
    private $video_url1;
    private $video_url2;
    private $video_url3;
    private $video_url4;
    private $video_url5;
    private $video_url6;
    private $video_url7;
    private $video_url8;
    private $video_url9;
    private $video_url10;
    private $video_url11;
    private $video_url12;
    private $video_url13;
    private $video_url14;
    private $video_url15;
    private $video_url16;
    private $video_url17;
    private $video_url18;
    private $video_url19;
    private $video_url20;
    private $video_title1;
    private $video_title2;
    private $video_title3;
    private $video_title4;
    private $video_title5;
    private $video_title6;
    private $video_title7;
    private $video_title8;
    private $video_title9;
    private $video_title10;
    private $video_title11;
    private $video_title12;
    private $video_title13;
    private $video_title14;
    private $video_title15;
    private $video_title16;
    private $video_title17;
    private $video_title18;
    private $video_title19;
    private $video_title20;
    private $video_text1;
    private $video_text2;
    private $video_text3;
    private $video_text4;
    private $video_text5;
    private $video_text6;
    private $video_text7;
    private $video_text8;
    private $video_text9;
    private $video_text10;
    private $video_text11;
    private $video_text12;
    private $video_text13;
    private $video_text14;
    private $video_text15;
    private $video_text16;
    private $video_text17;
    private $video_text18;
    private $video_text19;
    private $video_text20;
    private $video_comment;
    private $video_file;
    private $video_userid;
    private $video_userpass;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ProductCategories = new ArrayCollection();
        $this->ProductClasses = new ArrayCollection();
        $this->ProductStatuses = new ArrayCollection();
        $this->CustomerFavoriteProducts = new ArrayCollection();
        $this->ProductImage = new ArrayCollection();
        $this->ProductTag = new ArrayCollection();
    }

    public function __clone()
    {
        $this->id = null;
    }

    public function copy()
    {
        // コピー対象外
        $this->CustomerFavoriteProducts = new ArrayCollection();

        $Categories = $this->getProductCategories();
        $this->ProductCategories = new ArrayCollection();
        foreach ($Categories as $Category) {
            $CopyCategory = clone $Category;
            $this->addProductCategory($CopyCategory);
            $CopyCategory->setProduct($this);
        }

        $Classes = $this->getProductClasses();
        $this->ProductClasses = new ArrayCollection();
        foreach ($Classes as $Class) {
            $CopyClass = clone $Class;
            $this->addProductClass($CopyClass);
            $CopyClass->setProduct($this);
        }

        $Images = $this->getProductImage();
        $this->ProductImage = new ArrayCollection();
        foreach ($Images as $Image) {
            $CloneImage = clone $Image;
            $this->addProductImage($CloneImage);
            $CloneImage->setProduct($this);
        }

        $Tags = $this->getProductTag();
        $this->ProductTag = new ArrayCollection();
        foreach ($Tags as $Tag) {
            $CloneTag = clone $Tag;
            $this->addProductTag($CloneTag);
            $CloneTag->setProduct($this);
        }

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param  string  $name
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set note
     *
     * @param  string  $note
     * @return Product
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set description_list
     *
     * @param string $descriptionList
     * @return Product
     */
    public function setDescriptionList($descriptionList)
    {
        $this->description_list = $descriptionList;

        return $this;
    }

    /**
     * Get description_list
     *
     * @return string
     */
    public function getDescriptionList()
    {
        return $this->description_list;
    }

    /**
     * Set description_detail
     *
     * @param string $descriptionDetail
     * @return Product
     */
    public function setDescriptionDetail($descriptionDetail)
    {
        $this->description_detail = $descriptionDetail;

        return $this;
    }

    /**
     * Get description_detail
     *
     * @return string
     */
    public function getDescriptionDetail()
    {
        return $this->description_detail;
    }

    /**
     * Set search_word
     *
     * @param string $searchWord
     * @return Product
     */
    public function setSearchWord($searchWord)
    {
        $this->search_word = $searchWord;

        return $this;
    }

    /**
     * Get search_word
     *
     * @return string
     */
    public function getSearchWord()
    {
        return $this->search_word;
    }

    /**
     * Set free_area
     *
     * @param string $freeArea
     * @return Product
     */
    public function setFreeArea($freeArea)
    {
        $this->free_area = $freeArea;

        return $this;
    }

    /**
     * Get free_area
     *
     * @return string
     */
    public function getFreeArea()
    {
        return $this->free_area;
    }


    /**
     * Set del_flg
     *
     * @param  integer $delFlg
     * @return Product
     */
    public function setDelFlg($delFlg)
    {
        $this->del_flg = $delFlg;

        return $this;
    }

    /**
     * Get del_flg
     *
     * @return integer
     */
    public function getDelFlg()
    {
        return $this->del_flg;
    }

    /**
     * Set create_date
     *
     * @param  \DateTime $createDate
     * @return Product
     */
    public function setCreateDate($createDate)
    {
        $this->create_date = $createDate;

        return $this;
    }

    /**
     * Get create_date
     *
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->create_date;
    }

    /**
     * Set update_date
     *
     * @param  \DateTime $updateDate
     * @return Product
     */
    public function setUpdateDate($updateDate)
    {
        $this->update_date = $updateDate;

        return $this;
    }

    /**
     * Get update_date
     *
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->update_date;
    }

    /**
     * Add ProductCategories
     *
     * @param  \Eccube\Entity\ProductCategory $productCategories
     * @return Product
     */
    public function addProductCategory(\Eccube\Entity\ProductCategory $productCategories)
    {
        $this->ProductCategories[] = $productCategories;

        return $this;
    }

    /**
     * Remove ProductCategories
     *
     * @param \Eccube\Entity\ProductCategory $productCategories
     */
    public function removeProductCategory(\Eccube\Entity\ProductCategory $productCategories)
    {
        $this->ProductCategories->removeElement($productCategories);
    }

    /**
     * Get ProductCategories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductCategories()
    {
        return $this->ProductCategories;
    }

    /**
     * Add ProductClasses
     *
     * @param  \Eccube\Entity\ProductClass $productClasses
     * @return Product
     */
    public function addProductClass(\Eccube\Entity\ProductClass $productClasses)
    {
        $this->ProductClasses[] = $productClasses;

        return $this;
    }

    /**
     * Remove ProductClasses
     *
     * @param \Eccube\Entity\ProductClass $productClasses
     */
    public function removeProductClass(\Eccube\Entity\ProductClass $productClasses)
    {
        $this->ProductClasses->removeElement($productClasses);
    }

    /**
     * Get ProductClasses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductClasses()
    {
        return $this->ProductClasses;
    }

    public function hasProductClass()
    {
        foreach ($this->ProductClasses as $ProductClass) {
            if (!is_null($ProductClass->getClassCategory1()) && $ProductClass->getDelFlg() == Constant::DISABLED) {
                return true;
            }
        }
        return false;
    }

	public function hasVideo(){
		if(!empty($this->getVideoUrl1())) return true;
		if(!empty($this->getVideoUrl2())) return true;
		if(!empty($this->getVideoUrl3())) return true;
		if(!empty($this->getVideoUrl4())) return true;
		if(!empty($this->getVideoUrl5())) return true;
		if(!empty($this->getVideoUrl6())) return true;
		if(!empty($this->getVideoUrl7())) return true;
		if(!empty($this->getVideoUrl8())) return true;
		if(!empty($this->getVideoUrl9())) return true;
		if(!empty($this->getVideoUrl10())) return true;
		if(!empty($this->getVideoUrl11())) return true;
		if(!empty($this->getVideoUrl12())) return true;
		if(!empty($this->getVideoUrl13())) return true;
		if(!empty($this->getVideoUrl14())) return true;
		if(!empty($this->getVideoUrl15())) return true;
		if(!empty($this->getVideoUrl16())) return true;
		if(!empty($this->getVideoUrl17())) return true;
		if(!empty($this->getVideoUrl18())) return true;
		if(!empty($this->getVideoUrl19())) return true;
		if(!empty($this->getVideoUrl20())) return true;

		if(!empty($this->getVideoTitle1())) return true;
		if(!empty($this->getVideoTitle2())) return true;
		if(!empty($this->getVideoTitle3())) return true;
		if(!empty($this->getVideoTitle4())) return true;
		if(!empty($this->getVideoTitle5())) return true;
		if(!empty($this->getVideoTitle6())) return true;
		if(!empty($this->getVideoTitle7())) return true;
		if(!empty($this->getVideoTitle8())) return true;
		if(!empty($this->getVideoTitle9())) return true;
		if(!empty($this->getVideoTitle10())) return true;
		if(!empty($this->getVideoTitle11())) return true;
		if(!empty($this->getVideoTitle12())) return true;
		if(!empty($this->getVideoTitle13())) return true;
		if(!empty($this->getVideoTitle14())) return true;
		if(!empty($this->getVideoTitle15())) return true;
		if(!empty($this->getVideoTitle16())) return true;
		if(!empty($this->getVideoTitle17())) return true;
		if(!empty($this->getVideoTitle18())) return true;
		if(!empty($this->getVideoTitle19())) return true;
		if(!empty($this->getVideoTitle20())) return true;

		if(!empty($this->getVideoText1())) return true;
		if(!empty($this->getVideoText2())) return true;
		if(!empty($this->getVideoText3())) return true;
		if(!empty($this->getVideoText4())) return true;
		if(!empty($this->getVideoText5())) return true;
		if(!empty($this->getVideoText6())) return true;
		if(!empty($this->getVideoText7())) return true;
		if(!empty($this->getVideoText8())) return true;
		if(!empty($this->getVideoText9())) return true;
		if(!empty($this->getVideoText10())) return true;
		if(!empty($this->getVideoText11())) return true;
		if(!empty($this->getVideoText12())) return true;
		if(!empty($this->getVideoText13())) return true;
		if(!empty($this->getVideoText14())) return true;
		if(!empty($this->getVideoText15())) return true;
		if(!empty($this->getVideoText16())) return true;
		if(!empty($this->getVideoText17())) return true;
		if(!empty($this->getVideoText18())) return true;
		if(!empty($this->getVideoText19())) return true;
		if(!empty($this->getVideoText20())) return true;

		
		if(!empty($this->getVideoComment())) return true;
		if(!empty($this->getVideoFile())) return true;
		if(!empty($this->getVideoUserId())) return true;
		if(!empty($this->getVideoUserPass())) return true;
		return false;
	}

    /**
     * Add CustomerFavoriteProducts
     *
     * @param  \Eccube\Entity\CustomerFavoriteProduct $customerFavoriteProducts
     * @return Product
     */
    public function addCustomerFavoriteProduct(\Eccube\Entity\CustomerFavoriteProduct $customerFavoriteProducts)
    {
        $this->CustomerFavoriteProducts[] = $customerFavoriteProducts;

        return $this;
    }

    /**
     * Remove CustomerFavoriteProducts
     *
     * @param \Eccube\Entity\CustomerFavoriteProduct $customerFavoriteProducts
     */
    public function removeCustomerFavoriteProduct(\Eccube\Entity\CustomerFavoriteProduct $customerFavoriteProducts)
    {
        $this->CustomerFavoriteProducts->removeElement($customerFavoriteProducts);
    }

    /**
     * Get CustomerFavoriteProducts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCustomerFavoriteProducts()
    {
        return $this->CustomerFavoriteProducts;
    }

    /**
     * Set Creator
     *
     * @param  \Eccube\Entity\Member $creator
     * @return Product
     */
    public function setCreator(\Eccube\Entity\Member $creator)
    {
        $this->Creator = $creator;

        return $this;
    }

    /**
     * Get Creator
     *
     * @return \Eccube\Entity\Member
     */
    public function getCreator()
    {
        if (EntityUtil::isEmpty($this->Creator)) {
            return null;
        }
        return $this->Creator;
    }

    /**
     * Set Status
     *
     * @param  \Eccube\Entity\Master\Disp $status
     * @return Product
     */
    public function setStatus(\Eccube\Entity\Master\Disp $status = null)
    {
        $this->Status = $status;

        return $this;
    }

    /**
     * Get Status
     *
     * @return \Eccube\Entity\Master\Disp
     */
    public function getStatus()
    {
        return $this->Status;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $ProductImage;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $ProductTag;


    /**
     * Add ProductImage
     *
     * @param \Eccube\Entity\ProductImage $productImage
     * @return Product
     */
    public function addProductImage(\Eccube\Entity\ProductImage $productImage)
    {
        $this->ProductImage[] = $productImage;

        return $this;
    }

    /**
     * Remove ProductImage
     *
     * @param \Eccube\Entity\ProductImage $productImage
     */
    public function removeProductImage(\Eccube\Entity\ProductImage $productImage)
    {
        $this->ProductImage->removeElement($productImage);
    }

    /**
     * Get ProductImage
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductImage()
    {
        return $this->ProductImage;
    }

    public function getMainFileName()
    {
        if (count($this->ProductImage) > 0) {
            return $this->ProductImage[0];
        } else {
            return null;
        }
    }

    /**
     * Add ProductTag
     *
     * @param \Eccube\Entity\ProductTag $productTag
     * @return Product
     */
    public function addProductTag(\Eccube\Entity\ProductTag $productTag)
    {
        $this->ProductTag[] = $productTag;

        return $this;
    }

    /**
     * Remove ProductTag
     *
     * @param \Eccube\Entity\ProductTag $productTag
     */
    public function removeProductTag(\Eccube\Entity\ProductTag $productTag)
    {
        $this->ProductTag->removeElement($productTag);
    }

    /**
     * Get ProductTag
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductTag()
    {
        return $this->ProductTag;
    }

    //▼動画配信
	public function setVideoUrl1($videoUrl1)
    {
        $this->video_url1 = $videoUrl1;

        return $this;
    }
    public function getVideoUrl1()
    {
        return $this->video_url1;
    }
	public function setVideoUrl2($videoUrl2)
    {
        $this->video_url2 = $videoUrl2;

        return $this;
    }
    public function getVideoUrl2()
    {
        return $this->video_url2;
    }
	public function setVideoUrl3($videoUrl3)
    {
        $this->video_url3 = $videoUrl3;

        return $this;
    }
    public function getVideoUrl3()
    {
        return $this->video_url3;
    }
	public function setVideoUrl4($videoUrl4)
    {
        $this->video_url4 = $videoUrl4;

        return $this;
    }
    public function getVideoUrl4()
    {
        return $this->video_url4;
    }
	public function setVideoUrl5($videoUrl5)
    {
        $this->video_url5 = $videoUrl5;

        return $this;
    }
    public function getVideoUrl5()
    {
        return $this->video_url5;
    }
	public function setVideoUrl6($videoUrl6)
    {
        $this->video_url6 = $videoUrl6;

        return $this;
    }
    public function getVideoUrl6()
    {
        return $this->video_url6;
    }
	public function setVideoUrl7($videoUrl7)
    {
        $this->video_url7 = $videoUrl7;

        return $this;
    }
    public function getVideoUrl7()
    {
        return $this->video_url7;
    }
	public function setVideoUrl8($videoUrl8)
    {
        $this->video_url8 = $videoUrl8;

        return $this;
    }
    public function getVideoUrl8()
    {
        return $this->video_url8;
    }
	public function setVideoUrl9($videoUrl9)
    {
        $this->video_url9 = $videoUrl9;

        return $this;
    }
    public function getVideoUrl9()
    {
        return $this->video_url9;
    }
	public function setVideoUrl10($videoUrl10)
    {
        $this->video_url10 = $videoUrl10;

        return $this;
    }
    public function getVideoUrl10()
    {
        return $this->video_url10;
    }
	public function setVideoUrl11($videoUrl11)
    {
        $this->video_url11 = $videoUrl11;

        return $this;
    }
    public function getVideoUrl11()
    {
        return $this->video_url11;
    }
	public function setVideoUrl12($videoUrl12)
    {
        $this->video_url12 = $videoUrl12;

        return $this;
    }
    public function getVideoUrl12()
    {
        return $this->video_url12;
    }
	public function setVideoUrl13($videoUrl13)
    {
        $this->video_url13 = $videoUrl13;

        return $this;
    }
    public function getVideoUrl13()
    {
        return $this->video_url13;
    }
	public function setVideoUrl14($videoUrl14)
    {
        $this->video_url14 = $videoUrl14;

        return $this;
    }
    public function getVideoUrl14()
    {
        return $this->video_url14;
    }
	public function setVideoUrl15($videoUrl15)
    {
        $this->video_url15 = $videoUrl15;

        return $this;
    }
    public function getVideoUrl15()
    {
        return $this->video_url15;
    }
	public function setVideoUrl16($videoUrl16)
    {
        $this->video_url16 = $videoUrl16;

        return $this;
    }
    public function getVideoUrl16()
    {
        return $this->video_url16;
    }
	public function setVideoUrl17($videoUrl17)
    {
        $this->video_url17 = $videoUrl17;

        return $this;
    }
    public function getVideoUrl17()
    {
        return $this->video_url17;
    }
	public function setVideoUrl18($videoUrl18)
    {
        $this->video_url18 = $videoUrl18;

        return $this;
    }
    public function getVideoUrl18()
    {
        return $this->video_url18;
    }
	public function setVideoUrl19($videoUrl19)
    {
        $this->video_url19 = $videoUrl19;

        return $this;
    }
    public function getVideoUrl19()
    {
        return $this->video_url19;
    }
	public function setVideoUrl20($videoUrl20)
    {
        $this->video_url20 = $videoUrl20;

        return $this;
    }
    public function getVideoUrl20()
    {
        return $this->video_url20;
    }

	public function setVideoTitle1($videoTitle1)
    {
        $this->video_title1 = $videoTitle1;

        return $this;
    }
    public function getVideoTitle1()
    {
        return $this->video_title1;
    }
	public function setVideoTitle2($videoTitle2)
    {
        $this->video_title2 = $videoTitle2;

        return $this;
    }
    public function getVideoTitle2()
    {
        return $this->video_title2;
    }
	public function setVideoTitle3($videoTitle3)
    {
        $this->video_title3 = $videoTitle3;

        return $this;
    }
    public function getVideoTitle3()
    {
        return $this->video_title3;
    }
	public function setVideoTitle4($videoTitle4)
    {
        $this->video_title4 = $videoTitle4;

        return $this;
    }
    public function getVideoTitle4()
    {
        return $this->video_title4;
    }
	public function setVideoTitle5($videoTitle5)
    {
        $this->video_title5 = $videoTitle5;

        return $this;
    }
    public function getVideoTitle5()
    {
        return $this->video_title5;
    }
	public function setVideoTitle6($videoTitle6)
    {
        $this->video_title6 = $videoTitle6;

        return $this;
    }
    public function getVideoTitle6()
    {
        return $this->video_title6;
    }
	public function setVideoTitle7($videoTitle7)
    {
        $this->video_title7 = $videoTitle7;

        return $this;
    }
    public function getVideoTitle7()
    {
        return $this->video_title7;
    }
	public function setVideoTitle8($videoTitle8)
    {
        $this->video_title8 = $videoTitle8;

        return $this;
    }
    public function getVideoTitle8()
    {
        return $this->video_title8;
    }
	public function setVideoTitle9($videoTitle9)
    {
        $this->video_title9 = $videoTitle9;

        return $this;
    }
    public function getVideoTitle9()
    {
        return $this->video_title9;
    }
	public function setVideoTitle10($videoTitle10)
    {
        $this->video_title10 = $videoTitle10;

        return $this;
    }
    public function getVideoTitle10()
    {
        return $this->video_title10;
    }
	public function setVideoTitle11($videoTitle11)
    {
        $this->video_title11 = $videoTitle11;

        return $this;
    }
    public function getVideoTitle11()
    {
        return $this->video_title11;
    }
	public function setVideoTitle12($videoTitle12)
    {
        $this->video_title12 = $videoTitle12;

        return $this;
    }
    public function getVideoTitle12()
    {
        return $this->video_title12;
    }
	public function setVideoTitle13($videoTitle13)
    {
        $this->video_title13 = $videoTitle13;

        return $this;
    }
    public function getVideoTitle13()
    {
        return $this->video_title13;
    }
	public function setVideoTitle14($videoTitle14)
    {
        $this->video_title14 = $videoTitle14;

        return $this;
    }
    public function getVideoTitle14()
    {
        return $this->video_title14;
    }
	public function setVideoTitle15($videoTitle15)
    {
        $this->video_title15 = $videoTitle15;

        return $this;
    }
    public function getVideoTitle15()
    {
        return $this->video_title15;
    }
	public function setVideoTitle16($videoTitle16)
    {
        $this->video_title16 = $videoTitle16;

        return $this;
    }
    public function getVideoTitle16()
    {
        return $this->video_title16;
    }
	public function setVideoTitle17($videoTitle17)
    {
        $this->video_title17 = $videoTitle17;

        return $this;
    }
    public function getVideoTitle17()
    {
        return $this->video_title17;
    }
	public function setVideoTitle18($videoTitle18)
    {
        $this->video_title18 = $videoTitle18;

        return $this;
    }
    public function getVideoTitle18()
    {
        return $this->video_title18;
    }
	public function setVideoTitle19($videoTitle19)
    {
        $this->video_title19 = $videoTitle19;

        return $this;
    }
    public function getVideoTitle19()
    {
        return $this->video_title19;
    }
	public function setVideoTitle20($videoTitle20)
    {
        $this->video_title20 = $videoTitle20;

        return $this;
    }
    public function getVideoTitle20()
    {
        return $this->video_title20;
    }

	public function setVideoText1($videoText1)
    {
        $this->video_text1 = $videoText1;

        return $this;
    }
    public function getVideoText1()
    {
        return $this->video_text1;
    }
	public function setVideoText2($videoText2)
    {
        $this->video_text2 = $videoText2;

        return $this;
    }
    public function getVideoText2()
    {
        return $this->video_text2;
    }
	public function setVideoText3($videoText3)
    {
        $this->video_text3 = $videoText3;

        return $this;
    }
    public function getVideoText3()
    {
        return $this->video_text3;
    }
	public function setVideoText4($videoText4)
    {
        $this->video_text4 = $videoText4;

        return $this;
    }
    public function getVideoText4()
    {
        return $this->video_text4;
    }
	public function setVideoText5($videoText5)
    {
        $this->video_text5 = $videoText5;

        return $this;
    }
    public function getVideoText5()
    {
        return $this->video_text5;
    }
	public function setVideoText6($videoText6)
    {
        $this->video_text6 = $videoText6;

        return $this;
    }
    public function getVideoText6()
    {
        return $this->video_text6;
    }
	public function setVideoText7($videoText7)
    {
        $this->video_text7 = $videoText7;

        return $this;
    }
    public function getVideoText7()
    {
        return $this->video_text7;
    }
	public function setVideoText8($videoText8)
    {
        $this->video_text8 = $videoText8;

        return $this;
    }
    public function getVideoText8()
    {
        return $this->video_text8;
    }
	public function setVideoText9($videoText9)
    {
        $this->video_text9 = $videoText9;

        return $this;
    }
    public function getVideoText9()
    {
        return $this->video_text9;
    }
	public function setVideoText10($videoText10)
    {
        $this->video_text10 = $videoText10;

        return $this;
    }
    public function getVideoText10()
    {
        return $this->video_text10;
    }
	public function setVideoText11($videoText11)
    {
        $this->video_text11 = $videoText11;

        return $this;
    }
    public function getVideoText11()
    {
        return $this->video_text11;
    }
	public function setVideoText12($videoText12)
    {
        $this->video_text12 = $videoText12;

        return $this;
    }
    public function getVideoText12()
    {
        return $this->video_text12;
    }
	public function setVideoText13($videoText13)
    {
        $this->video_text13 = $videoText13;

        return $this;
    }
    public function getVideoText13()
    {
        return $this->video_text13;
    }
	public function setVideoText14($videoText14)
    {
        $this->video_text14 = $videoText14;

        return $this;
    }
    public function getVideoText14()
    {
        return $this->video_text14;
    }
	public function setVideoText15($videoText15)
    {
        $this->video_text15 = $videoText15;

        return $this;
    }
    public function getVideoText15()
    {
        return $this->video_text15;
    }
	public function setVideoText16($videoText16)
    {
        $this->video_text16 = $videoText16;

        return $this;
    }
    public function getVideoText16()
    {
        return $this->video_text16;
    }
	public function setVideoText17($videoText17)
    {
        $this->video_text17 = $videoText17;

        return $this;
    }
    public function getVideoText17()
    {
        return $this->video_text17;
    }
	public function setVideoText18($videoText18)
    {
        $this->video_text18 = $videoText18;

        return $this;
    }
    public function getVideoText18()
    {
        return $this->video_text18;
    }
	public function setVideoText19($videoText19)
    {
        $this->video_text19 = $videoText19;

        return $this;
    }
    public function getVideoText19()
    {
        return $this->video_text19;
    }
	public function setVideoText20($videoText20)
    {
        $this->video_text20 = $videoText20;

        return $this;
    }
    public function getVideoText20()
    {
        return $this->video_text20;
    }

	public function setVideoComment($videoComment)
    {
        $this->video_comment = $videoComment;

        return $this;
    }
    public function getVideoComment()
    {
        return $this->video_comment;
    }

	public function setVideoFile($videoFile)
    {
        $this->video_file = $videoFile;

        return $this;
    }
    public function getVideoFile()
    {
        return $this->video_file;
    }

	public function setVideoUserid($videoUserid)
    {
        $this->video_userid = $videoUserid;

        return $this;
    }
    public function getVideoUserid()
    {
        return $this->video_userid;
    }

	public function setVideoUserpass($VideoUserpass)
    {
        $this->video_userpass = $VideoUserpass;

        return $this;
    }
    public function getVideoUserpass()
    {
        return $this->video_userpass;
    }

}
