<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\ORM\Tools\SchemaTool;
use Eccube\Application;
use Plugin\Point\Entity;

/**
 * Class Version20151215144009
 * @package DoctrineMigrations
 */
class Version20151215144009 extends AbstractMigration
{
    protected $tables = array();

    protected $entities = array();

    protected $sequences = array();

    public function __construct()
    {
        $this->tables = array(
            'plg_point',
            'plg_point_customer',
            'plg_point_info',
            'plg_point_product_rate',
            'plg_point_snapshot',
        );

        $this->entities = array(
            'Plugin\Point\Entity\Point',
            'Plugin\Point\Entity\PointCustomer',
            'Plugin\Point\Entity\PointInfo',
            'Plugin\Point\Entity\PointProductRate',
            'Plugin\Point\Entity\PointSnapshot',
        );

        $this->sequences = array(
            'plg_point_plg_point_id_seq',
            'plg_point_customer_plg_point_customer_id_seq',
            'plg_point_info_plg_point_info_id_seq',
            'plg_point_product_rate_plg_point_product_rate_id_seq',
            'plg_point_snapshot_plg_point_snapshot_id_seq',
        );
    }

    /**
     * インストール時処理
     * @param Schema $schema
     * @return bool
     * @throws \Doctrine\ORM\Tools\ToolsException
     */
    public function up(Schema $schema)
    {
        $app = Application::getInstance();
        $em = $app['orm.em'];
        $classes = array();
        foreach ($this->entities as $entity) {
            $classes[] = $em->getMetadataFactory()->getMetadataFor($entity);
        }

        $tool = new SchemaTool($em);
        $tool->createSchema($classes);
    }

    /**
     * アンインストール時処理
     * @param Schema $schema
     * @throws \Doctrine\ORM\Tools\ToolsException
     */
    public function down(Schema $schema)
    {
        foreach ($this->tables as $table) {
            if ($schema->hasTable($table)) {
                $schema->dropTable($table);
            }
        }
        foreach ($this->sequences as $sequence) {
            if ($schema->hasSequence($sequence)) {
                $schema->dropSequence($sequence);
            }
        }
    }
}
