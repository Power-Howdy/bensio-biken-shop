<?php

namespace Plugin\EccubePaymentLite3\Entity;

use Eccube\Entity\AbstractEntity;

class CreditAccessBlock extends AbstractEntity
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
    private $block_date;


    /**
     * Set id
     *
     * @param integer $id
     * @return CreditAccessBlock
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
     * @return CreditAccessBlock
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
     * Set block_date
     *
     * @param /DateTime $block_date
     * @return CreditAccessBlock
     */
    public function setBlockDate($blockDate)
    {
        $this->block_date = $blockDate;

        return $this;
    }

    /**
     * Get block_date
     *
     * @return \DateTime
     */
    public function getBlockDate()
    {
        return $this->block_date;
    }


}
