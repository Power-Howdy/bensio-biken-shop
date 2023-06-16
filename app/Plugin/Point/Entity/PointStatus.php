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
 * Class PointStatus
 * @package Plugin\PointStatus\Entity
 */
class PointStatus extends \Eccube\Entity\AbstractEntity
{
    /**
     * @var integer
     */
    private $point_status_id;
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
    private $status;
    /**
     * @var integer
     */
    private $del_flg;
    /**
     * @var timestamp
     */
    private $point_fix_date;

    /**
     * Set point_status_id
     *
     * @param integer $point_status_id
     * @return PointStatus
     */
    public function setPlgPointStatusId($point_status_id)
    {
        $this->point_status_id = $point_status_id;

        return $this;
    }

    /**
     * Get point_status_id
     *
     * @return integer
     */
    public function getPlgPointStatusId()
    {
        return $this->point_status_id;
    }

    /**
     * Set order_id
     *
     * @param integer $order_id
     * @return PointStatus
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
     * @return PointStatus
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
     * Set status
     *
     * @param integer $status
     * @return PointStatus
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set del_flg
     *
     * @param integer $del_flg
     * @return PointStatus
     */
    public function setDelFlg($del_flg)
    {
        $this->del_flg = $del_flg;

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
     * Set point_fix_date
     *
     * @param datetime $point_fix_date
     * @return PointStatus
     */
    public function setPointFixDate($point_fix_date)
    {
        $this->point_fix_date = $point_fix_date;

        return $this;
    }

    /**
     * Get point_fix_date
     *
     * @return datetime
     */
    public function getPointFixDate()
    {
        return $this->point_fix_date;
    }
}
