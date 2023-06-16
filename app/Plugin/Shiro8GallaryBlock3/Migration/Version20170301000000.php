<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20170301000000 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->createPluginTable($schema);
    }

    public function down(Schema $schema)
    {
        $schema->dropTable('plg_shiro8_product_gallary');
    }

    protected function createPluginTable(Schema $schema)
    {
        $table = $schema->createTable("plg_shiro8_product_gallary");
        $table->addColumn('product_id', 'integer', array(
            'notnull' => true,
        ));

        $table->addColumn('use_flg', 'integer', array(
            'notnull' => false,
        ));

        $table->setPrimaryKey(array('product_id'));
        
    }
}