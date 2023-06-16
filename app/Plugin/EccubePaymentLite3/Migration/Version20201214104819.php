<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20201214104819 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->createDeliveryExtension($schema);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('plg_paylite_delivery_extension');
    }

    /**
     * Create table
     *
     * @param Schema $schema
     */
    public function createDeliveryExtension(Schema $schema)
    {
        $table = $schema->createTable('plg_paylite_delivery_extension');

        $table->addColumn('delivery_id', 'integer', array(
            'autoincrement' => true,
        ));
        $table->addColumn('delivery_company_id', 'smallint', array(
            'notnull' => false,
        ));

        $table->setPrimaryKey(array('delivery_id'));
    }
}
