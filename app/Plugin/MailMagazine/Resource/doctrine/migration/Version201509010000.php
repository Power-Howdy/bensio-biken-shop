<?php
/*
* This file is part of EC-CUBE
*
* Copyright(c) EC-CUBE CO.,LTD. All Rights Reserved.
* https://www.ec-cube.co.jp/
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version201509010000 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->createPlgMailmagaCustomer($schema);

        $table = $schema->getTable('plg_send_history');
        $table->addIndex(
            array('send_id', 'creator_id')
        );
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('plg_mailmaga_customer');
        $schema->dropSequence('plg_mailmaga_customer_id_seq');
    }

    /***
     * plg_mailmaga_customerテーブルの作成
     *
     * CREATE SEQUENCE plg_mailmaga_customer_id_seq;
     * CREATE TABLE plg_mailmaga_customer (
     *   id integer DEFAULT nextval('plg_mailmaga_customer_id_seq'::regclass) NOT NULL PRIMARY KEY,
     *   customer_id integer NOT NULL,
     *   mailmag_flg smallint DEFAULT 0 NOT NULL,
     *   del_flg smallint DEFAULT 0 NOT NULL,
     *   create_date timestamp(0) without time zone NOT NULL,
     *   update_date timestamp(0) without time zone NOT NULL
     *);
     *
     * @param Schema $schema
     */
    protected function createPlgMailmagaCustomer(Schema $schema)
    {
        $table = $schema->createTable('plg_mailmaga_customer');
        $table->addColumn('id', 'integer', array(
            'autoincrement' => true,
        ));

        $table->addColumn('customer_id', 'integer', array(
            'notnull' => true,
        ));

        $table->addColumn('mailmaga_flg', 'smallint', array(
            'notnull' => true,
            'unsigned' => false,
            'default' => 0,
        ));

        $table->addColumn('del_flg', 'smallint', array(
            'notnull' => true,
            'unsigned' => false,
            'default' => 0,
        ));

        $table->addColumn('create_date', 'datetime', array(
            'notnull' => true,
            'unsigned' => false,
        ));

        $table->addColumn('update_date', 'datetime', array(
            'notnull' => true,
            'unsigned' => false,
        ));

        $table->setPrimaryKey(array('id'));
    }
}
