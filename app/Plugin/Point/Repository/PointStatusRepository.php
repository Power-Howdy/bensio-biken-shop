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

/**
 * Class PointStatusRepository
 * @package Plugin\Point\Repository
 */
class PointStatusRepository extends EntityRepository
{
    // ポイントのステータス
    const POINT_STATUS_UNFIX = 0;   // 仮
    const POINT_STATUS_FIX = 1;     // 確定

    /**
     * 仮ステータスの受注ID一覧を返却する
     * @param $customer_id
     * @return array
     */
    public function selectOrderIdsWithUnfixedByCustomer($customer_id)
    {
        // 会員IDをもとに仮付与ポイントを計算
        $qb = $this->createQueryBuilder('p')
            ->select('p.order_id')
            ->andWhere('p.customer_id = :customer_id')
            ->andWhere('p.status = :status')
            ->andWhere('p.del_flg = :del_flg')
            ->setParameter('customer_id', $customer_id)
            ->setParameter('status', PointStatusRepository::POINT_STATUS_UNFIX)
            ->setParameter('del_flg', 0);

        $result = $qb->getQuery()->getScalarResult();

        $orderIds = array();
        foreach ($result as $item) {
            $orderIds[] = $item['order_id'];
        }

        return $orderIds;
    }

    /**
     * 確定ステータスの受注ID一覧を返却する
     * @param $customer_id
     * @return array
     */
    public function selectOrderIdsWithFixedByCustomer($customer_id)
    {
        // 会員IDをもとに仮付与ポイントを計算
        $qb = $this->createQueryBuilder('p')
            ->select('p.order_id')
            ->andWhere('p.customer_id = :customer_id')
            ->andWhere('p.status = :status')
            ->andWhere('p.del_flg = :del_flg')
            ->setParameter('customer_id', $customer_id)
            ->setParameter('status', PointStatusRepository::POINT_STATUS_FIX)
            ->setParameter('del_flg', 0);

        $result = $qb->getQuery()->getScalarResult();

        $orderIds = array();
        foreach ($result as $item) {
            $orderIds[] = $item['order_id'];
        }

        return $orderIds;
    }

    /**
     * 受注情報をもとに、ポイントが確定かどうか判定
     * @param $order
     * @return bool|null
     */
    public function isFixedStatus($order)
    {
        // 必要エンティティ判定
        if (empty($order)) {
            return false;
        }

        try {
            // 受注をもとに仮付与ポイントを計算
            $qb = $this->createQueryBuilder('p');
            $qb->where('p.order_id = :order_id')
                ->setParameter('order_id', $order->getId());

            $result = $qb->getQuery()->getSingleResult();

            return ($result->getStatus() == PointStatusRepository::POINT_STATUS_FIX);
        } catch (NoResultException $e) {
            return false;
        }
    }

    /**
     * ポイント確定時の定数を返す
     * @return int ポイント確定時の定数
     */
    public function getFixStatusValue()
    {
        return PointStatusRepository::POINT_STATUS_FIX;
    }
}
