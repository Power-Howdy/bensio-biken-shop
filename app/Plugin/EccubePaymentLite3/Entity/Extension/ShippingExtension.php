<?php

namespace Plugin\EccubePaymentLite3\Entity\Extension;

use Eccube\Entity\AbstractEntity;

class ShippingExtension extends AbstractEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $tracking_number;

    /**
     * Set id
     *
     * @param integer $id
     * @return self
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
     * Set Tracking Number
     *
     * @param  string $tracking_number
     * @return self
     */
    public function setTrackingNumber($tracking_number)
    {
        $this->tracking_number = $tracking_number;

        return $this;
    }

    /**
     * Get Tracking Number
     *
     * @return string
     */
    public function getTrackingNumber()
    {
        return $this->tracking_number;
    }
}
