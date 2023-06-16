<?php
/*
* This file is part of EC-CUBE
*
* Copyright(c) EC-CUBE CO.,LTD. All Rights Reserved.
* https://www.ec-cube.co.jp/
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Plugin\MailMagazine\Entity;

class MailmagaCustomer extends \Eccube\Entity\AbstractEntity
{
    /**
     * @var int
     */
//     private $template_id;
    private $id;

    /**
     * @var int
     */
    private $customer_id;

    /**
     * @var int
     */
    private $mailmaga_flg;

    /**
     * @var int
     */
    private $del_flg;

    /**
     * @var \DateTime
     */
    private $create_date;

    /**
     * @var \DateTime
     */
    private $update_date;

    /**
     * Constructor.
     */
    public function __construct()
    {
    }

    /**
     * Set template id.
     *
     * @param int $id
     *
     * @return MailMagazineTemplate
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get template_id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set customer id.
     *
     * @param string $id
     *
     * @return MailmagaCustomer
     */
    public function setCustomerId($customerId)
    {
        $this->customer_id = $customerId;

        return $this;
    }

    /**
     * Get customer_id.
     *
     * @return int
     */
    public function getCustomerId()
    {
        return $this->customer_id;
    }

    /**
     * Get subject.
     *
     * @return int
     */
    public function getMailmagaFlg()
    {
        return $this->mailmaga_flg;
    }

    /**
     * Set mailmag_flg.
     *
     * @param int $mailmag_flg
     *
     * @return MailmagaCustomer
     */
    public function setMailmagaFlg($mailmaga_flg)
    {
        $this->mailmaga_flg = $mailmaga_flg;

        return $this;
    }

    /**
     * Set del_flg.
     *
     * @param int $delFlg
     *
     * @return Payment
     */
    public function setDelFlg($delFlg)
    {
        $this->del_flg = $delFlg;

        return $this;
    }

    /**
     * Get del_flg.
     *
     * @return int
     */
    public function getDelFlg()
    {
        return $this->del_flg;
    }

    /**
     * Set create_date.
     *
     * @param \DateTime $createDate
     *
     * @return Payment
     */
    public function setCreateDate($createDate)
    {
        $this->create_date = $createDate;

        return $this;
    }

    /**
     * Get create_date.
     *
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->create_date;
    }

    /**
     * Set update_date.
     *
     * @param \DateTime $updateDate
     *
     * @return Payment
     */
    public function setUpdateDate($updateDate)
    {
        $this->update_date = $updateDate;

        return $this;
    }

    /**
     * Get update_date.
     *
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->update_date;
    }
}
