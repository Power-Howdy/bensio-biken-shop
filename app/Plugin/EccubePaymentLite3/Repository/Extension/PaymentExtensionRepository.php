<?php

namespace Plugin\EccubePaymentLite3\Repository\Extension;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\Query;
use Plugin\EccubePaymentLite3\Entity\Extension\PaymentExtension;

class PaymentExtensionRepository extends EntityRepository
{

    /**
     * @var array array of configs
     */
    private $config;

    /**
     * Set the config of this repository
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * Find or create payment method
     *
     * @param $id
     * @return PaymentExtension
     */
    public function findOrCreate($id)
    {
        if ($id == 0) {
            $PaymentExtension = new PaymentExtension();
        } else {
            $PaymentExtension = $this->find($id);
        }

        return $PaymentExtension;
    }

    /**
     * Get all payment_id of table dtb_payment base on plugin_code of table plg_paylite_payment_extension
     *
     * @param bool $incDel Flag for counting deleted record
     * @param /Eccube/Application $app
     * @return array()
     */
    public function getPaymentByCode($incDel, $app)
    {
        $softDeleteFilter = $app['orm.em']->getFilters()->getFilter('soft_delete');
        $originExcludes = $softDeleteFilter->getExcludes();

        if ($incDel){
            $softDeleteFilter->setExcludes(array(
                'Eccube\Entity\Payment',
                'Plugin\EccubePaymentLite3\Entity\Extension\PaymentExtension'
            ));
        }

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
            ->select('p.id')
            ->from('\Eccube\Entity\Payment', 'p')
            ->innerJoin('\Plugin\EccubePaymentLite3\Entity\Extension\PaymentExtension', 'g', 'WITH', 'p.id = g.id')
            ->where($qb->expr()->andx(
                $qb->expr()->eq('g.plugin_code', ':plugin_code'))
            );
        $qb->setParameter('plugin_code', $this->config['PLUGIN_CODE']);

        $ret = $qb
            ->getQuery()
            ->getResult();

        if ($incDel){
            $softDeleteFilter->setExcludes($originExcludes);
        }

        return $ret;


    }

    /**
     * Get payment by type, with option to including or excluding deleted record
     *
     * @param  $paymentTypeId
     * @param bool $incDel Flag for counting deleted record
     * @param /Eccube/Application $app
     * @return int|mixed|string|null
     * @throws NonUniqueResultException
     */
    public function getPaymentByType($paymentTypeId, $incDel, $app)
    {
        $softDeleteFilter = $app['orm.em']->getFilters()->getFilter('soft_delete');
        $originExcludes = $softDeleteFilter->getExcludes();

        if ($incDel){
            $softDeleteFilter->setExcludes(array(
                'Eccube\Entity\Payment',
                'Plugin\EccubePaymentLite3\Entity\Extension\PaymentExtension'
            ));
        }

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
            ->select('p')
            ->from('\Eccube\Entity\Payment', 'p')
            ->join('\Plugin\EccubePaymentLite3\Entity\Extension\PaymentExtension', 'g', 'WITH', 'p.id = g.id')
            ->where(
                $qb->expr()->eq('g.payment_type_id', ':x')
            );
        $qb->setParameter('x', $paymentTypeId);

        $ret = $qb
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();

        if ($incDel){
            $softDeleteFilter->setExcludes($originExcludes);
        }

        return $ret;
    }

    /**
     * Get PaymentExtension
     *
     * @param string $field
     * @param string $value
     * @param bool $incDel Flag for counting deleted record
     * @param /Eccube/Application $app
     * @return PaymentExtension
     */
    public function getPaymentExtension($field, $value, $incDel, $app){
        $softDeleteFilter = $app['orm.em']->getFilters()->getFilter('soft_delete');
        $originExcludes = $softDeleteFilter->getExcludes();

        if ($incDel){
            $softDeleteFilter->setExcludes(array(
                'Plugin\EccubePaymentLite3\Entity\Extension\PaymentExtension'
            ));
        }

        $PaymentExtension = $app['eccube.plugin.epsilon.repository.payment_extension']->findOneBy(array($field => $value));

        if ($incDel){
            $softDeleteFilter->setExcludes($originExcludes);
        }

        return $PaymentExtension;
    }

    /**
     * Get payment list
     *
     * @return array
     */
    public function getPaymentList()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
            ->select('p.id')
            ->from('\Eccube\Entity\Payment', 'p')
            ->join('\Plugin\EccubePaymentLite3\Entity\Extension\PaymentExtension', 'g', 'WITH', 'p.id = g.id')
            ->where(
                $qb->expr()->eq('g.code', ':x')
            );
        $qb->setParameter('x', $this->config['PG_MULPAY_CODE']);
        return $qb
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * Delete payment
     *
     * @param  $paymentId
     * @return boolean
     * @throws OptimisticLockException
     */
    public function deletePayment($paymentId)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
            ->select('p')
            ->from('\Eccube\Entity\Payment', 'p')
            ->where($qb->expr()->andx(
                $qb->expr()->eq('p.del_flg', 0),
                $qb->expr()->eq('p.id', ':id'))
            );
        $qb->setParameter('id', $paymentId);

        try {
            $Payment = $qb
                ->getQuery()
                ->setMaxResults(1)
                ->getSingleResult();

        } catch (\Exception $e) {
            return false;
        }

        $em = $this->getEntityManager();
        $em->remove($Payment);
        $em->flush();

        return true;
    }

}
