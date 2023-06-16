<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20201203142839 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $table = $schema->getTable('plg_paylite_order_extension');

        $table->addColumn('payment_status_id', 'smallint', array(
            'notnull' => false,
        ));
        $table->addColumn('gmo_epsilon_order_no', 'string', array(
            'notnull' => false,
            'length' => '255',
        ));
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
    }
}
