<?php

namespace Plugin\EccubePaymentLite3\Repository\Extension;

use Doctrine\ORM\EntityRepository;
use Plugin\EccubePaymentLite3\Entity\Extension\ProductExtension;

class ProductExtensionRepository extends EntityRepository
{
    /**
     * Insert data for product extension
     *
     * @param $productId
     * @param $params
     * @return bool
     */
    public function insertOrUpdate($productId, $params)
    {
        try {

            /** @var ProductExtension $ProductExtension */
            $ProductExtension = $this->findOneBy(array('product_id' => $productId));
            if (!$ProductExtension) {
                $ProductExtension = new ProductExtension();
            }
            $ProductExtension->setProductId($params['product_id']);
            // 分量に関するフリー記述
            $ProductExtension->setFreeDescriptionQuantity($params['free_description_quantity']);
            // 販売価格に関するフリー記述
            $ProductExtension->setFreeDescriptionSellingPrice($params['free_description_selling_price']);
            // お支払い・引き渡しに関するフリー記述
            $ProductExtension->setFreeDescriptionPaymentDelivery($params['free_description_payment_delivery']);

            $em = $this->getEntityManager();
            $em->persist($ProductExtension);
            $em->flush($ProductExtension);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

}
