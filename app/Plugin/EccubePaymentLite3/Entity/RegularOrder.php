<?php


namespace Plugin\EccubePaymentLite3\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Eccube\Entity\AbstractEntity;
use Eccube\Entity\Customer;
use Eccube\Entity\Master\Country;
use Eccube\Entity\Master\DeviceType;
use Eccube\Entity\Master\Job;
use Eccube\Entity\Master\Pref;
use Eccube\Entity\Master\Sex;
use Eccube\Entity\Order;
use Eccube\Entity\OrderDetail;
use Eccube\Entity\Payment;
use Eccube\Util\EntityUtil;
use Plugin\EccubePaymentLite3\Entity\Master\RegularStatus;

/**
 * RegularOrder
 */
class RegularOrder extends AbstractEntity
{

    /**
     * @return bool
     */
    public function isMultiple()
    {
        return count($this->getShippings()) > 1 ? true : false;
    }

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $pre_order_id;

    /**
     * @var string
     */
    private $message;

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
    private $email;

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
     * @var DateTime
     */
    private $birth;

    /**
     * @var string
     */
    private $subtotal;

    /**
     * @var string
     */
    private $discount;

    /**
     * @var string
     */
    private $delivery_fee_total;

    /**
     * @var string
     */
    private $charge;

    /**
     * @var string
     */
    private $tax;

    /**
     * @var string
     */
    private $total;

    /**
     * @var string
     */
    private $payment_total;

    /**
     * @var string
     */
    private $payment_method;

    /**
     * @var string
     */
    private $note;

    /**
     * @var DateTime
     */
    private $create_date;

    /**
     * @var DateTime
     */
    private $update_date;

    /**
     * @var DateTime
     */
    private $order_date;

    /**
     * @var integer
     */
    private $del_flg;

    /**
     * @var string
     */
    private $trans_code;

    /**
     * @var integer
     */
    private $regular_order_count;

    /**
     * @var Collection
     */
    private $RegularOrderDetails;

    /**
     * @var Collection
     */
    private $RegularShippings;

    /**
     * @var Customer
     */
    private $Customer;

    /**
     * @var Country
     */
    private $Country;

    /**
     * @var Pref
     */
    private $Pref;

    /**
     * @var Sex
     */
    private $Sex;

    /**
     * @var Job
     */
    private $Job;

    /**
     * @var Payment
     */
    private $Payment;

    /**
     * @var DeviceType
     */
    private $DeviceType;

    /**
     * @var RegularStatus
     */
    private $RegularStatus;

    /**
     * @var Order
     */
    private $FirstOrder;

    /**
     * @var Order
     */
    private $LastOrder;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->RegularOrderDetails = new ArrayCollection();
        $this->RegularShippings = new ArrayCollection();
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
     * Set pre_order_id
     *
     * @param  string $preOrderId
     * @return RegularOrder
     */
    public function setPreOrderId($preOrderId)
    {
        $this->pre_order_id = $preOrderId;

        return $this;
    }

    /**
     * Get pre_order_id
     *
     * @return string
     */
    public function getPreOrderId()
    {
        return $this->pre_order_id;
    }

    /**
     * Set message
     *
     * @param  string $message
     * @return RegularOrder
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set name01
     *
     * @param  string $name01
     * @return RegularOrder
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
     * @param  string $name02
     * @return RegularOrder
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
     * @param  string $kana01
     * @return RegularOrder
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
     * @param  string $kana02
     * @return RegularOrder
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
     * @param  string $companyName
     * @return RegularOrder
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
     * Set email
     *
     * @param  string $email
     * @return RegularOrder
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set tel01
     *
     * @param  string $tel01
     * @return RegularOrder
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
     * @param  string $tel02
     * @return RegularOrder
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
     * @param  string $tel03
     * @return RegularOrder
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
     * @param  string $fax01
     * @return RegularOrder
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
     * @param  string $fax02
     * @return RegularOrder
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
     * @param  string $fax03
     * @return RegularOrder
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
     * @param  string $zip01
     * @return RegularOrder
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
     * @param  string $zip02
     * @return RegularOrder
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
     * @param  string $zipcode
     * @return RegularOrder
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
     * @param  string $addr01
     * @return RegularOrder
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
     * @param  string $addr02
     * @return RegularOrder
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
     * Set birth
     *
     * @param  DateTime $birth
     * @return RegularOrder
     */
    public function setBirth($birth)
    {
        $this->birth = $birth;

        return $this;
    }

