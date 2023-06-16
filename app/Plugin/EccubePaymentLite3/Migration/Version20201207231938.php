<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20201207231938 extends AbstractMigration
{

    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->createPlgEpsilonMember($schema);
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $app = new \Eccube\Application();
        $app->initialize();
        $app->initializePlugin();
        $app->boot();
        $schema->dropTable('plg_paylite_member');
    }

    /**
     * Create plg_paylite_member
     * @param Schema $schema
    */
    public function createPlgEpsilonMember(Schema $schema)
    {
        $table = $schema->createTable("plg_paylite_member");
        $table->addColumn('id', 'integer', array(
            'autoincrement' => true,
        ));

        $table->addColumn('customer_id', 'integer', array(
            'notnull' => true,
        ));

        $table->addColumn('gmo_epsilon_credit_card_expiration_date', 'datetime', array(
            'notnull' => false,
        ));
        $table->addColumn('card_change_request_mail_send_date', 'datetime', array(
            'notnull' => false,
        ));

        $table->addColumn('create_date', 'datetime', array(
            'notnull' => true,
            'unsigned' => false,
        ));

        $table->addColumn('update_date', 'datetime', array(
            'notnull' => true,
            'unsigned' => false,
        ));

        // Create foreign key between plg_paylite_member and dtb_customer.
        $targetTable = $schema->getTable('dtb_customer');
        $table->addForeignKeyConstraint(
            $targetTable, array('customer_id'), array('customer_id')
        );
        $table->setPrimaryKey(array('id'));
    }

}
