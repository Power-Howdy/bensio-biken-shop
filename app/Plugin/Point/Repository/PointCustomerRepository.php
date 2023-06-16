<?php
/*
* This file is part of EC-CUBE
*
* Copyright(c) 2000-2016 LOCKON CO.,LTD. All Rights Reserved.
* http://www.lockon.co.jp/
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
namespace Plugin\Point\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Plugin\Point\Entity\PointCustomer;

/**
 * Class PointCustomerRepository
 * @package Plugin\Point\Repository
 */
class PointCustomerRepository extends EntityRepository
{
    /**
     * 保有ポイントの保存
     * @param $point
     * @param $customer
     * @return bool|PointCustomer
     * @throws NoResultException
     */
    public function savePoint($point, $customer)
    {
        // 引数判定
        if ((!isset($point) && $point != 0) || empty($customer)) {
            return false;
        }

        $PointCustomer = new PointCustomer();
        $PointCustomer->setPlgPointCurrent((integer)$point);
        $PointCustomer->setCustomer($customer);

        $em = $this->getEntityManager();
        $em->persist($PointCustomer);
        $em->flush($PointCustomer);

        return $PointCustomer;
    }

    /**
     * 前回保存のポイントと今回保存のポイントの値を判定
     * @param $point
     * @param $customerId
     * @return bool
     */
    public function isSamePoint($point, $customerId)
    {
        // 最終設定値を会員IDから取得
        $lastPoint = $this->getLastPointById($customerId);

        // 値が同じ場合
        if ((integer)$point === (integer)$lastPoint) {
            return true;
        }

        return false;
    }

    /**
     * 会員IDをもとに一番最後に保存した保有ポイントを取得.
     *
     * @param $customerId 会員ID
     * @return integer
     * @throws \InvalidArgumentException
     */
    public function getLastPointById($customerId)
    {
        // 引数判定
        if (empty($customerId)) {
            throw new \InvalidArgumentException('customer_id is empty.');
        }

        try {
            // 会員IDをもとに最終保存の保有ポイントを取得
            $qb = $this->createQueryBuilder('pc');
            $qb->where('pc.customer_id = :customerId')
                ->setParameter('customerId', $customerId)
                ->orderBy('pc.plg_point_customer_id', 'desc')
                ->setMaxResults(1);

            $PointCustomer = $qb->getQuery()->getSingleResult();

            return $PointCustomer->getPlgPointCurrent();
        } catch (NoResultException $e) {
            return 0;
        }
    }
}
