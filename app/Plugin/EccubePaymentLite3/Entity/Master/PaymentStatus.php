<?php

namespace Plugin\EccubePaymentLite3\Entity\Master;

use Eccube\Entity\AbstractEntity;

class PaymentStatus extends AbstractEntity
{
    /**
     * 未課金
     * 決済がまだ完了していない状態、
     * または決済を最後まで完了せずに決済をやめた状態、
     * およびなんらかの原因で決済登録が失敗している可能性がある状態
     */
    const UNPAID = 0;

    /**
     * 課金済み
     * 購入者による支払いが完了した状態
     */
    const CHARGED = 1;

    /**
     * 審査中
     * GMO後払いにおいて、リアルタイム与信で審査ができなかった状態
     */
    const UNDER_REVIEW = 4;

    /**
     * 仮売上
     * クレジットカードの与信審査がOKとなった状態
     */
    const TEMPORARY_SALES = 5;

    /**
     * 出荷登録中
     * GMO後払いにおいて、出荷登録が完了した状態
     */
    const SHIPPING_REGISTRATION = 6;

    /** キャンセル */
    const CANCEL = 9;

    /**
     * 審査NG
     * GMO後払いにおいて、審査が通らなかった状態
     */
    const EXAMINATION_NG = 11;


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
    private $name;

    /**
     * @var integer
     */
    private $rank;

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
     * Set name
     *
     * @param  string      $name
     * @return self
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
     * Set rank
     *
     * @param  integer     $rank
     * @return self
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
     * Set id
     *
     * @param integer $id
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
