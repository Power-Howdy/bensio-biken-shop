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
class Version201508072300 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->createPlgMailMagazinePlugin($schema);

        // create table MailMagazine Plug-in
        $this->createPlgMailMagazineTemplate($schema);
        $this->createPlgSendCustomer($schema);
        $this->createPlgSendHistory($schema);

        // create Sequence MailMagazine Plug-in
        $this->createPlgplgSendHistorySendIdSeq($schema);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('plg_mailmaga_plugin');

        // drop Sequence MailMagazine Plug-in
        $schema->dropTable('plg_mailmaga_template');
        $schema->dropTable('plg_send_history');
        $schema->dropTable('plg_send_customer');

        // drop sequence.
        $schema->dropSequence('plg_mailmaga_template_template_id_seq');
        $schema->dropSequence('plg_send_history_send_id_seq');
    }

    protected function createPlgMailMagazinePlugin(Schema $schema)
    {
        $table = $schema->createTable('plg_mailmaga_plugin');
        $table->addColumn('plugin_id', 'integer', array(
            'autoincrement' => true,
        ));

        $table->addColumn('plugin_code', 'text', array(
            'notnull' => true,
        ));

        $table->addColumn('plugin_name', 'text', array(
            'notnull' => true,
        ));

        $table->addColumn('sub_data', 'text', array(
            'notnull' => false,
        ));

        $table->addColumn('auto_update_flg', 'smallint', array(
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

        $table->setPrimaryKey(array('plugin_id'));
    }

    /***
     * plg_mailmaga_templateテーブルの作成
     * @param Schema $schema
     */
    protected function createPlgMailMagazineTemplate(Schema $schema)
    {
        $table = $schema->createTable('plg_mailmaga_template');
        $table->addColumn('template_id', 'integer', array(
            'autoincrement' => true,
        ));

        $table->addColumn('subject', 'text', array(
        ));

        $table->addColumn('body', 'text', array(
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

        $table->setPrimaryKey(array('template_id'));
    }

    /**
     * plg_send_customerテーブルの作成.
     *
     * @param Schema $schema
     */
    protected function createPlgSendCustomer(Schema $schema)
    {
        $table = $schema->createTable('plg_send_customer');
        $table->addColumn('send_id', 'integer', array(
            'notnull' => true,
        ));
        $table->addColumn('customer_id', 'integer', array(
            'notnull' => true,
        ));
        $table->addColumn('email', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('name', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('send_flag', 'smallint', array(
            'notnull' => false,
        ));
        $table->setPrimaryKey(array('send_id', 'customer_id'));

        // Indexの作成(customer_id)
        $table->addIndex(
            array('customer_id')
        );
    }

    /**
     * plg_send_historyテーブルの作成.
     *
     * @param Schema $schema
     */
    protected function createPlgSendHistory(Schema $schema)
    {
        $table = $schema->createTable('plg_send_history');
        $table->addColumn('send_id', 'integer', array(
            'notnull' => true,
        ));
        $table->addColumn('creator_id', 'integer', array(
            'notnull' => false,
        ));
        $table->addColumn('mail_method', 'smallint', array(
            'notnull' => false,
        ));
        $table->addColumn('subject', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('body', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('send_count', 'integer', array(
            'notnull' => false,
        ));
        $table->addColumn('complete_count', 'integer', array(
            'notnull' => true,
            'default' => 0,
        ));
        $table->addColumn('start_date', 'datetime', array(
            'unsigned' => false,
            'notnull' => false,
        ));
        $table->addColumn('end_date', 'datetime', array(
            'unsigned' => false,
            'notnull' => false,
        ));
        $table->addColumn('search_data', 'text', array(
            'notnull' => false,
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
        $table->setPrimaryKey(array('send_id'));

        // Indexの作成(creator_id)
        $table->addIndex(
            array('creator_id')
        );
    }

    /**
     * plg_send_history_send_id_seqの作成.
     *
     * @param Schema $schema
     */
    protected function createPlgplgSendHistorySendIdSeq(Schema $schema)
    {
        $seq = $schema->createSequence('plg_send_history_send_id_seq');
    }

    public function getMailMagazineCode()
    {
        $config = \Eccube\Application::alias('config');

        return '';
    }
}
