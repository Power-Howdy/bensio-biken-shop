<?php
/*
 * Copyright(c) 2015 GMO Payment Gateway, Inc. All rights reserved.
 * http://www.gmo-pg.com/
 */

namespace Plugin\EccubePaymentLite3\Entity;
use DateTime;
use Eccube\Entity\AbstractEntity;
use Eccube\Entity\Customer;

class EpsilonMember extends AbstractEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var Customer
     */
    private $Customer;

    /**
     * @var DateTime
     */
    private $gmo_epsilon_credit_card_expiration_date;

    /**
     * @var DateTime
     */
    private $card_change_request_mail_send_date;

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
    private $customer_id;

    /**
     * Get EpsilonMemberId
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get customer_id
     *
     * @return integer
     */
    public function getCustomerId()
    {
        return $this->customer_id;
    }
    /**
     * Set create_date
     *
     * @param  DateTime $gmo_epsilon_credit_card_expiration_date
     * @return EpsilonMember
     */
    public function setGmoEpsilonCreditCardExpirationDate($gmo_epsilon_credit_card_expiration_date)
    {
        $this->gmo_epsilon_credit_card_expiration_date = $gmo_epsilon_credit_card_expiration_date;

        return $this;
    }

    /**
     * Get create_date
     *
     * @return DateTime
     */
    public function getGmoEpsilonCreditCardExpirationDate()
    {
        return $this->gmo_epsilon_credit_card_expiration_date;
    }

    /**
     * Set card_change_request_mail_send_date
     * @param DateTime $card_change_request_mail_send_date
     * @return EpsilonMember
     */
    public function setCardChangeRequestMailSendDate($card_change_request_mail_send_date)
    {
        $this->card_change_request_mail_send_date = $card_change_request_mail_send_date;

        return $this;
    }

    /**
     * Get card_change_request_mail_send_date
     * @return DateTime
     */
    public function getCardChangeRequestMailSendDate()
    {
        return $this->card_change_request_mail_send_date;
    }

    /**
     * Set create_date
     *
     * @param  DateTime $createDate
     * @return EpsilonMember
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
     * @return EpsilonMember
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
     * Set Customer
     *
     * @param  Customer $customer
     * @return EpsilonMember
     */
    public function setCustomer(Customer $customer)
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
        return $this->Customer;
    }
}
