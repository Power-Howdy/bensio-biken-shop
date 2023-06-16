<?php

namespace Plugin\EccubePaymentLite3\Entity;

use Eccube\Entity\AbstractEntity;

class RegularProduct extends AbstractEntity
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $product_type_id;

    /**
     * @var integer
     */
    private $regular_flg;

    /**
     * @var integer
     */
    private $create_flg;

    /**
     * @var /DateTime
     */
    private $create_date;

    /**
     * @var /DateTime
     */
    private $update_date;


    /**
     * Set id
     *
     * @param integer $id
     * @return RegularProduct
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
     * Set product_type_id
     *
     * @param integer $productTypeId
     * @return RegularProduct
     */
    public function setProductTypeId($productTypeId)
    {
        $this->product_type_id = $productTypeId;

        return $this;
    }

    /**
     * Get product_type_id
     *
     * @return integer
     */
    public function getProductTypeId()
    {
        return $this->product_type_id;
    }

    /**
     * Set regular_flg
     *
     * @param integer $regularFlg
     * @return RegularProduct
     */
    public function setRegularFlg($regularFlg)
    {
        $this->regular_flg = $regularFlg;

        return $this;
    }

    /**
     * Get regular_flg
     *
     * @return integer
     */
    public function getRegularFlg()
    {
        return $this->regular_flg;
    }

    /**
     * Set create_flg
     *
     * @param integer $createFlg
     * @return RegularProduct
     */
    public function setCreateFlg($createFlg)
    {
        $this->create_flg = $createFlg;

        return $this;
    }

    /**
     * Get create_flg
     *
     * @return integer
     */
    public function getCreateFlg()
    {
        return $this->create_flg;
    }

    /**
     * Set create_date
     *
     * @param /DateTime $createDate
     * @return RegularProduct
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
     * @param /DateTime $updateDate
     * @return RegularProduct
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


}
