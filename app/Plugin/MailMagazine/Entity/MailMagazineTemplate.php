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

use Eccube\Entity\AbstractEntity;

class MailMagazineTemplate extends AbstractEntity
{
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getSubject();
    }

    /**
     * @var int
     */
    private $id;

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
     * Get subject.
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set subject.
     *
     * @param string $subject
     *
     * @return MailMagazineTemplate
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Set del_flg.
     *
     * @param int $delFlg
     *
     * @return MailMagazineTemplate
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
     * @return MailMagazineTemplate
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
     * @return MailMagazineTemplate
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
     * Set body.
     *
     * @param string $body
     *
     * @return MailMagazineTemplate
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
     * @return MailMagazineTemplate
     */
    public function setHtmlBody($html_body)
    {
        $this->html_body = $html_body;

        return $this;
    }
}
