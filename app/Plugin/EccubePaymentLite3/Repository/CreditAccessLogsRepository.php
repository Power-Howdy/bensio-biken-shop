<?php

namespace Plugin\EccubePaymentLite3\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class CreditAccessLogsRepository extends EntityRepository {

    public function deleteAllIpAddressForPassedAccessFrequencyTime($access_frequency_time)
    {
        $date = new \DateTime();
        $date->modify("-$access_frequency_time seconds");

        $this->createQueryBuilder('c')
            ->delete()
            ->where('c.access_date < :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->execute();
    }
}
