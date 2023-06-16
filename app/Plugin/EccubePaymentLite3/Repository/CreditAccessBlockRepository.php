<?php

namespace Plugin\EccubePaymentLite3\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class CreditAccessBlockRepository extends EntityRepository {

    public function deleteAllIpAddressForPassedBlockTime($block_time)
    {
        $date = new \DateTime();
        $date->modify("-$block_time seconds");

        $this->createQueryBuilder('c')
            ->delete()
            ->where('c.block_date < :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->execute();
    }
}
