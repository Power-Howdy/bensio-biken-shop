<?php

namespace Plugin\EccubePaymentLite3\Entity;


use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Information about EccubePaymentLite3 module
 * (substitution for dtb_module of Eccube 2)
 */
class GmoEpsilonPlugin extends \Eccube\Entity\AbstractEntity
{
    const ENVIRONMENTAL_SETTING_DEVELOPMENT = 1;
    const ENVIRONMENTAL_SETTING_PRODUCTION = 2;
    const LINK_PAYMENT = 1;
    const TOKEN_PAYMENT = 2;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $sub_data;

    /**
     * @var integer
     */
    private $auto_update_flg;

    /**
     * @var integer
     */
    private $del_flg;

    /**
     * @var DateTime
     */
    private $create_date;

    /**
     * @var DateTime
     */
    private $update_date;

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
     * Set code
     *
     * @param string $code
     * @return GmoEpsilonPlugin
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return GmoEpsilonPlugin
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set sub_data
     *
     * @param string $subData
     * @return GmoEpsilonPlugin
     */
    public function setSubData($subData)
    {
        $this->sub_data = $subData;

        return $this;
    }

    /**
     * Get sub_data
     *
     * @return string
     */
    public function getSubData()
    {
        return $this->sub_data;
    }

    /**
     * Set auto_update_flg
     *
     * @param integer $autoUpdateFlg
     * @return GmoEpsilonPlugin
     */
    public function setAutoUpdateFlg($autoUpdateFlg)
    {
        $this->auto_update_flg = $autoUpdateFlg;

        return $this;
    }

    /**
     * Get auto_update_flg
     *
     * @return integer
     */
    public function getAutoUpdateFlg()
    {
        return $this->auto_update_flg;
    }

    /**
     * Set del_flg
     *
     * @param integer $delFlg
     * @return GmoEpsilonPlugin
     */
    public function setDelFlg($delFlg)
    {
        $this->del_flg = $delFlg;

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
     * Set create_date
     *
     * @param DateTime $createDate
     * @return GmoEpsilonPlugin
     */
    public function setCreateDate($createDate)
    {
        $this->create_date = $createDate;

        return $this;
    }

    /**
     * Get create_date
     *
     * @return DateTime
     */
    public function getCreateDate()
    {
        return $this->create_date;
    }

    /**
     * Set update_date
     *
     * @param DateTime $updateDate
     * @return GmoEpsilonPlugin
     */
    public function setUpdateDate($updateDate)
    {
        $this->update_date = $updateDate;

        return $this;
    }

    /**
     * Get update_date
     *
     * @return DateTime
     */
    public function getUpdateDate()
    {
        return $this->update_date;
    }
}
