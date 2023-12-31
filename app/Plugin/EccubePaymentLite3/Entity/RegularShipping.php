<?php

namespace Plugin\EccubePaymentLite3\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Eccube\Entity\AbstractEntity;
use Eccube\Entity\Delivery;
use Eccube\Entity\DeliveryFee;
use Eccube\Entity\DeliveryTime;
use Eccube\Entity\Master\Country;
use Eccube\Entity\Master\Pref;
use Eccube\Util\EntityUtil;

/**
 * Shipping
 */
class RegularShipping extends AbstractEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name01;

    /**
     * @var string
     */
    private $name02;

    /**
     * @var string
     */
    private $kana01;

    /**
     * @var string
     */
    private $kana02;

    /**
     * @var string
     */
    private $company_name;

    /**
     * @var string
     */
    private $tel01;

    /**
     * @var string
     */
    private $tel02;

    /**
     * @var string
     */
    private $tel03;

    /**
     * @var string
     */
    private $fax01;

    /**
     * @var string
     */
    private $fax02;

    /**
     * @var string
     */
    private $fax03;

    /**
     * @var string
     */
    private $zip01;

    /**
     * @var string
     */
    private $zip02;

    /**
     * @var string
     */
    private $zipcode;

    /**
     * @var string
     */
    private $addr01;

    /**
     * @var string
     */
    private $addr02;

    /**
     * @var string
     */
    private $shipping_delivery_name;

    /**
     * @var string
     */
    private $shipping_delivery_time;

    /**
     * @var DateTime
     */
    private $shipping_delivery_date;

    /**
     * @var string
     */
    private $shipping_delivery_fee;

    /**
     * @var integer
     */
    private $rank;

    /**
     * @var DateTime
     */
    private $create_date;

    /**
     * @var DateTime
     */
    private $update_date;

    /**
     * @var integer
     */
    private $del_flg;

    /**
     * @var Collection
     */
    private $RegularShipmentItems;

    /**
     * @var Country
     */
    private $Country;

    /**
     * @var Pref
     */
    private $Pref;

    /**
     * @var RegularOrder
     */
    private $RegularOrder;

    /**
     * @var Delivery
     */
    private $Delivery;

    /**
     * @var DeliveryTime
     */
    private $DeliveryTime;

    /**
     * @var DeliveryFee
     */
    private $DeliveryFee;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->RegularShipmentItems = new ArrayCollection();
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
     * Set name01
     *
     * @param string $name01
     * @return RegularShipping
     */
    public function setName01($name01)
    {
        $this->name01 = $name01;

        return $this;
    }

    /**
     * Get name01
     *
     * @return string
     */
    public function getName01()
    {
        return $this->name01;
    }

    /**
     * Set name02
     *
     * @param string $name02
     * @return RegularShipping
     */
    public function setName02($name02)
    {
        $this->name02 = $name02;

        return $this;
    }

    /**
     * Get name02
     *
     * @return string
     */
    public function getName02()
    {
        return $this->name02;
    }

    /**
     * Set kana01
     *
     * @param string $kana01
     * @return RegularShipping
     */
    public function setKana01($kana01)
    {
        $this->kana01 = $kana01;

        return $this;
    }

    /**
     * Get kana01
     *
     * @return string
     */
    public function getKana01()
    {
        return $this->kana01;
    }

    /**
     * Set kana02
     *
     * @param string $kana02
     * @return RegularShipping
     */
    public function setKana02($kana02)
    {
        $this->kana02 = $kana02;

        return $this;
    }

    /**
     * Get kana02
     *
     * @return string
     */
    public function getKana02()
    {
        return $this->kana02;
    }

    /**
     * Set company_name
     *
     * @param string $companyName
     * @return RegularShipping
     */
    public function setCompanyName($companyName)
    {
        $this->company_name = $companyName;

        return $this;
    }

    /**
     * Get company_name
     *
     * @return string
     */
    public function getCompanyName()
    {
        return $this->company_name;
    }

    /**
     * Set tel01
     *
     * @param string $tel01
     * @return RegularShipping
     */
    public function setTel01($tel01)
    {
        $this->tel01 = $tel01;

        return $this;
    }

    /**
     * Get tel01
     *
     * @return string
     */
    public function getTel01()
    {
        return $this->tel01;
    }

    /**
     * Set tel02
     *
     * @param string $tel02
     * @return RegularShipping
     */
    public function setTel02($tel02)
    {
        $this->tel02 = $tel02;

        return $this;
    }

    /**
     * Get tel02
     *
     * @return string
     */
    public function getTel02()
    {
        return $this->tel02;
    }

    /**
     * Set tel03
     *
     * @param string $tel03
     * @return RegularShipping
     */
    public function setTel03($tel03)
    {
        $this->tel03 = $tel03;

        return $this;
    }

    /**
     * Get tel03
     *
     * @return string
     */
    public function getTel03()
    {
        return $this->tel03;
    }

    /**
     * Set fax01
     *
     * @param string $fax01
     * @return RegularShipping
     */
    public function setFax01($fax01)
    {
        $this->fax01 = $fax01;

        return $this;
    }

    /**
     * Get fax01
     *
     * @return string
     */
    public function getFax01()
    {
        return $this->fax01;
    }

    /**
     * Set fax02
     *
     * @param string $fax02
     * @return RegularShipping
     */
    public function setFax02($fax02)
    {
        $this->fax02 = $fax02;

        return $this;
    }

    /**
     * Get fax02
     *
     * @return string
     */
    public function getFax02()
    {
        return $this->fax02;
    }

    /**
     * Set fax03
     *
     * @param string $fax03
     * @return RegularShipping
     */
    public function setFax03($fax03)
    {
        $this->fax03 = $fax03;

        return $this;
    }

    /**
     * Get fax03
     *
     * @return string
     */
    public function getFax03()
    {
        return $this->fax03;
    }

    /**
     * Set zip01
     *
     * @param string $zip01
     * @return RegularShipping
     */
    public function setZip01($zip01)
    {
        $this->zip01 = $zip01;

        return $this;
    }

    /**
     * Get zip01
     *
     * @return string
     */
    public function getZip01()
    {
        return $this->zip01;
    }

    /**
     * Set zip02
     *
     * @param string $zip02
     * @return RegularShipping
     */
    public function setZip02($zip02)
    {
        $this->zip02 = $zip02;

        return $this;
    }

    /**
     * Get zip02
     *
     * @return string
     */
    public function getZip02()
    {
        return $this->zip02;
    }

    /**
     * Set zipcode
     *
     * @param string $zipcode
     * @return RegularShipping
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get zipcode
     *
     * @return string
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set addr01
     *
     * @param string $addr01
     * @return RegularShipping
     */
    public function setAddr01($addr01)
    {
        $this->addr01 = $addr01;

        return $this;
    }

    /**
     * Get addr01
     *
     * @return string
     */
    public function getAddr01()
    {
        return $this->addr01;
    }

    /**
     * Set addr02
     *
     * @param string $addr02
     * @return RegularShipping
     */
    public function setAddr02($addr02)
    {
        $this->addr02 = $addr02;

        return $this;
    }

    /**
     * Get addr02
     *
     * @return string
     */
    public function getAddr02()
    {
        return $this->addr02;
    }

    /**
     * Set shipping_delivery_name
     *
     * @param string $shippingDeliveryName
     * @return RegularShipping
     */
    public function setShippingDeliveryName($shippingDeliveryName)
    {
        $this->shipping_delivery_name = $shippingDeliveryName;

        return $this;
    }

    /**
     * Get shipping_delivery_name
     *
     * @return string
     */
    public function getShippingDeliveryName()
    {
        return $this->shipping_delivery_name;
    }

    /**
     * Set shipping_delivery_time
     *
     * @param string $shippingDeliveryTime
     * @return RegularShipping
     */
    public function setShippingDeliveryTime($shippingDeliveryTime)
    {
        $this->shipping_delivery_time = $shippingDeliveryTime;

        return $this;
    }

    /**
     * Get shipping_delivery_time
     *
     * @return string
     */
    public function getShippingDeliveryTime()
    {
        return $this->shipping_delivery_time;
    }

    /**
     * Set shipping_delivery_date
     *
     * @param DateTime $shippingDeliveryDate
     * @return RegularShipping
     */
    public function setShippingDeliveryDate($shippingDeliveryDate)
    {
        $this->shipping_delivery_date = $shippingDeliveryDate;

        return $this;
    }

    /**
     * Get shipping_delivery_date
     *
     * @return DateTime
     */
    public function getShippingDeliveryDate()
    {
        return $this->shipping_delivery_date;
    }

    /**
     * Set shipping_delivery_fee
     *
     * @param string $shippingDeliveryFee
     * @return RegularShipping
     */
    public function setShippingDeliveryFee($shippingDeliveryFee)
    {
        $this->shipping_delivery_fee = $shippingDeliveryFee;

        return $this;
    }

    /**
     * Get shipping_delivery_fee
     *
     * @return string
     */
    public function getShippingDeliveryFee()
    {
        return $this->shipping_delivery_fee;
    }

    /**
     * Set rank
     *
     * @param integer $rank
     * @return RegularShipping
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return integer
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set create_date
     *
     * @param DateTime $createDate
     * @return RegularShipping
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
     * @return RegularShipping
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

    /**
     * Set del_flg
     *
     * @param integer $delFlg
     * @return RegularShipping
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
     * Add RegularShipmentItems
     *
     * @param RegularShipmentItem $regularShipmentItem
     * @return RegularShipping
     */
    public function addRegularShipmentItem(RegularShipmentItem $regularShipmentItem)
    {
        $this->RegularShipmentItems[] = $regularShipmentItem;

        return $this;
    }

    /**
     * Remove RegularShipmentItems
     *
     * @param RegularShipmentItem $regularShipmentItem
     */
    public function removeRegularShipmentItem(RegularShipmentItem $regularShipmentItem)
    {
        $this->RegularShipmentItems->removeElement($regularShipmentItem);
    }

    /**
     * Get RegularShipmentItems
     *
     * @return Collection
     */
    public function getRegularShipmentItems()
    {
        return $this->RegularShipmentItems;
    }

    /**
     * Set Country
     *
     * @param Country $country
     * @return RegularShipping
     */
    public function setCountry(Country $country = null)
    {
        $this->Country = $country;

        return $this;
    }

    /**
     * Get Country
     *
     * @return Country
     */
    public function getCountry()
    {
        return $this->Country;
    }

    /**
     * Set Pref
     *
     * @param Pref $pref
     * @return RegularShipping
     */
    public function setPref(Pref $pref = null)
    {
        $this->Pref = $pref;

        return $this;
    }

    /**
     * Get Pref
     *
     * @return Pref
     */
    public function getPref()
    {
        return $this->Pref;
    }

    /**
     * Set RegularOrder
     *
     * @param RegularOrder $regularOrder
     * @return RegularShipping
     */
    public function setRegularOrder(RegularOrder $regularOrder)
    {
        $this->RegularOrder = $regularOrder;

        return $this;
    }

    /**
     * Get RegularOrder
     *
     * @return RegularOrder
     */
    public function getRegularOrder()
    {
        return $this->RegularOrder;
    }

    /**
     * Set Delivery
     *
     * @param Delivery $delivery
     * @return RegularShipping
     */
    public function setDelivery(Delivery $delivery = null)
    {
        $this->Delivery = $delivery;

        return $this;
    }

    /**
     * Get Delivery
     *
     * @return Delivery
     */
    public function getDelivery()
    {
        if (EntityUtil::isEmpty($this->Delivery)) {
            return null;
        }
        return $this->Delivery;
    }

    /**
     * Set DeliveryTime
     *
     * @param DeliveryTime $deliveryTime
     * @return RegularShipping
     */
    public function setDeliveryTime(DeliveryTime $deliveryTime = null)
    {
        $this->DeliveryTime = $deliveryTime;

        return $this;
    }

    /**
     * Get DeliveryTime
     *
     * @return DeliveryTime
     */
    public function getDeliveryTime()
    {
        if (EntityUtil::isEmpty($this->DeliveryTime)) {
            return null;
        }

        return $this->DeliveryTime;
    }

    /**
     * Set DeliveryFee
     *
     * @param DeliveryFee $deliveryFee
     * @return RegularShipping
     */
    public function setDeliveryFee(DeliveryFee $deliveryFee = null)
    {
        $this->DeliveryFee = $deliveryFee;

        return $this;
    }

    /**
     * Get DeliveryFee
     *
     * @return DeliveryFee
     */
    public function getDeliveryFee()
    {
        if (EntityUtil::isEmpty($this->DeliveryFee)) {
            return null;
        }

        return $this->DeliveryFee;
    }
}