    /**
     * Get birth
     *
     * @return DateTime
     */
    public function getBirth()
    {
        return $this->birth;
    }

    /**
     * Set subtotal
     *
     * @param  string $subtotal
     * @return RegularOrder
     */
    public function setSubtotal($subtotal)
    {
        $this->subtotal = $subtotal;

        return $this;
    }

    /**
     * Get subtotal
     *
     * @return string
     */
    public function getSubtotal()
    {
        return $this->subtotal;
    }

    /**
     * Set discount
     *
     * @param  string $discount
     * @return RegularOrder
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount
     *
     * @return string
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set delivery_fee_total
     *
     * @param  string $deliveryFeeTotal
     * @return RegularOrder
     */
    public function setDeliveryFeeTotal($deliveryFeeTotal)
    {
        $this->delivery_fee_total = $deliveryFeeTotal;

        return $this;
    }

    /**
     * Get delivery_fee_total
     *
     * @return string
     */
    public function getDeliveryFeeTotal()
    {
        return $this->delivery_fee_total;
    }

    /**
     * Set charge
     *
     * @param  string $charge
     * @return RegularOrder
     */
    public function setCharge($charge)
    {
        $this->charge = $charge;

        return $this;
    }

    /**
     * Get charge
     *
     * @return string
     */
    public function getCharge()
    {
        return $this->charge;
    }

    /**
     * Set tax
     *
     * @param  string $tax
     * @return RegularOrder
     */
    public function setTax($tax)
    {
        $this->tax = $tax;

        return $this;
    }

    /**
     * Get tax
     *
     * @return string
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * Set total
     *
     * @param  string $total
     * @return RegularOrder
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return string
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set payment_total
     *
     * @param  string $paymentTotal
     * @return RegularOrder
     */
    public function setPaymentTotal($paymentTotal)
    {
        $this->payment_total = $paymentTotal;

        return $this;
    }

    /**
     * Get payment_total
     *
     * @return string
     */
    public function getPaymentTotal()
    {
        return $this->payment_total;
    }

    /**
     * Set payment_method
     *
     * @param  string $paymentMethod
     * @return RegularOrder
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->payment_method = $paymentMethod;

        return $this;
    }

    /**
     * Get payment_method
     *
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->payment_method;
    }

    /**
     * Set note
     *
     * @param  string $note
     * @return RegularOrder
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set create_date
     *
     * @param  DateTime $createDate
     * @return RegularOrder
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
     * @param  DateTime $updateDate
     * @return RegularOrder
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
     * Set order_date
     *
     * @param  DateTime $orderDate
     * @return RegularOrder
     */
    public function setOrderDate($orderDate)
    {
        $this->order_date = $orderDate;

        return $this;
    }

    /**
     * Get order_date
     *
     * @return DateTime
     */
    public function getOrderDate()
    {
        return $this->order_date;
    }

    /**
     * Set del_flg
     *
     * @param  integer $delFlg
     * @return RegularOrder
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
     * Set trans_code
     *
     * @param string $transCode
     * @return RegularOrder
     */
    public function setTransCode($transCode)
    {
        $this->trans_code = $transCode;

        return $this;
    }

    /**
     * Get trans_code
     *
     * @return string
     */
    public function getTransCode()
    {
        return $this->trans_code;
    }

    /**
     * Set regular_order_count
     *
     * @param integer $regularOrderCount
     * @return RegularOrder
     */
    public function setRegularOrderCount($regularOrderCount)
    {
        $this->regular_order_count = $regularOrderCount;

        return $this;
    }

    /**
     * Get regular_order_count
     *
     * @return integer
     */
    public function getRegularOrderCount()
    {
        return $this->regular_order_count;
    }

    /**
     * Add OrderDetails
     *
     * @param RegularOrderDetail $regularOrderDetail
     * @return RegularOrder
     */
    public function addRegularOrderDetail(RegularOrderDetail $regularOrderDetail)
    {
        $this->RegularOrderDetails[] = $regularOrderDetail;

        return $this;
    }

