<?php

namespace Plugin\EccubePaymentLite3\Entity;

use Eccube\Entity\AbstractEntity;
use Eccube\Entity\Product;
use Eccube\Entity\ProductClass;
use Eccube\Util\EntityUtil;

/**
 * RegularShipmentItem
 */
class RegularShipmentItem extends AbstractEntity
{
    private $price_inc_tax = null;

    /**
     * Set price IncTax
     *
     * @param string $price_inc_tax
     * @return RegularShipmentItem
     */
    public function setPriceIncTax($price_inc_tax)
    {
        $this->price_inc_tax = $price_inc_tax;

        return $this;
    }

    /**
     * Get price IncTax
     *
     * @return string
     */
    public function getPriceIncTax()
    {
        return $this->price_inc_tax;
    }

    /**
     * @return integer
     */
    public function getTotalPrice()
    {
        return $this->getPriceIncTax() * $this->getQuantity();
    }

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $product_name;

    /**
     * @var string
     */
    private $product_code;

    /**
     * @var string
     */
    private $class_category_name1;

    /**
     * @var string
     */
    private $class_category_name2;

    /**
     * @var string
     */
    private $price;

    /**
     * @var string
     */
    private $quantity;

    /**
     * @var RegularOrder
     */
    private $RegularOrder;

    /**
     * @var Product
     */
    private $Product;

    /**
     * @var ProductClass
     */
    private $ProductClass;

    /**
     * @var RegularShipping
     */
    private $RegularShipping;


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
     * Set product_name
     *
     * @param string $productName
     * @return RegularShipmentItem
     */
    public function setProductName($productName)
    {
        $this->product_name = $productName;

        return $this;
    }

    /**
     * Get product_name
     *
     * @return string
     */
    public function getProductName()
    {
        return $this->product_name;
    }

    /**
     * Set product_code
     *
     * @param string $productCode
     * @return RegularShipmentItem
     */
    public function setProductCode($productCode)
    {
        $this->product_code = $productCode;

        return $this;
    }

    /**
     * Get product_code
     *
     * @return string
     */
    public function getProductCode()
    {
        return $this->product_code;
    }

    /**
     * Set class_category_name1
     *
     * @param string $classCategoryName1
     * @return RegularShipmentItem
     */
    public function setClassCategoryName1($classCategoryName1)
    {
        $this->class_category_name1 = $classCategoryName1;

        return $this;
    }

    /**
     * Get class_category_name1
     *
     * @return string
     */
    public function getClassCategoryName1()
    {
        return $this->class_category_name1;
    }

    /**
     * Set class_category_name2
     *
     * @param string $classCategoryName2
     * @return RegularShipmentItem
     */
    public function setClassCategoryName2($classCategoryName2)
    {
        $this->class_category_name2 = $classCategoryName2;

        return $this;
    }

    /**
     * Get class_category_name2
     *
     * @return string
     */
    public function getClassCategoryName2()
    {
        return $this->class_category_name2;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return RegularShipmentItem
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set quantity
     *
     * @param string $quantity
     * @return RegularShipmentItem
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set RegularOrder
     *
     * @param RegularOrder $regularOrder
     * @return RegularShipmentItem
     */
    public function setRegularOrder(RegularOrder $regularOrder)
    {
        $this->RegularOrder = $regularOrder;

        return $this;
    }

    /**
     * Get RegularOrder
     *
     * @return RegularOrder
     */
    public function getRegularOrder()
    {
        return $this->RegularOrder;
    }

    /**
     * Set Product
     *
     * @param Product $product
     * @return RegularShipmentItem
     */
    public function setProduct(Product $product)
    {
        $this->Product = $product;

        return $this;
    }

    /**
     * Get Product
     *
     * @return Product
     */
    public function getProduct()
    {
        if (EntityUtil::isEmpty($this->Product)) {
            return null;
        }
        return $this->Product;
    }

    /**
     * Set ProductClass
     *
     * @param ProductClass $productClass
     * @return RegularShipmentItem
     */
    public function setProductClass(ProductClass $productClass)
    {
        $this->ProductClass = $productClass;

        return $this;
    }

    /**
     * Get ProductClass
     *
     * @return ProductClass
     */
    public function getProductClass()
    {
        return $this->ProductClass;
    }

    /**
     * @param RegularShipping $regularShipping
     * @return RegularShipmentItem
     */
    public function setRegularShipping(RegularShipping $regularShipping)
    {
        $this->RegularShipping = $regularShipping;

        return $this;
    }

    /**
     * Get RegularShipping
     *
     * @return RegularShipping
     */
    public function getRegularShipping()
    {
        return $this->RegularShipping;
    }
    /**
     * @var string
     */
    private $class_name1;

    /**
     * @var string
     */
    private $class_name2;


    /**
     * Set class_name1
     *
     * @param string $className1
     * @return RegularShipmentItem
     */
    public function setClassName1($className1)
    {
        $this->class_name1 = $className1;

        return $this;
    }

    /**
     * Get class_name1
     *
     * @return string
     */
    public function getClassName1()
    {
        return $this->class_name1;
    }

    /**
     * Set class_name2
     *
     * @param string $className2
     * @return RegularShipmentItem
     */
    public function setClassName2($className2)
    {
        $this->class_name2 = $className2;

        return $this;
    }

    /**
     * Get class_name2
     *
     * @return string
     */
    public function getClassName2()
    {
        return $this->class_name2;
    }
}
