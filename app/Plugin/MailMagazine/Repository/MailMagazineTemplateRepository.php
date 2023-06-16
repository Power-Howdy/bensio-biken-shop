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

namespace Plugin\MailMagazine\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Eccube\Common\Constant;

/**
 * MailMagazine.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MailMagazineTemplateRepository extends EntityRepository
{
    /**
     * find all.
     *
     * @return type
     */
    public function findAll()
    {
        $query = $this
            ->getEntityManager()
            ->createQuery('SELECT m FROM Plugin\MailMagazine\Entity\MailMagazineTemplate m ORDER BY m.id DESC');
        $result = $query
            ->getResult(Query::HYDRATE_ARRAY);

        return $result;
    }

    /**
     * logical delete.
     *
     * @param \Plugin\MailMagazine\Entity\MailMagazineTemplate $MailMagazineTemplate
     *
     * @return bool
     */
    public function delete(\Plugin\MailMagazine\Entity\MailMagazineTemplate $MailMagazineTemplate)
    {
        $em = $this->getEntityManager();
        $em->getConnection()->beginTransaction();
        try {
            // 削除フラグをONにして更新
            $MailMagazineTemplate->setDelFlg(Constant::ENABLED);
            $em->persist($MailMagazineTemplate);
            $em->flush($MailMagazineTemplate);

            $em->getConnection()->commit();
        } catch (\Exception $e) {
            $em->getConnection()->rollback();
            throw $e;

            return false;
        }

        return true;
    }

    /**
     * 更新を行う.
     *
     * @param \Plugin\MailMagazine\Entity\MailMagazineTemplate $MailMagazineTemplate
     *
     * @return bool
     */
    public function update(\Plugin\MailMagazine\Entity\MailMagazineTemplate $MailMagazineTemplate)
    {
        $em = $this->getEntityManager();
        $em->getConnection()->beginTransaction();
        try {
            $em->persist($MailMagazineTemplate);
            $em->flush($MailMagazineTemplate);

            $em->getConnection()->commit();
        } catch (\Exception $e) {
            $em->getConnection()->rollback();
            throw $e;

            return false;
        }

        return true;
    }

    /**
     * 登録を行う.
     *
     * @param \Plugin\MailMagazine\Entity\MailMagazineTemplate $MailMagazineTemplate
     */
    public function create(\Plugin\MailMagazine\Entity\MailMagazineTemplate $MailMagazineTemplate)
    {
        $em = $this->getEntityManager();
        $em->getConnection()->beginTransaction();
        try {
            $MailMagazineTemplate->setDelFlg(Constant::DISABLED);
            $em->persist($MailMagazineTemplate);
            $em->flush($MailMagazineTemplate);

            $em->getConnection()->commit();
        } catch (\Exception $e) {
            $em->getConnection()->rollback();
            throw $e;

            return false;
        }

        return true;
    }
}