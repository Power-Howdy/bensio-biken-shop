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
 * Class PointSnapshot
 * @package Plugin\Point\Entity
 */
class PointSnapshot extends \Eccube\Entity\AbstractEntity
{
    /**
     * @var integer
     */
    private $plg_point_snapshot_id;
    /**
     * @var integer
     */
    private $plg_point_use;
    /**
     * @var integer
     */
    private $plg_point_current;
    /**
     * @var integer
     */
    private $plg_point_add;
    /**
     * @var string
     */
    private $plg_point_snap_action_name;
    /**
     * @var integer
     */
    private $order_id;
    /**
     * @var integer
     */
    private $customer_id;
    /**
     * @var \Eccube\Entity\Order
     */
    private $Order;
    /**
     * @var \Eccube\Entity\Custmer
     */
    private $Customer;
    /**
     * @var date
     */
    private $create_date;
    /**
     * @var date
     */
    private $update_date;

    /**
     * Set plg_point_snapshot_id
     *
     * @param integer $plg_point_snapshot_id
     * @return PointSnapshot
     */
    public function setPlgPointSnapshotId($plg_point_snapshot_id)
    {
        $this->plg_point_snapshot_id = $plg_point_snapshot_id;

        return $this;
    }

    /**
     * Get plg_point_snapshot_id
     * @return integer $plg_point_snapshot_id
     */
    public function getPlgPointSnapshotId()
    {
        return $this->plg_point_snapshot_id;
    }

    /**
     * Set plg_point_use
     *
     * @param integer $plg_point_use
     * @return PointSnapshot
     */
    public function setPlgPointUse($plg_point_use)
    {
        $this->plg_point_use = $plg_point_use;

        return $this;
    }

    /**
     * Get plg_point_use
     * @return integer $plg_point_use
     */
    public function getPlgPointUse()
    {
        return $this->plg_point_use;
    }

    /**
     * Set plg_point_current
     *
     * @param integer $plg_point_current
     * @return PointSnapshot
     */
    public function setPlgPointCurrent($plg_point_current)
    {
        $this->plg_point_current = $plg_point_current;

        return $this;
    }

    /**
     * Get plg_point_current
     * @return integer $plg_point_current
     */
    public function getPlgPointCurrent()
    {
        return $this->plg_point_current;
    }

    /**
     * Set plg_point_add
     *
     * @param integer $plg_point_add
     * @return PointSnapshot
     */
    public function setPlgPointAdd($plg_point_add)
    {
        $this->plg_point_add = $plg_point_add;

        return $this;
    }

    /**
     * Get plg_point_add
     * @return integer $plg_point_add
     */
    public function getPlgPointAdd()
    {
        return $this->plg_point_add;
    }

    /**
     * Set plg_point_snap_action_name
     *
     * @param string $plg_point_snap_action_name
     * @return PointSnapshot
     */
    public function setPlgPointSnapActionName($plg_point_snap_action_name)
    {
        $this->plg_point_snap_action_name = $plg_point_snap_action_name;

        return $this;
    }

    /**
     * Get plg_point_snap_action_name
     * @return string $plg_point_snap_action_name
     */
    public function getPlgPointSnapActionName()
    {
        return $this->plg_point_snap_action_name;
    }

    /**
     * Set order_id
     *
     * @param integer $order_id
     * @return PointSnapshot
     */
    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;

        return $this;
    }

    /**
     * Get order_id
     * @return integer $order_id
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * Set customer_id
     *
     * @param integer $customer_id
     * @return PointSnapshot
     */
    public function setCustomerId($customer_id)
    {
        $this->customer_id = $customer_id;

        return $this;
    }

    /**
     * Get customer_id
     * @return integer $customer_id
     */
    public function getCustomerId()
    {
        return $this->customer_id;
    }

    /**
     * Set Order
     *
     * @param \Eccube\Entity\Order $Order
     * @return PointSnapshot
     */
    public function setOrder($Order)
    {
        $this->Order = $Order;

        return $this;
    }

    /**
     * Get Order
     * @return \Eccube\Entity\Order $Order
     */
    public function getOrder()
    {
        return $this->Order;
    }

    /**
     * Set Customer
     *
     * @param \Eccube\Entity\Customer $Customer
     * @return PointSnapshot
     */
    public function setCustomer($Customer)
    {
        $this->Customer = $Customer;

        return $this;
    }

    /**
     * Get Customer
     * @return \Eccube\Entity\Customer $Customer
     */
    public function getCustomer()
    {
        return $this->Customer;
    }

    /**
     * Set create_date
     *
     * @param timestamp $create_date
     * @return PointSnapshot
     */
    public function setCreateDate($create_date)
    {
        $this->create_date = $create_date;

        return $this;
    }

    /**
     * Get create_date
     * @return tmestamp create_date
     */
    public function getCreateDate()
    {
        return $this->create_date;
    }

    /**
     * Set update_date
     *
     * @param timestamp $update_date
     * @return PointSnapshot
     */
    public function setUpdateDate($update_date)
    {
        $this->update_date = $update_date;

        return $this;
    }

    /**
     * Get update_date
     * @return tmestamp update_date
     */
    public function getUpdateDate()
    {
        return $this->update_date;
    }
}
