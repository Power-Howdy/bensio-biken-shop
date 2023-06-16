<?php

namespace Plugin\EccubePaymentLite3\Repository;

use Doctrine\ORM\EntityRepository;

class RegularProductRepository extends EntityRepository
{

    public function getRegularFlg()
    {
        $qb = $this->createQueryBuilder('r')
                    ->select('r.regular_flg');
        return $qb
                ->getQuery()
                ->getSingleScalarResult();
    }

    public function getCreateFlg()
    {
        $qb = $this->createQueryBuilder('r')
                    ->select('r.create_flg');
        return $qb
                ->getQuery()
                ->getSingleScalarResult();
    }

    public function getRegularProduct($searchData)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
            ->select('p')
            ->from('\Eccube\Entity\Product', 'p')
            ->innerJoin('p.ProductClasses', 'pc')
            ->innerJoin('pc.ProductType', 'pt')
            ->innerJoin('\Plugin\EccubePaymentLite3\Entity\RegularProduct', 'g', 'WITH', 'pt.id = g.product_type_id');

        // multi
        if (!empty($searchData['multi']) && $searchData['multi']) {
            $multi = preg_match('/^\d+$/', $searchData['multi']) ? $searchData['multi'] : null;
            $qb
                ->andWhere('p.id = :multi OR p.name LIKE :likemulti OR pc.code LIKE :likemulti')
                ->setParameter('multi', $multi)
                ->setParameter('likemulti', '%' . $searchData['multi'] . '%');
        }

        // category
        if (!empty($searchData['category_id']) && $searchData['category_id']) {
            $Categories = $searchData['category_id']->getSelfAndDescendants();
            if ($Categories) {
                $qb
                    ->innerJoin('p.ProductCategories', 'pct')
                    ->innerJoin('pct.Category', 'c')
                    ->andWhere($qb->expr()->in('pct.Category', ':Categories'))
                    ->setParameter('Categories', $Categories);
            }
        }

        return $qb
            ->getQuery()
            ->getResult();
    }

}
