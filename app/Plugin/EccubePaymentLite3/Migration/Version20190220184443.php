<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;


class Version20190220184443 extends AbstractMigration
{

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->createPlgEpsilonCreditAccessBlock($schema);
        $this->createPlgEpsilonCreditAccessLogs($schema);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('plg_paylite_credit_access_block');
        $schema->dropTable('plg_paylite_credit_access_logs');
    }

    /**
     * create table plg_paylite_credit_access_block
     *
     * @param Schema $schema
     */
    protected function createPlgEpsilonCreditAccessBlock(Schema $schema)
    {
        $table = $schema->createTable('plg_paylite_credit_access_block');

        $table->addColumn('id', 'integer', array(
            'autoincrement' => true,
        ));
        $table->addColumn('ip_address', 'string', array(
            'notnull' => true,
            'length' => '255',
        ));
        $table->addColumn('block_date', 'datetime', array(
            'notnull' => true,
        ));

        $table->setPrimaryKey(array('id'));

        $table->addIndex(array('ip_address'),'plg_paylite_credit_access_block_ip_address_key');
    }

    /**
     * create table plg_paylite_credit_access_logs
     *
     * @param Schema $schema
     */
    public function createPlgEpsilonCreditAccessLogs(Schema $schema)
    {
        $table = $schema->createTable('plg_paylite_credit_access_logs');

        $table->addColumn('id', 'integer', array(
            'autoincrement' => true,
        ));
        $table->addColumn('ip_address', 'string', array(
            'notnull' => true,
            'length' => '255',
        ));
        $table->addColumn('access_date', 'datetime', array(
            'notnull' => true,
        ));

        $table->setPrimaryKey(array('id'));

        $table->addIndex(array('ip_address'),'plg_paylite_credit_access_logs_ip_address_key');
    }
}
