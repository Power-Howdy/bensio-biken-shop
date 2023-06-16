<?php

namespace DoctrineMigrations;

use Plugin\EccubePaymentLite3\Entity\Master\DeliveryCompany;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20201204105348 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->createDeliveryCompany($schema);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('plg_paylite_delivery_company');
    }

    /**
     * @param Schema $schema
     */
    public function postUp(Schema $schema)
    {
        $app = new \Eccube\Application();
        $app->boot();

        $sql = "INSERT INTO plg_paylite_delivery_company(id, name, rank) VALUES (".DeliveryCompany::SAGAWA.", '".DeliveryCompany::SAGAWA_NAME."', 1);";
        $this->connection->executeUpdate($sql);

        $sql = "INSERT INTO plg_paylite_delivery_company(id, name, rank) VALUES (".DeliveryCompany::YAMATO.", '".DeliveryCompany::YAMATO_NAME."', 2);";
        $this->connection->executeUpdate($sql);

        $sql = "INSERT INTO plg_paylite_delivery_company(id, name, rank) VALUES (".DeliveryCompany::SEINO.", '".DeliveryCompany::SEINO_NAME."', 3);";
        $this->connection->executeUpdate($sql);

        $sql = "INSERT INTO plg_paylite_delivery_company(id, name, rank) VALUES (".DeliveryCompany::REGISTERED_MAIL__SPECIFIC_RECORD_MAIL.", '".DeliveryCompany::REGISTERED_MAIL__SPECIFIC_RECORD_MAIL_NAME."', 4);";
        $this->connection->executeUpdate($sql);

        $sql = "INSERT INTO plg_paylite_delivery_company(id, name, rank) VALUES (".DeliveryCompany::YUPACK__EXPACK__POST_PACKET.", '".DeliveryCompany::YUPACK__EXPACK__POST_PACKET_NAME."', 5);";
        $this->connection->executeUpdate($sql);

        $sql = "INSERT INTO plg_paylite_delivery_company(id, name, rank) VALUES (".DeliveryCompany::FUKUYAMA.", '".DeliveryCompany::FUKUYAMA_NAME."', 6);";
        $this->connection->executeUpdate($sql);

        $sql = "INSERT INTO plg_paylite_delivery_company(id, name, rank) VALUES (".DeliveryCompany::ECOHAI.", '".DeliveryCompany::ECOHAI_NAME."', 7);";
        $this->connection->executeUpdate($sql);

        $sql = "INSERT INTO plg_paylite_delivery_company(id, name, rank) VALUES (".DeliveryCompany::TEN_FLIGHT__LETTER_PACK__NEW_LIMITED_EXPRESS_MAIL__YU_PACKET.", '".DeliveryCompany::TEN_FLIGHT__LETTER_PACK__NEW_LIMITED_EXPRESS_MAIL__YU_PACKET_NAME."', 8);";
        $this->connection->executeUpdate($sql);
    }

    /**
     * Create table
     *
     * @param Schema $schema
     */
    public function createDeliveryCompany(Schema $schema)
    {
        $table = $schema->createTable('plg_paylite_delivery_company');

        $table->addColumn('id', 'smallint');
        $table->addColumn('name', 'text', array(
            'notnull' => true,
        ));
        $table->addColumn('rank', 'smallint', array(
            'notnull' => false,
        ));

        $table->setPrimaryKey(array('id'));
    }
}
