<?php

namespace Plugin\EccubePaymentLite3\Entity\Extension;

use Eccube\Entity\AbstractEntity;

class ProductExtension extends AbstractEntity
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $product_id;

    /**
     * @var string
     */
    private $free_description_quantity;

    /**
     * @var string
     */
    private $free_description_selling_price;

    /**
     * @var string
     */
    private $free_description_payment_delivery;

    /**
     * Set id
     *
     * @param integer $id
     * @return OrderExtension
     */
    public function setId($id)
    {
        $this->id = $id;

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
     * @return string
     */
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * @param string $product_id
     */
    public function setProductId($product_id)
    {
        $this->product_id = $product_id;
    }

    /**
     * @return string
     */
    public function getFreeDescriptionQuantity()
    {
        return $this->free_description_quantity;
    }

    /**
     * @param string $free_description_quantity
     */
    public function setFreeDescriptionQuantity($free_description_quantity)
    {
        $this->free_description_quantity = $free_description_quantity;
    }

    /**
     * @return string
     */
    public function getFreeDescriptionSellingPrice()
    {
        return $this->free_description_selling_price;
    }

    /**
     * @param string $free_description_selling_price
     */
    public function setFreeDescriptionSellingPrice($free_description_selling_price)
    {
        $this->free_description_selling_price = $free_description_selling_price;
    }

    /**
     * @return string
     */
    public function getFreeDescriptionPaymentDelivery()
    {
        return $this->free_description_payment_delivery;
    }

    /**
     * @param string $free_description_payment_delivery
     */
    public function setFreeDescriptionPaymentDelivery($free_description_payment_delivery)
    {
        $this->free_description_payment_delivery = $free_description_payment_delivery;
    }

}