    /**
     * Remove OrderDetails
     *
     * @param RegularOrderDetail $regularOrderDetail
     */
    public function removeRegularOrderDetail(RegularOrderDetail $regularOrderDetail)
    {
        $this->RegularOrderDetails->removeElement($regularOrderDetail);
    }

    /**
     * Get OrderDetails
     *
     * @return Collection
     */
    public function getRegularOrderDetails()
    {
        return $this->RegularOrderDetails;
    }

    /**
     * Add Shippings
     *
     * @param RegularShipping $regularShipping
     * @return RegularOrder
     */
    public function addRegularShipping(RegularShipping $regularShipping)
    {
        $this->RegularShippings[] = $regularShipping;

        return $this;
    }

    /**
     * Remove Shippings
     *
     * @param RegularShipping $regularShipping
     */
    public function removeRegularShipping(RegularShipping $regularShipping)
    {
        $this->RegularShippings->removeElement($regularShipping);
    }

    /**
     * Get Shippings
     *
     * @return Collection
     */
    public function getRegularShippings()
    {
        return $this->RegularShippings;
    }

    /**
     * Set Customer
     *
     * @param Customer $customer
     * @return RegularOrder
     */
    public function setCustomer(Customer $customer = null)
    {
        $this->Customer = $customer;

        return $this;
    }

    /**
     * Get Customer
     *
     * @return Customer
     */
    public function getCustomer()
    {
        if (EntityUtil::isEmpty($this->Customer)) {
            return null;
        }
        return $this->Customer;
    }

    /**
     * Set Country
     *
     * @param Country $country
     * @return RegularOrder
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
     * @return RegularOrder
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
     * Set Sex
     *
     * @param Sex $sex
     * @return RegularOrder
     */
    public function setSex(Sex $sex = null)
    {
        $this->Sex = $sex;

        return $this;
    }

    /**
     * Get Sex
     *
     * @return Sex
     */
    public function getSex()
    {
        return $this->Sex;
    }

    /**
     * Set Job
     *
     * @param Job $job
     * @return RegularOrder
     */
    public function setJob(Job $job = null)
    {
        $this->Job = $job;

        return $this;
    }

    /**
     * Get Job
     *
     * @return Job
     */
    public function getJob()
    {
        return $this->Job;
    }

    /**
     * Set Payment
     *
     * @param Payment $payment
     * @return RegularOrder
     */
    public function setPayment(Payment $payment = null)
    {
        $this->Payment = $payment;

        return $this;
    }

    /**
     * Get Payment
     *
     * @return Payment
     */
    public function getPayment()
    {
        if (EntityUtil::isEmpty($this->Payment)) {
            return null;
        }
        return $this->Payment;
    }

    /**
     * Set DeviceType
     *
     * @param DeviceType $deviceType
     * @return RegularOrder
     */
    public function setDeviceType(DeviceType $deviceType = null)
    {
        $this->DeviceType = $deviceType;

        return $this;
    }

    /**
     * Get DeviceType
     *
     * @return DeviceType
     */
    public function getDeviceType()
    {
        return $this->DeviceType;
    }

    /**
     * Set RegularStatus
     *
     * @param RegularStatus $RegularStatus
     * @return RegularOrder
     */
    public function setRegularStatus(RegularStatus $RegularStatus)
    {
        $this->RegularStatus = $RegularStatus;

        return $this;
    }

    /**
     * Get RegularStatus
     *
     * @return RegularStatus
     */
    public function getRegularStatus()
    {
        return $this->RegularStatus;
    }

    /**
     * Set FirstOrder
     *
     * @param Order $firstOrder
     * @return RegularOrder
     */
    public function setFirstOrder(Order $firstOrder)
    {
        $this->FirstOrder = $firstOrder;

        return $this;
    }

    /**
     * Get FirstOrder
     *
     * @return Order
     */
    public function getFirstOrder()
    {
        return $this->FirstOrder;
    }

    /**
     * Set lastOrder
     *
     * @param Order $lastOrder
     * @return RegularOrder
     */
    public function setLastOrder(Order $lastOrder)
    {
        $this->LastOrder = $lastOrder;

        return $this;
    }

    /**
     * Get LastOrder
     *
     * @return Order
     */
    public function getLastOrder()
    {
        return $this->LastOrder;
    }
}
