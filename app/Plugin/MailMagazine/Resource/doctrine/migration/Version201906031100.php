<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Eccube\Application;
use Eccube\Common\Constant;
use Eccube\Entity\Master\CustomerStatus;
use Eccube\Entity\Master\Pref;
use Eccube\Entity\Master\Sex;
use Symfony\Component\Yaml\Yaml;

class Version201906031100 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $pdo = $this->connection->getWrappedConnection();

        // search_dataをserializeされたデータからjson形式に変換する
        $stmt = $pdo->prepare('SELECT send_id, search_data FROM plg_send_history;');
        $stmt->execute();

        foreach ($stmt as $row) {
            $formData = $this->unserializeWrapper(base64_decode($row['search_data']));

            // unserializeしたデータからJSONに変換
            $formDataArray = $formData;
            $formDataArray['pref'] = ($formData['pref'] instanceof Pref) ? $formData['pref']->toArray() : null;
            $formDataArray['sex'] = array_filter(array_map(function ($entity) {
                if ($entity instanceof Sex) {
                    return $entity->toArray();
                } else {
                    return false;
                }
            }, $formData['sex']->toArray()));
            $formDataArray['customer_status'] = array_filter(array_map(function ($entity) {
                if ($entity instanceof CustomerStatus) {
                    return $entity->toArray();
                } else {
                    return false;
                }
            }, $formData['customer_status']->toArray()));
            unset($formDataArray['buy_category']);

            $json = json_encode($formDataArray);

            // search_dataをUPDATEする
            $stmt = $pdo->prepare('UPDATE plg_send_history SET search_data = :search_data WHERE send_id = :send_id;');
            $stmt->execute(array(':search_data' => $json, ':send_id' => $row['send_id']));
        }
    }

    public function down(Schema $schema)
    {
    }

    /**
     * 互換性のないEntityを取り除いた状態でUnserialiseを実行する
     * Member,Customerは "__php_incomplete_class"となる.
     *
     * @param array $serializedData Base64でエンコードされたシリアライズデータ
     *
     * @return mixed unserializeしたデータ
     */
    private function unserializeWrapper($serializedData)
    {
        $serializedData = str_replace('DoctrineProxy\__CG__\Eccube\Entity\Member', '__Workaround_\__CG__\Eccube\Entity\Member', $serializedData);
        $serializedData = str_replace('DoctrineProxy\__CG__\Eccube\Entity\Customer', '__Workaround_\__CG__\Eccube\Entity\Customer', $serializedData);

        return unserialize($serializedData);
    }
}
