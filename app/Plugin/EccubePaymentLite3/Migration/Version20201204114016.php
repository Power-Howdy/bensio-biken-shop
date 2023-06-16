<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20201204114016 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->createShippingExtension($schema);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('plg_paylite_shipping_extension');
    }

    /**
     * Create table
     *
     * @param Schema $schema
     */
    public function createShippingExtension(Schema $schema)
    {
        $table = $schema->createTable('plg_paylite_shipping_extension');

        $table->addColumn('shipping_id', 'integer', array(
            'autoincrement' => true,
        ));
        $table->addColumn('tracking_number', 'string', array(
            'notnull' => false,
            'length' => '255',
        ));

        $table->setPrimaryKey(array('shipping_id'));
    }
}
