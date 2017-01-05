<?php
/**
 * Created by PhpStorm.
 * User: smart
 * Date: 9/13/2016
 * Time: 9:13 AM
 */

namespace ThanhND\SliderWidget\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $moduleContext)
    {
        $installer = $setup;
        $installer->startSetup();
        $connection = $installer->getConnection();

        /**
         * Create table 'sliderwidget_slider'
         */

        $table = $connection->newTable(
            $installer->getTable('sliderwidget_slider')
        )->addColumn(
            'slider_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['identity'=>true,'nullable'=>false, 'primary'=>true],
            'Slider ID'
        )->addColumn(
            'title',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable'=>false],
            'Slider Title'
        )->addColumn(
            'creation_time',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable'=>false,'default'=>\Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
            'Creation Time'
        )->addColumn(
            'update_time',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable'=>false,'default'=>\Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
            'Modifiction Time'
        )->addColumn(
            'is_active',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable'=>false],
            'Can show in front end'
        );
        $connection->createTable($table);


        /**
         * Create table 'sliderwidget_banner'
         */
        $table = $connection->newTable(
            $installer->getTable('sliderwidget_banner')
        )->addColumn(
            'banner_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity'=>true,'nullable'=>false,'primary'=>true],
            'Banner ID'
        )->addColumn(
            'title',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable'=>false],
            'Banner Title'
        )->addColumn(
            'image',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable'=>false],
            'Banner Image URL'
        )->addColumn(
            'link',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable'=>false],
            'Banner Target Link'
        )->addColumn(
            'slider_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable'=>true],
            'Slider Id'
        )->addColumn(
            'creattion_time',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable'=>false,'default'=>\Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
            'Creation Time'
        )->addColumn(
            'update_time',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable'=>false,'default'=>\Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
            'Update Time'
        )->addColumn(
            'status',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable'=>false],
            'Show in front end'
        )->addForeignKey(
            'fk_banner_slider',
            'slider_id',
            'sliderwidget_slider',
            'slider_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_SET_NULL
        );
        $connection->createTable($table);

        $installer->endSetup();
    }
}