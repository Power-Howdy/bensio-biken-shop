<?php

namespace Plugin\EccubePaymentLite3\Repository\Extension;

use Doctrine\ORM\EntityRepository;
use Plugin\EccubePaymentLite3\Entity\Extension\ShippingExtension;

class ShippingExtensionRepository extends EntityRepository
{
    /**
     * @param $shippingId
     * @param $params
     * @return bool
     */
    public function insertOrUpdate($shippingId, $params)
    {
        try {
            /** @var ShippingExtension $ShippingExtension */
            $ShippingExtension = $this->find($shippingId);
            if (!$ShippingExtension) {
                $ShippingExtension = new ShippingExtension();
                $ShippingExtension->setId($shippingId);
            }

            $ShippingExtension->setTrackingNumber($params['tracking_number']);

            $em = $this->getEntityManager();
            $em->persist($ShippingExtension);
            $em->flush($ShippingExtension);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}
