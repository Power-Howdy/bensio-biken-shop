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
 * Class PointAbuse
 * @package Plugin\PointStatus\Entity
 */
class PointAbuse extends \Eccube\Entity\AbstractEntity
{
    /**
     * @var integer
     */
    private $point_abuse_id;
    /**
     * @var integer
     */
    private $order_id;

    /**
     * PointAbuse constructor.
     * @param int $order_id
     */
    public function __construct($order_id)
    {
        $this->order_id = $order_id;
    }

    /**
     * Set point_status_id
     *
     * @param int $point_abuse_id
     * @return PointStatus
     */
    public function setPlgPointAbuseId($point_abuse_id)
    {
        $this->point_abuse_id = $point_abuse_id;

        return $this;
    }

    /**
     * Get point_abuse_id
     *
     * @return integer
     */
    public function getPlgPointAbuseId()
    {
        return $this->point_abuse_id;
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
}
