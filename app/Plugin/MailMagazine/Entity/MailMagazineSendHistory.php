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

/**
 * SendHistory
 * Plugin MailMagazine.
 */
class MailMagazineSendHistory extends \Eccube\Entity\AbstractEntity
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $mail_method;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $body;

    /**
     * @var string
     */
    private $html_body;

    /**
     * @var int
     */
    private $send_count;

    /**
     * @var int
     */
    private $complete_count;

    /**
     * @var int
     */
    private $error_count;

    /**
     * @var \DateTime
     */
    private $start_date;

    /**
     * @var \DateTime
     */
    private $end_date;

    /**
     * @var string
     */
    private $search_data;

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
     * @var \Eccube\Entity\Member
     */
    private $Creator;

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
     * Set mail_method.
     *
     * @param int $mailMethod
     *
     * @return SendHistory
     */
    public function setMailMethod($mailMethod)
    {
        $this->mail_method = $mailMethod;

        return $this;
    }

    /**
     * Get mail_method.
     *
     * @return int
     */
    public function getMailMethod()
    {
        return $this->mail_method;
    }

    /**
     * Set subject.
     *
     * @param string $subject
     *
     * @return SendHistory
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject.
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set body.
     *
     * @param string $body
     *
     * @return SendHistory
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body.
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getHtmlBody()
    {
        return $this->html_body;
    }

    /**
     * @param string $html_body
     *
     * @return MailMagazineSendHistory
     */
    public function setHtmlBody($html_body)
    {
        $this->html_body = $html_body;

        return $this;
    }

    /**
     * Set send_count.
     *
     * @param int $sendCount
     *
     * @return SendHistory
     */
    public function setSendCount($sendCount)
    {
        $this->send_count = $sendCount;

        return $this;
    }

    /**
     * Get send_count.
     *
     * @return int
     */
    public function getSendCount()
    {
        return $this->send_count;
    }

    /**
     * Set complete_count.
     *
     * @param int $completeCount
     *
     * @return SendHistory
     */
    public function setCompleteCount($completeCount)
    {
        $this->complete_count = $completeCount;

        return $this;
    }

    /**
     * Get complete_count.
     *
     * @return int
     */
    public function getCompleteCount()
    {
        return $this->complete_count;
    }

    /**
     * @return int
     */
    public function getErrorCount()
    {
        return $this->error_count;
    }

    /**
     * @param int $errorCount
     *
     * @return MailMagazineSendHistory
     */
    public function setErrorCount($errorCount)
    {
        $this->error_count = $errorCount;

        return $this;
    }

    /**
     * Set start_date.
     *
     * @param \DateTime $startDate
     *
     * @return SendHistory
     */
    public function setStartDate($startDate)
    {
        $this->start_date = $startDate;

        return $this;
    }

    /**
     * Get start_date.
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * Set end_date.
     *
     * @param \DateTime $endDate
     *
     * @return SendHistory
     */
    public function setEndDate($endDate)
    {
        $this->end_date = $endDate;

        return $this;
    }

    /**
     * Get end_date.
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * Set search_data.
     *
     * @param string $searchData
     *
     * @return SendHistory
     */
    public function setSearchData($searchData)
    {
        $this->search_data = $searchData;

        return $this;
    }

    /**
     * Get search_data.
     *
     * @return string
     */
    public function getSearchData()
    {
        return $this->search_data;
    }

    /**
     * Set del_flg.
     *
     * @param int $delFlg
     *
     * @return SendHistory
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
     * @return SendHistory
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
     * @return SendHistory
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
     * Set Creator.
     *
     * @param \Eccube\Entity\Member $creator
     *
     * @return SendHistory
     */
    public function setCreator(\Eccube\Entity\Member $creator = null)
    {
        $this->Creator = $creator;

        return $this;
    }

    /**
     * Get Creator.
     *
     * @return \Eccube\Entity\Member
     */
    public function getCreator()
    {
        return $this->Creator;
    }

    /**
     * 配信エラーの有無にかかわらず、すべて送信したかどうかの判定.
     *
     * @return bool 配信完了した場合はtrue
     */
    public function isComplete()
    {
        return $this->getCompleteCount() == $this->getSendCount();
    }
}
