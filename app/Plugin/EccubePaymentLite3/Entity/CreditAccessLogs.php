<?php

namespace Plugin\EccubePaymentLite3\Entity;

use Eccube\Entity\AbstractEntity;

class CreditAccessLogs extends AbstractEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $ip_address;

    /**
     * @var /DateTime
     */
    private $access_date;


    /**
     * Set id
     *
     * @param integer $id
     * @return CreditAccessLogs
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
     * Set ip_address
     *
     * @param string $id
     * @return CreditAccessLogs
     */
    public function setIpAddress($ipAddress)
    {
        $this->ip_address = $ipAddress;

        return $this;
    }

    /**
     * Get ip_address
     *
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ip_address;
    }

    /**
     * Set access_date
     *
     * @param /DateTime $access_date
     * @return CreditAccessLogs
     */
    public function setAccessDate($accessDate)
    {
        $this->access_date = $accessDate;

        return $this;
    }

    /**
     * Get access_date
     *
     * @return \DateTime
     */
    public function getAccessDate()
    {
        return $this->access_date;
    }


}
