<?php

/*
* This file is part of EC-CUBE
*
* Copyright(c) 2000-2016 LOCKON CO.,LTD. All Rights Reserved.
* http://www.lockon.co.jp/
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
namespace Plugin\Point\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Point
 * @package Plugin\Point\Entity
 */
class Point extends \Eccube\Entity\AbstractEntity
{
    /**
     * @var integer
     */
    private $plg_point_id;
    /**
     * @var integer
     */
    private $plg_dynamic_point;
    /**
     * @var integer
     */
    private $order_id;
    /**
     * @var integer
     */
    private $customer_id;
    /**
     * @var integer
     */
    private $plg_point_info_id;
    /**
     * @var \Eccube\Entity\Order
     */
    private $Order;
    /**
     * @var \Eccube\Entity\Customer
     */
    private $Customer;
    /**
     * @var smallint
     */
    private $plg_point_type;
    /**
     * @var string
     */
    private $plg_point_action_name;
    /**
     * @var \Plugin\Point\Entity\PointProductRate
     */
    private $PointProductRate;
    /**
     * @var \Plugin\Point\Entity\PointInfo
     */
    private $PointInfo;
    /**
     * @var timestamp
     */
    private $create_date;
    /**
     * @var timestamp
     */
    private $update_date;

    /**
     * Set plg_point_id
     *
     * @param integer $plg_point_id
     * @return Point
     */
    public function setPlgPointId($plg_point_id)
    {
        $this->plg_point_id = $plg_point_id;

        return $this;
    }

    /**
     * Get plg_point_id
     *
     * @return integer
     */
    public function getPlgPointId()
    {
        return $this->plg_point_id;
    }

    /**
     * Set order_id
     *
     * @param integer $order_id
     * @return Point
     */
    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;

        return $this;
    }

    /**
     * Get order_id
     *
     * @return integer
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * Set customer_id
     *
     * @param integer $customer_id
     * @return Point
     */
    public function setCustomerId($customer_id)
    {
        $this->customer_id = $customer_id;

        return $this;
    }

    /**
     * Get customer_id
     *
     * @return integer
     */
    public function getCustomerId()
    {
        return $this->customer_id;
    }

    /**
     * Set plg_point_info_id
     *
     * @param integer $plg_point_info_id
     * @return Point
     */
    public function setPlgPointInfoId($plg_point_info_id)
    {
        $this->plg_point_info_id = $plg_point_info_id;

        return $this;
    }

    /**
     * Get plg_point_info_id
     *
     * @return integer
     */
    public function getPlgPointInfoId()
    {
        return $this->plg_point_info_id;
    }

    /**
     * Set plg_dynamic_point
     *
     * @param integer $plg_dynamic_point
     * @return Point
     */
    public function setPlgDynamicPoint($plg_dynamic_point)
    {
        $this->plg_dynamic_point = $plg_dynamic_point;

        return $this;
    }

    /**
     * Get plg_dynamic_point
     *
     * @return integer
     */
    public function getPlgDynamicPoint()
    {
        return $this->plg_dynamic_point;
    }

    /**
     * Set Order
     *
     * @param \Eccube\Entity\Order $Order
     * @return Point
     */
    public function setOrder($Order)
    {
        $this->Order = $Order;

        return $this;
    }

    /**
     * Get Order
     *
     * @return \Eccube\Entity\Order
     */
    public function getOrder()
    {
        return $this->Order;
    }

    /**
     * Set Customer
     *
     * @param \Eccube\Entity\Customer $Customer
     * @return Point
     */
    public function setCustomer($Customer)
    {
        $this->Customer = $Customer;

        return $this;
    }

    /**
     * Get Customer
     *
     * @return \Eccube\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->Customer;
    }

    /**
     * Set plg_point_type
     *
     * @param smallint
     * @return Point
     */
    public function setPlgPointType($plg_point_type)
    {
        $this->plg_point_type = $plg_point_type;

        return $this;
    }

    /**
     * Get plg_point_type
     *
     * @return smallint
     */
    public function getPlgPointType()
    {
        return $this->plg_point_type;
    }

    /**
     * Set plg_point_action_name
     *
     * @param string
     * @return Point
     */
    public function setPlgPointActionName($plg_point_action_name)
    {
        $this->plg_point_action_name = $plg_point_action_name;

        return $this;
    }

    /**
     * Get plg_point_action_name
     *
     * @return string
     */
    public function getPlgPointActionName()
    {
        return $this->plg_point_action_name;
    }

    /**
     * Set PointProductRate
     *
     * @param \Plugin\Point\Entity\PointProductRate
     * @return Point
     */
    public function setPointProductRate($PointProductRate)
    {
        $this->PointProductRate = $PointProductRate;

        return $this;
    }

    /**
     * Get PointProductRate
     *
     * @return \Plugin\Point\Entity\PointProductRate
     */
    public function getPointProductRate()
    {
        return $this->PointProductRate;
    }

    /**
     * Set PointInfo
     *
     * @param Eccube\Plugin\Point\Entity\PointInfo
     * @return Point
     */
    public function setPointInfo($PointInfo)
    {
        $this->PointInfo = $PointInfo;

        return $this;
    }

    /**
     * Get PointInfo
     *
     * @return \Plugin\Point\Entity\PointInfo
     */
    public function getPointInfo()
    {
        return $this->PointInfo;
    }

    /**
     * Set create_date
     *
     * @param integer $create_date
     * @return Point
     */
    public function setCreateDate($create_date)
    {
        $this->create_date = $create_date;

        return $this;
    }

    /**
     * Get create_date
     *
     * @return Point
     */
    public function getCreateDate()
    {
        return $this->create_date;
    }

    /**
     * Set update_date
     *
     * @param integer $update_date
     * @return Point
     */
    public function setUpdateDate($update_date)
    {
        $this->update_date = $update_date;

        return $this;
    }

    /**
     * Get update_date
     *
     * @return Point
     */
    public function getUpdateDate()
    {
        return $this->update_date;
    }
}
