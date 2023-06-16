<?php

namespace DoctrineMigrations;

use Plugin\EccubePaymentLite3\Entity\Master\PaymentStatus;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20201203095921 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->createPaymentStatus($schema);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('plg_paylite_payment_status');
    }

    /**
     * @param Schema $schema
     */
    public function postUp(Schema $schema)
    {
        $app = new \Eccube\Application();
        $app->boot();

        $sql = "INSERT INTO plg_paylite_payment_status(id, name, rank) VALUES (".PaymentStatus::UNPAID.", '未課金', 1);";
        $this->connection->executeUpdate($sql);

        $sql = "INSERT INTO plg_paylite_payment_status(id, name, rank) VALUES (".PaymentStatus::CHARGED.", '課金済み', 2);";
        $this->connection->executeUpdate($sql);

        $sql = "INSERT INTO plg_paylite_payment_status(id, name, rank) VALUES (".PaymentStatus::UNDER_REVIEW.", '審査中', 3);";
        $this->connection->executeUpdate($sql);

        $sql = "INSERT INTO plg_paylite_payment_status(id, name, rank) VALUES (".PaymentStatus::TEMPORARY_SALES.", '仮売上', 4);";
        $this->connection->executeUpdate($sql);

        $sql = "INSERT INTO plg_paylite_payment_status(id, name, rank) VALUES (".PaymentStatus::SHIPPING_REGISTRATION.", '出荷登録中', 5);";
        $this->connection->executeUpdate($sql);

        $sql = "INSERT INTO plg_paylite_payment_status(id, name, rank) VALUES (".PaymentStatus::CANCEL.", 'キャンセル', 6);";
        $this->connection->executeUpdate($sql);

        $sql = "INSERT INTO plg_paylite_payment_status(id, name, rank) VALUES (".PaymentStatus::EXAMINATION_NG.", '審査NG', 7);";
        $this->connection->executeUpdate($sql);
    }

    /**
     * Create table
     *
     * @param Schema $schema
     */
    public function createPaymentStatus(Schema $schema)
    {
        $table = $schema->createTable('plg_paylite_payment_status');

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
