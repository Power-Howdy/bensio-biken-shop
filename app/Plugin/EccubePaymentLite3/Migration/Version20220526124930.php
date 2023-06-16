<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Eccube\Application;


class Version20220526124930 extends AbstractMigration
{

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->createPlgEpsilonProductExtension($schema);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $app = new Application();
        $app->initialize();
        $app->initializePlugin();
        $app->boot();

        // this down() migration is auto-generated, please modify it to your needs

        $schema->dropTable('plg_paylite_product_extension');
    }

    protected function createPlgEpsilonProductExtension(Schema $schema)
    {
        $table = $schema->createTable("plg_paylite_product_extension");

        $table->addColumn('id', 'integer', array(
            'autoincrement' => true,
        ));
        $table->addColumn('product_id', 'integer', array(
            'notnull' => true,
        ));
        $table->addColumn('free_description_quantity', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('free_description_selling_price', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('free_description_payment_delivery', 'text', array(
            'notnull' => false,
        ));


        $table->setPrimaryKey(array('id'));
    }
}
