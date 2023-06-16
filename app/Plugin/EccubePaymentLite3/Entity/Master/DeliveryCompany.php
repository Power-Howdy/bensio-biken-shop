<?php

namespace Plugin\EccubePaymentLite3\Entity\Master;

use Eccube\Entity\AbstractEntity;

class DeliveryCompany extends AbstractEntity
{
    const SAGAWA = 11;
    const SAGAWA_NAME = '佐川急便';

    const YAMATO = 12;
    const YAMATO_NAME = 'ヤマト運輸・ネコポス・宅急便コンパクト・クロネコDM便';

    const SEINO = 14;
    const SEINO_NAME = '西濃運輸';

    const REGISTERED_MAIL__SPECIFIC_RECORD_MAIL = 15;
    const REGISTERED_MAIL__SPECIFIC_RECORD_MAIL_NAME = '郵便書留・特定記録郵便';

    const YUPACK__EXPACK__POST_PACKET = 16;
    const YUPACK__EXPACK__POST_PACKET_NAME = 'ゆうパック・エクスパック・ポスパケット';

    const FUKUYAMA = 18;
    const FUKUYAMA_NAME = '福山通運';

    const ECOHAI = 27;
    const ECOHAI_NAME = 'エコ配';

    const TEN_FLIGHT__LETTER_PACK__NEW_LIMITED_EXPRESS_MAIL__YU_PACKET = 28;
    const TEN_FLIGHT__LETTER_PACK__NEW_LIMITED_EXPRESS_MAIL__YU_PACKET_NAME = '翌朝10時便・レターパック・新特急郵便・ゆうパケット';

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
