<?php

namespace Plugin\EccubePaymentLite3\Entity\Extension;

use Eccube\Entity\AbstractEntity;
use Plugin\EccubePaymentLite3\Entity\Master\DeliveryCompany;

class DeliveryExtension extends AbstractEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var DeliveryCompany
     */
    private $DeliveryCompany;

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
     * Set DeliveryCompany
     *
     * @param DeliveryCompany $DeliveryCompany
     * @return self
     */
    public function setDeliveryCompany(DeliveryCompany $DeliveryCompany)
    {
        $this->DeliveryCompany = $DeliveryCompany;

        return $this;
    }

    /**
     * Get DeliveryCompany
     *
     * @return DeliveryCompany
     */
    public function getDeliveryCompany()
    {
        return $this->DeliveryCompany;
    }
}
