<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Eccube\Application;


class Version20151028184539 extends AbstractMigration
{

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->createPlgEpsilonPlugin($schema);
        $this->createPlgEpsilonOrderExtension($schema);
        $this->createPlgEpsilonPaymentExtension($schema);
        $this->createPlgEpsilonRegularProduct($schema);
        $this->createPlgEpsilonRegularStatus($schema);
        $this->createPlgEpsilonRegularOrder($schema);
        $this->createPlgEpsilonRegularOrderDetail($schema);
        $this->createPlgEpsilonRegularShipping($schema);
        $this->createPlgEpsilonRegularShipmentItem($schema);
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

        $this->deleteFromDtbPayment();
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('plg_paylite_plugin');
        $schema->dropTable('plg_paylite_order_extension');
        $schema->dropTable('plg_paylite_payment_extension');
        $schema->dropTable('plg_paylite_regular_product');
        $schema->dropTable('plg_paylite_regular_shipment_item');
        $schema->dropTable('plg_paylite_regular_shipping');
        $schema->dropTable('plg_paylite_regular_order_detail');
        $schema->dropTable('plg_paylite_regular_order');
        $schema->dropTable('plg_paylite_regular_status');
    }

    public function postUp(Schema $schema)
    {
        $app = new Application();
        $app->boot();
        $pluginCode = 'EccubePaymentLite3';
        $pluginName = 'EccubePaymentLite3';
        $datetime = date('Y-m-d H:i:s');
        $insert = "INSERT INTO plg_paylite_plugin(plugin_code, plugin_name, create_date, update_date)
                    VALUES ('$pluginCode', '$pluginName', '$datetime', '$datetime');";
        $this->connection->executeUpdate($insert);

        $insert = "INSERT INTO plg_paylite_regular_product(id, product_type_id, regular_flg, create_date, update_date)
                    VALUES (1, 0, 0, '$datetime', '$datetime');";
        $this->connection->executeUpdate($insert);

        $insert = "INSERT INTO plg_paylite_regular_status VALUES (1, '継続', 0);";
        $this->connection->executeUpdate($insert);

        $insert = "INSERT INTO plg_paylite_regular_status VALUES (2, '解約', 1);";
        $this->connection->executeUpdate($insert);
    }

    protected function createPlgEpsilonPlugin(Schema $schema)
    {
        $table = $schema->createTable("plg_paylite_plugin");

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

    protected function createPlgEpsilonOrderExtension(Schema $schema)
    {
        $table = $schema->createTable("plg_paylite_order_extension");

        $table->addColumn('order_id', 'integer', array(
            'autoincrement' => true,
        ));
        $table->addColumn('trans_code', 'text', array(
            'notnull' => true,
        ));
        $table->addColumn('regular_order_id', 'integer', array(
            'notnull' => false,
        ));

        $table->addColumn('payment_info', 'text', array(
            'notnull' => false,
        ));

        $table->setPrimaryKey(array('order_id'));
    }

    protected function createPlgEpsilonPaymentExtension(Schema $schema)
    {
        $table = $schema->createTable("plg_paylite_payment_extension");

        $table->addColumn('payment_id', 'integer', array(
            'notnull' => true,
        ));
        $table->addColumn('payment_method', 'text', array(
            'notnull' => true,
        ));
        $table->addColumn('payment_type_id', 'integer', array(
            'notnull' => true,
        ));
        $table->addColumn('st_code', 'text', array(
            'notnull' => true,
        ));
        $table->addColumn('mission_code', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('plugin_code', 'text', array(
            'notnull' => true,
        ));

        $table->setPrimaryKey(array('payment_id'));
    }


    /**
     * create table plg_paylite_regular_product
     *
     * @param Schema $schema
     */
    protected function createPlgEpsilonRegularProduct(Schema $schema)
    {
        $table = $schema->createTable('plg_paylite_regular_product');

        $table->addColumn('id', 'smallint', array(
            'autoincrement' => true,
        ));
        $table->addColumn('product_type_id', 'integer', array(
            'notnull' => false,
            'default' => 0,
        ));
        $table->addColumn('regular_flg', 'smallint', array(
            'notnull' => true,
            'default' => 0,
        ));
        $table->addColumn('create_flg', 'smallint', array(
            'notnull' => true,
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

    /**
     * create table plg_paylite_regular_status
     *
     * @param Schema $schema
     */
    public function createPlgEpsilonRegularStatus(Schema $schema)
    {
        $table = $schema->createTable('plg_paylite_regular_status');

        $table->addColumn('id', 'smallint');
        $table->addColumn('name', 'text', array(
            'notnull' => true,
        ));
        $table->addColumn('rank', 'smallint', array(
            'notnull' => false,
        ));

        $table->setPrimaryKey(array('id'));
    }

    /**
     * create table plg_paylite_regular_order
     *
     * @param Schema $schema
     */
    public function createPlgEpsilonRegularOrder(Schema $schema)
    {
        $table = $schema->createTable('plg_paylite_regular_order');

        $table->addColumn('regular_order_id', 'integer', array(
            'autoincrement' => true,
        ));
        $table->addColumn('customer_id', 'integer', array(
            'notnull' => false,
        ));
        $table->addColumn('order_country_id', 'smallint', array(
            'notnull' => false,
        ));
        $table->addColumn('order_pref', 'smallint', array(
            'notnull' => false,
        ));
        $table->addColumn('order_sex', 'smallint', array(
            'notnull' => false,
        ));
        $table->addColumn('order_job', 'smallint', array(
            'notnull' => false,
        ));
        $table->addColumn('payment_id', 'integer', array(
            'notnull' => false,
        ));
        $table->addColumn('device_type_id', 'smallint', array(
            'notnull' => false,
        ));
        $table->addColumn('pre_order_id', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('message', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('order_name01', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('order_name02', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('order_kana01', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('order_kana02', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('order_company_name', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('order_email', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('order_tel01', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('order_tel02', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('order_tel03', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('order_fax01', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('order_fax02', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('order_fax03', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('order_zip01', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('order_zip02', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('order_zipcode', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('order_addr01', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('order_addr02', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('order_birth', 'datetime', array(
            'notnull' => false,
        ));
        $table->addColumn('subtotal', 'decimal', array(
            'notnull' => false,
        ));
        $table->addColumn('discount', 'decimal', array(
            'notnull' => true,
            'default' => 0,
        ));
        $table->addColumn('delivery_fee_total', 'decimal', array(
            'notnull' => false,
        ));
        $table->addColumn('charge', 'decimal', array(
            'notnull' => false,
        ));
        $table->addColumn('tax', 'decimal', array(
            'notnull' => false,
        ));
        $table->addColumn('total', 'decimal', array(
            'notnull' => false,
        ));
        $table->addColumn('payment_total', 'decimal', array(
            'notnull' => false,
        ));
        $table->addColumn('payment_method', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('note', 'text', array(
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
        $table->addColumn('order_date', 'datetime', array(
            'notnull' => false,
            'unsigned' => false,
        ));
        $table->addColumn('del_flg', 'smallint', array(
            'notnull' => true,
            'unsigned' => false,
            'default' => 0,
        ));
        $table->addColumn('status', 'smallint', array(
            'notnull' => false,
        ));
        $table->addColumn('trans_code', 'text', array(
            'notnull' => true,
        ));
        $table->addColumn('regular_order_count', 'smallint', array(
            'notnull' => true,
            'default' => 1,
        ));
        $table->addColumn('regular_status', 'smallint', array(
            'notnull' => true,
            'default' => 1,
        ));
        $table->addColumn('first_order_id', 'integer', array(
            'notnull' => true,
        ));
        $table->addColumn('last_order_id', 'integer', array(
            'notnull' => true,
        ));

        $table->setPrimaryKey(array('regular_order_id'));

        $table->addForeignKeyConstraint('mtb_country', array('order_country_id'), array('id'));
        $table->addForeignKeyConstraint('dtb_payment', array('payment_id'), array('payment_id'));
        $table->addForeignKeyConstraint('mtb_device_type', array('device_type_id'), array('id'));
        $table->addForeignKeyConstraint('dtb_customer', array('customer_id'), array('customer_id'));
        $table->addForeignKeyConstraint('mtb_sex', array('order_sex'), array('id'));
        $table->addForeignKeyConstraint('mtb_job', array('order_job'), array('id'));
        $table->addForeignKeyConstraint('mtb_pref', array('order_pref'), array('id'));
    }

    /**
     * create table plg_paylite_regular_order_detail
     *
     * @param Schema $schema
     */
    public function createPlgEpsilonRegularOrderDetail(Schema $schema)
    {
        $table = $schema->createTable('plg_paylite_regular_order_detail');

        $table->addColumn('regular_order_detail_id', 'integer', array(
            'autoincrement' => true,
        ));
        $table->addColumn('regular_order_id', 'integer', array(
            'notnull' => true,
        ));
        $table->addColumn('product_id', 'integer', array(
            'notnull' => true,
        ));
        $table->addColumn('product_class_id', 'integer', array(
            'notnull' => true,
        ));
        $table->addColumn('product_name', 'text', array(
            'notnull' => true,
        ));
        $table->addColumn('product_code', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('class_name1', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('class_name2', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('class_category_name1', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('class_category_name2', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('price', 'decimal', array(
            'notnull' => false,
        ));
        $table->addColumn('quantity', 'decimal', array(
            'notnull' => false,
        ));
        $table->addColumn('tax_rate', 'decimal', array(
            'notnull' => false,
        ));
        $table->addColumn('tax_rule', 'smallint', array(
            'notnull' => false,
        ));

        $table->setPrimaryKey(array('regular_order_detail_id'));

        $table->addForeignKeyConstraint('dtb_product_class', array('product_class_id'), array('product_class_id'));
        $table->addForeignKeyConstraint('dtb_product', array('product_id'), array('product_id'));
        $table->addForeignKeyConstraint('plg_paylite_regular_order', array('regular_order_id'), array('regular_order_id'));
    }

    /**
     * create table plg_paylite_regular_shipping
     *
     * @param Schema $schema
     */
    public function createPlgEpsilonRegularShipping(Schema $schema)
    {
        $table = $schema->createTable('plg_paylite_regular_shipping');

        $table->addColumn('regular_shipping_id', 'integer', array(
            'autoincrement' => true,
        ));
        $table->addColumn('shipping_country_id', 'smallint', array(
            'notnull' => false,
        ));
        $table->addColumn('shipping_pref', 'smallint', array(
            'notnull' => false,
        ));
        $table->addColumn('regular_order_id', 'integer', array(
            'notnull' => false,
        ));
        $table->addColumn('delivery_id', 'integer', array(
            'notnull' => false,
        ));
        $table->addColumn('time_id', 'integer', array(
            'notnull' => false,
        ));
        $table->addColumn('fee_id', 'integer', array(
            'notnull' => false,
        ));
        $table->addColumn('shipping_name01', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('shipping_name02', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('shipping_kana01', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('shipping_kana02', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('shipping_company_name', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('shipping_tel01', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('shipping_tel02', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('shipping_tel03', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('shipping_fax01', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('shipping_fax02', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('shipping_fax03', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('shipping_zip01', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('shipping_zip02', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('shipping_zipcode', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('shipping_addr01', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('shipping_addr02', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('shipping_delivery_name', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('shipping_delivery_time', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('shipping_delivery_date', 'datetime', array(
            'notnull' => false,
        ));
        $table->addColumn('shipping_delivery_fee', 'decimal', array(
            'notnull' => false,
        ));
        $table->addColumn('rank', 'integer', array(
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
        $table->addColumn('del_flg', 'smallint', array(
            'notnull' => true,
            'unsigned' => false,
            'default' => 0,
        ));

        $table->setPrimaryKey(array('regular_shipping_id'));

        $table->addForeignKeyConstraint('dtb_delivery', array('delivery_id'), array('delivery_id'));
        $table->addForeignKeyConstraint('mtb_pref', array('shipping_pref'), array('id'));
        $table->addForeignKeyConstraint('mtb_country', array('shipping_country_id'), array('id'));
        $table->addForeignKeyConstraint('dtb_delivery_time', array('time_id'), array('time_id'));
        $table->addForeignKeyConstraint('plg_paylite_regular_order', array('regular_order_id'), array('regular_order_id'));
        $table->addForeignKeyConstraint('dtb_delivery_fee', array('fee_id'), array('fee_id'));
    }

    /**
     * create table plg_paylite_regular_shipment_item
     *
     * @param Schema $schema
     */
    public function createPlgEpsilonRegularShipmentItem(Schema $schema)
    {
        $table = $schema->createTable('plg_paylite_regular_shipment_item');

        $table->addColumn('regular_item_id', 'integer', array(
            'autoincrement' => true,
        ));
        $table->addColumn('regular_order_id', 'integer', array(
            'notnull' => true,
        ));
        $table->addColumn('product_id', 'integer', array(
            'notnull' => true,
        ));
        $table->addColumn('product_class_id', 'integer', array(
            'notnull' => true,
        ));
        $table->addColumn('regular_shipping_id', 'integer', array(
            'notnull' => true,
        ));
        $table->addColumn('product_name', 'text', array(
            'notnull' => true,
        ));
        $table->addColumn('product_code', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('class_name1', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('class_name2', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('class_category_name1', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('class_category_name2', 'text', array(
            'notnull' => false,
        ));
        $table->addColumn('price', 'decimal', array(
            'notnull' => false,
        ));
        $table->addColumn('quantity', 'decimal', array(
            'notnull' => false,
        ));

        $table->setPrimaryKey(array('regular_item_id'));

        $table->addForeignKeyConstraint('dtb_product_class', array('product_class_id'), array('product_class_id'));
        $table->addForeignKeyConstraint('dtb_product', array('product_id'), array('product_id'));
        $table->addForeignKeyConstraint('plg_paylite_regular_shipping', array('regular_shipping_id'), array('regular_shipping_id'));
        $table->addForeignKeyConstraint('plg_paylite_regular_order', array('regular_order_id'), array('regular_order_id'));
    }


    protected function deleteFromDtbPayment()
    {
        $select = "SELECT p.payment_id FROM plg_paylite_payment_extension as epsilon
                INNER JOIN dtb_payment as p ON epsilon.payment_id = p.payment_id
                WHERE epsilon.plugin_code = 'EccubePaymentLite3'";

        $paymentIds = $this->connection->executeQuery($select)->fetchAll();
        $ids = array();

        foreach ($paymentIds as $item){
            $ids[]=$item['payment_id'];
        }

        if (!empty($ids)){
            $param = implode(",", $ids);
            $update = "UPDATE dtb_payment SET del_flg = 1 WHERE payment_id in ($param)";
            $this->connection->executeUpdate($update);
        }

    }

    function getGmoEpsilonCode()
    {
        $config = Application::alias('config');

        return "";
    }
}
