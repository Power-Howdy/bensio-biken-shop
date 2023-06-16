<?php

namespace Plugin\EccubePaymentLite3\Entity\Extension;

use Eccube\Entity\AbstractEntity;

class PaymentExtension extends AbstractEntity
{
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getMethod();
    }

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $method;

    /**
     * @var integer
     */
    private $payment_type_id;

    /**
     * @var string
     */
    private $st_code;

    /**
     * @var string
     */
    private $mission_code;

    /**
     * @var string
     */
    private $plugin_code;

    /**
     * Set id
     *
     * @param  integer $id
     * @return PaymentExtension
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
     * Set method
     *
     * @param  string $method
     * @return PaymentExtension
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Get method
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set payment_type_id
     *
     * @param  integer $paymentTypeId
     * @return PaymentExtension
     */
    public function setPaymentTypeId($paymentTypeId)
    {
        $this->payment_type_id = $paymentTypeId;

        return $this;
    }

    /**
     * Get payment_type_id
     *
     * @return integer
     */
    public function getPaymentTypeId()
    {
        return $this->payment_type_id;
    }

    /**
     * Set st_code
     *
     * @param  string $stCode
     * @return PaymentExtension
     */
    public function setStCode($stCode)
    {
        $this->st_code = $stCode;

        return $this;
    }

    /**
     * Get st_code
     *
     * @return string
     */
    public function getStCode()
    {
        return $this->st_code;
    }

    /**
     * Set mission_code
     *
     * @param  string $missionCode
     * @return PaymentExtension
     */
    public function setMissionCode($missionCode)
    {
        $this->mission_code = $missionCode;

        return $this;
    }

    /**
     * Get mission_code
     *
     * @return string
     */
    public function getMissionCode()
    {
        return $this->mission_code;
    }

    /**
     * Set plugin_code
     *
     * @param  string $pluginCode
     * @return PaymentExtension
     */
    public function setPluginCode($pluginCode)
    {
        $this->plugin_code = $pluginCode;

        return $this;
    }

    /**
     * Get plugin_code
     *
     * @return string
     */
    public function getPluginCode()
    {
        return $this->plugin_code;
    }

}
