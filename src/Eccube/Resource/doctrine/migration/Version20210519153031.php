<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20210519153031 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        if ($schema->hasTable('dtb_customer')) {
            $table = $schema->getTable('dtb_customer');
            $table->addColumn('lineid', 'string', array('NotNull' => false, 'length' => 50));
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        if ($schema->hasTable('dtb_customer')) {
            $table = $schema->getTable('dtb_customer');
            $table->dropColumn('lineid');
        }
    }
}
