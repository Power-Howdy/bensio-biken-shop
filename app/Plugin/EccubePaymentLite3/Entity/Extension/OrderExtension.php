<?php

namespace Plugin\EccubePaymentLite3\Entity\Extension;

use Eccube\Entity\AbstractEntity;
use Plugin\EccubePaymentLite3\Entity\Master\PaymentStatus;

class OrderExtension extends AbstractEntity
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $trans_code;

    /**
     * @var integer
     */
    private $regular_order_id;

    /**
     * @var string
     */
    private $payment_info;

    /**
     * @var PaymentStatus
     */
    private $PaymentStatus;

    /**
     * @var string
     */
    private $gmo_epsilon_order_no;

    /**
     * Set id
     *
     * @param integer $id
     * @return OrderExtension
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
     * Set trans_code
     *
     * @param  string $trans_code
     * @return OrderExtension
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
     * Set regular_order_id
     *
     * @param  integer $regularOrderId
     * @return OrderExtension
     */
    public function setRegularOrderId($regularOrderId)
    {
        $this->regular_order_id = $regularOrderId;

        return $this;
    }

    /**
     * Get regular_order_id
     *
     * @return integer
     */
    public function getRegularOrderId()
    {
        return $this->regular_order_id;
    }

    /**
     * Set payment_info
     *
     * @param  string $paymentInfo
     * @return OrderExtension
     */
    public function setPaymentInfo($paymentInfo)
    {
        $this->payment_info = $paymentInfo;

        return $this;
    }

    /**
     * Get paymentInfo
     *
     * @return string
     */
    public function getPaymentInfo()
    {
        return $this->payment_info;
    }

    /**
     * Set PaymentStatus
     *
     * @param PaymentStatus $PaymentStatus
     * @return self
     */
    public function setPaymentStatus(PaymentStatus $PaymentStatus)
    {
        $this->PaymentStatus = $PaymentStatus;

        return $this;
    }

    /**
     * Get PaymentStatus
     *
     * @return PaymentStatus
     */
    public function getPaymentStatus()
    {
        return $this->PaymentStatus;
    }

    /**
     * Set GmoEpsilonOrderNo
     *
     * @param  string $order_no
     * @return OrderExtension
     */
    public function setGmoEpsilonOrderNo($order_no)
    {
        $this->gmo_epsilon_order_no = $order_no;

        return $this;
    }

    /**
     * Get GmoEpsilonOrderNo
     *
     * @return string
     */
    public function getGmoEpsilonOrderNo()
    {
        return $this->gmo_epsilon_order_no;
    }
}
