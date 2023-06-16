<?php
/*
 * This file is part of Receipt Pdf plugin
 *
 * Copyright (C) 2018 NinePoint Co. LTD. All Rights Reserved.
 *
 * Copyright (C) 2016 LOCKON CO.,LTD. All Rights Reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\ReceiptPdf\Entity;

use Eccube\Entity\AbstractEntity;

/**
 * Class ReceiptPdf.
 */
class ReceiptPdf extends AbstractEntity
{
    /**
     * @var string
     */
    private $ids;

    /**
     * @var int
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $issue_date;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $message1;

    /**
     * @var string
     */
    private $message2;

    /**
     * @var string
     */
    private $message3;

    /**
     * @var string
     */
    private $note1;

    /**
     * @var string
     */
    private $note2;

    /**
     * @var string
     */
    private $note3;

    /**
     * @var bool
     */
    private $default;

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
     * @var \String
     */
    private $catalog_detail;

    /**
     * @var boolean
     */
     private $specification_flg;

     /**
     * @var boolean
     */
     private $receipt_flg;

    /**
     * @var int
     */
    private $detail_flg;

    /**
     * @var boolean
     */
     private $address_name_flg;

    /**
     * Set order id.
     *
     * @param string $ids
     *
     * @return ReceiptPdf
     */
    public function setIds($ids)
    {
        $this->ids = $ids;

        return $this;
    }

    /**
     * Get order.
     *
     * @return string
     */
    public function getIds()
    {
        return $this->ids;
    }

    /**
     * Set member id.
     *
     * @param string $id
     *
     * @return ReceiptPdf
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set download date.
     *
     * @param \DateTime $issueDate
     *
     * @return ReceiptPdf
     */
    public function setIssueDate($issueDate)
    {
        $this->issue_date = $issueDate;

        return $this;
    }

    /**
     * Get download date.
     *
     * @return \DateTime
     */
    public function getIssueDate()
    {
        return $this->issue_date;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return ReceiptPdf
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get message1.
     *
     * @return string
     */
    public function getMessage1()
    {
        return $this->message1;
    }

    /**
     * Set message1.
     *
     * @param string $message1
     *
     * @return ReceiptPdf
     */
    public function setMessage1($message1)
    {
        $this->message1 = $message1;

        return $this;
    }

    /**
     * Get message2.
     *
     * @return string
     */
    public function getMessage2()
    {
        return $this->message2;
    }

    /**
     * Set message2.
     *
     * @param string $message2
     *
     * @return ReceiptPdf
     */
    public function setMessage2($message2)
    {
        $this->message2 = $message2;

        return $this;
    }

    /**
     * Get message3.
     *
     * @return string
     */
    public function getMessage3()
    {
        return $this->message3;
    }

    /**
     * Set message3.
     *
     * @param string $message3
     *
     * @return ReceiptPdf
     */
    public function setMessage3($message3)
    {
        $this->message3 = $message3;

        return $this;
    }

    /**
     * Get note1.
     *
     * @return string
     */
    public function getNote1()
    {
        return $this->note1;
    }

    /**
     * Set note1.
     *
     * @param string $note1
     *
     * @return ReceiptPdf
     */
    public function setNote1($note1)
    {
        $this->note1 = $note1;

        return $this;
    }

    /**
     * Get note2.
     *
     * @return string
     */
    public function getNote2()
    {
        return $this->note2;
    }

    /**
     * Set note2.
     *
     * @param string $note2
     *
     * @return ReceiptPdf
     */
    public function setNote2($note2)
    {
        $this->note2 = $note2;

        return $this;
    }

    /**
     * Get note3.
     *
     * @return string
     */
    public function getNote3()
    {
        return $this->note3;
    }

    /**
     * Set note3.
     *
     * @param string $note3
     *
     * @return ReceiptPdf
     */
    public function setNote3($note3)
    {
        $this->note3 = $note3;

        return $this;
    }

    /**
     * Set default to save.
     *
     * @param bool $isDefault
     *
     * @return ReceiptPdf
     */
    public function setDefault($isDefault)
    {
        $this->default = $isDefault;

        return $this;
    }

    /**
     * Get default.
     *
     * @return bool
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * Set del_flg.
     *
     * @param int $delFlg
     *
     * @return ReceiptPdf
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
     * @return ReceiptPdf
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
     * @return ReceiptPdf
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

    /**
     * Get catalog_detail.
     *
     * @return string
     */
    public function getCatalogDetail()
    {
        return $this->catalog_detail;
    }

     /**
     * Set catalog_detail.
     *
     * @param string $catalog_detail
     *
     * @return ReceiptPdf
     */
    public function setCatalogDetail($catalog_detail)
    {
        $this->catalog_detail = $catalog_detail;

        return $this;
    }
    /**
     * Set specification_flg.
     *
     * @param int $specification_flg
     *
     * @return ReceiptPdf
     */
     public function setSpecificationFlg($specification_flg)
     {
         $this->specification_flg = $specification_flg;
 
         return $this;
     }
    /**
    * Get specification_flg.
    *
    * @return string
    */
    public function getSpecificationFlg()
    {
        return $this->specification_flg;
    }
    /**
     * Set receipt_flg.
     *
     * @param int $receipt_flg
     *
     * @return ReceiptPdf
     */
     public function setReceiptFlg($receipt_flg)
     {
         $this->receipt_flg = $receipt_flg;
 
         return $this;
     }
    /**
    * Get receipt_flg.
    *
    * @return string
    */
    public function getReceiptFlg()
    {
        return $this->receipt_flg;
    }
    /**
     * Get detail_flg.
     *
     * @return ReceiptPdf
     */
    public function getDetailFlg()
    {
        return $this->detail_flg;
    }
     /**
     * Set detail_flg.
     *
     * @param int $detail_flg
     *
     * @return int
     */
    public function setDetailFlg($detail_flg)
    {
        $this->detail_flg = $detail_flg;

        return $this;
    }
    /**
     * Get address_name_flg.
     *
     * @return ReceiptPdf
     */
     public function getAddressNameFlg()
     {
         return $this->address_name_flg;
     }
     /**
     * Set address_name_flg.
     *
     * @param int $address_name_flg
     *
     * @return int
     */
    public function setAddressNameFlg($address_name_flg)
    {
        $this->address_name_flg = $address_name_flg;

        return $this;
    }
}
