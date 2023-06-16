<?php


namespace Plugin\EccubePaymentLite3\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Eccube\Util\Str;

class RegularOrderRepository extends EntityRepository
{
    /** @var app */
    public $app;

    /** @var array */
    public $config;

    public function setApp($app)
    {
        $this->app = $app;
    }

    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    public function getQueryBuilderBySearchDataForAdmin($searchData)
    {
        $qb = $this->createQueryBuilder('r');

        // multi
        if (isset($searchData['multi']) && Str::isNotBlank($searchData['multi'])) {
            $multi = preg_match('/^\d+$/', $searchData['multi']) ? $searchData['multi'] : null;
            $qb
                ->andWhere('r.id = :multi OR r.name01 LIKE :likemulti OR r.name02 LIKE :likemulti OR ' .
                           'r.kana01 LIKE :likemulti OR r.kana02 LIKE :likemulti OR r.company_name LIKE :likemulti')
                ->setParameter('multi', $multi)
                ->setParameter('likemulti', '%' . $searchData['multi'] . '%');
        }

        // latest_status
        if (!empty($searchData['latest_status']) && $searchData['latest_status']) {
            $qb
                ->leftJoin('r.LastOrder', 'ro')
                ->andWhere('ro.OrderStatus = :latest_status')
                ->setParameter('latest_status', $searchData['latest_status']);
        }

        // regular_status
        if (!empty($searchData['regular_status']) && $searchData['regular_status']) {
            $qb
                ->andWhere('r.RegularStatus = :regular_status')
                ->setParameter('regular_status', $searchData['regular_status']);
        }

        // name
        if (isset($searchData['name']) && Str::isNotBlank($searchData['name'])) {
            $qb
                ->andWhere('CONCAT(r.name01, r.name02) LIKE :name')
                ->setParameter('name', '%' . $searchData['name'] . '%');
        }

        // kana
        if (isset($searchData['kana']) && Str::isNotBlank($searchData['kana'])) {
            $qb
                ->andWhere('CONCAT(r.kana01, r.kana02) LIKE :kana')
                ->setParameter('kana', '%' . $searchData['kana'] . '%');
        }

        // email
        if (isset($searchData['email']) && Str::isNotBlank($searchData['email'])) {
            $qb
                ->andWhere('r.email like :email')
                ->setParameter('email', '%' . $searchData['email'] . '%');
        }

        // tel
        if (isset($searchData['tel']) && Str::isNotBlank($searchData['tel'])) {
            $qb
                ->andWhere('CONCAT(r.tel01, r.tel02, r.tel03) LIKE :tel')
                ->setParameter('tel', '%' . $searchData['tel'] . '%');
        }

        // sex
        if (!empty($searchData['sex']) && count($searchData['sex']) > 0) {
            $qb
                ->andWhere($qb->expr()->in('r.Sex', ':sex'))
                ->setParameter('sex', $searchData['sex']->toArray());
        }

        // order_date
        if (!empty($searchData['first_order_date_start']) && $searchData['first_order_date_start']) {
            $date = $searchData['first_order_date_start']
                ->format('Y-m-d H:i:s');
            $qb
                ->andWhere('r.order_date >= :first_order_date_start')
                ->setParameter('first_order_date_start', $date);
        }
        if (!empty($searchData['first_order_date_end']) && $searchData['first_order_date_end']) {
            $date = $searchData['first_order_date_end']
                ->modify('+1 days')
                ->format('Y-m-d H:i:s');
            $qb
                ->andWhere('r.order_date < :first_order_date_end')
                ->setParameter('first_order_date_end', $date);
        }

        // buy_product_id
        if (isset($searchData['buy_product_id']) && Str::isNotBlank($searchData['buy_product_id'])) {
            $qb
                ->leftJoin('r.RegularOrderDetails', 'od')
                ->leftJoin('od.Product', 'p')
                ->andWhere('p.id LIKE :buy_product_id')
                ->setParameter('buy_product_id', '%' . $searchData['buy_product_id'] . '%');
        }

        // buy_product_name
        if (isset($searchData['buy_product_name']) && Str::isNotBlank($searchData['buy_product_name'])) {
            $qb
                ->leftJoin('r.RegularOrderDetails', 'od')
                ->leftJoin('od.Product', 'p')
                ->andWhere('p.name LIKE :buy_product_name')
                ->setParameter('buy_product_name', '%' . $searchData['buy_product_name'] . '%');
        }

        // regular_count
        if (isset($searchData['regular_count_start']) && Str::isNotBlank($searchData['regular_count_start'])) {
            $qb
                ->andWhere('r.regular_order_count >= :regular_count_start')
                ->setParameter('regular_count_start', $searchData['regular_count_start']);
        }
        if (isset($searchData['regular_count_end']) && Str::isNotBlank($searchData['regular_count_end'])) {
            $qb
                ->andWhere('r.regular_order_count <= :regular_count_end')
                ->setParameter('regular_count_end', $searchData['regular_count_end']);
        }

        // Order By
        $qb->addOrderBy('r.update_date', 'DESC');

        return $qb;
    }

    public function getTargetRegularOrderId()
    {
        $qb = $this->createQueryBuilder('o');

        $RegularOrders = $qb->getQuery()
                            ->getResult();

        foreach ($RegularOrders as $key => $RegularOrder) {
            $LastOrder = $RegularOrder->getLastOrder();
            $nextCreateDate = $this->app['eccube.plugin.epsilon.service.regular']->getNextOrderDate($RegularOrder->getPayment(), $LastOrder->getCreateDate());
            if (!empty($nextCreateDate)) {
                unset($RegularOrders[$key]);
                continue;
            }
            $regularStatusId = $RegularOrder->getRegularStatus()->getId();
            if ($regularStatusId == 2) {
                unset($RegularOrders[$key]);
            }
        }

        return $RegularOrders;
    }
}
