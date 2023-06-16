<?php



namespace Plugin\EccubePaymentLite3\Entity;

use Eccube\Entity\AbstractEntity;
use Eccube\Entity\BaseInfo;
use Eccube\Entity\Product;
use Eccube\Entity\ProductClass;
use Eccube\Util\EntityUtil;
use Exception;

/**
 * OrderDetail
 */
class RegularOrderDetail extends AbstractEntity
{
    private $price_inc_tax = null;

    public function isPriceChange()
    {
        if (!$this->getProductClass()) {
            return true;
        } elseif ($this->getProductClass()->getPrice02IncTax() === $this->getPriceIncTax()) {
            return false;
        } else {
            return true;
        }
    }

    public function isEnable()
    {
        if ($this->getProductClass() && $this->getProductClass()->isEnable()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param BaseInfo
     * @return bool
     * @throws Exception
     */
    public function isEffective(BaseInfo $BaseInfo)
    {
        $downloable = clone $this->getOrder()->getPaymentDate();
        if ($BaseInfo->getDownloadableDays()) {
            $downloable->add(new \DateInterval("P" . $BaseInfo->getDownloadableDays() . "D"));
        }

        if ($BaseInfo->getDownloadableDaysUnlimited() === 1 && $this->getOrder()->getPaymentDate()) {
            return true;
        } elseif (new \DateTime() <= $downloable) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function isDownloadable()
    {
        // 販売価格が 0 円
        if ($this->getPrice() === 0) {
            return true;
        }
        // ダウンロード期限内かつ, 入金日あり
        elseif ($this->isEffective()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Set price IncTax
     *
     * @param string $price_inc_tax
     * @return RegularOrderDetail
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
     * @var string
     */
    private $tax_rate;

    /**
     * @var integer
     */
    private $tax_rule;

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
     * @param  string      $productName
     * @return RegularOrderDetail
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
     * @param  string      $productCode
     * @return RegularOrderDetail
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
     * @param  string      $classCategoryName1
     * @return RegularOrderDetail
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
     * @param  string      $classCategoryName2
     * @return RegularOrderDetail
     */
    public function setClassCategoryName2($classCategoryName2)
    {
        $this->class_category_name2 = $classCategoryName2;

        return $this;
    }

    /**
     * Get classcategory_name2
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
     * @param  string      $price
     * @return RegularOrderDetail
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
     * @param  string      $quantity
     * @return RegularOrderDetail
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
     * Set tax_rate
     *
     * @param  string      $taxRate
     * @return RegularOrderDetail
     */
    public function setTaxRate($taxRate)
    {
        $this->tax_rate = $taxRate;

        return $this;
    }

    /**
     * Get tax_rate
     *
     * @return string
     */
    public function getTaxRate()
    {
        return $this->tax_rate;
    }

    /**
     * Set tax_rule
     *
     * @param  integer     $taxRule
     * @return RegularOrderDetail
     */
    public function setTaxRule($taxRule)
    {
        $this->tax_rule = $taxRule;

        return $this;
    }

    /**
     * Get tax_rule
     *
     * @return integer
     */
    public function getTaxRule()
    {
        return $this->tax_rule;
    }

    /**
     * Set Order
     *
     * @param RegularOrder $regularOrder
     * @return RegularOrderDetail
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
     * @param  Product $product
     * @return RegularOrderDetail
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
     * @param  ProductClass $productClass
     * @return RegularOrderDetail
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
     * @return RegularOrderDetail
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
     * @return RegularOrderDetail
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
