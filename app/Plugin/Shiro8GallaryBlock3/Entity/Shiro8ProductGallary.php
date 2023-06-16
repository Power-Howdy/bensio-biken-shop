<?php
/*
* This file is part of EC-CUBE
*
* Copyright(c) 2000-2015 LOCKON CO.,LTD. All Rights Reserved.
* http://www.lockon.co.jp/
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Plugin\Shiro8GallaryBlock3\Entity;


class Shiro8ProductGallary extends \Eccube\Entity\AbstractEntity
{
    private $id;

    private $useFlg;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getUseFlg()
    {
        return $this->useFlg;
    }

    public function setUseFlg($useFlg)
    {
        $this->useFlg = $useFlg;

        return $this;
    }
}
