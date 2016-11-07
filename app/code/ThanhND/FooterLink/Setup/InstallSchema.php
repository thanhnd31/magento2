<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 07/11/2016
 * Time: 15:44
 */

namespace ThanhND\FooterLink\Setup;

use League\CLImate\TerminalObject\Basic\Tab;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        /*
         * Create table 'thanhnd_footerlinke_group'
         */
        $table = $setup->getConnection()->newTable($setup->getTable('thanhnd_footerlink_group'))
            ->addColumn(
                'group_id',
                Table::TYPE_INTEGER,
                null,
                ['identity'=>true,'nullable'=>false,'primary'=>true],
                'Footer Links Group Id'
            )->addColumn(
                'group_name',
                Table::TYPE_TEXT,
                255,
                ['nullable'=>false],
                'Group name'
            )->addColumn(
                'store_ids',
                Table::TYPE_TEXT,
                255,
                ['nullable'=>false,'default'=>0],
                'List of store show this group'
            )->addColumn(
                'creattion_time',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable'=>false,'default'=>Table::TIMESTAMP_INIT],
                'Group creation time'
            )->addColumn(
                'update_time',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable'=>false,'default'=>Table::TIMESTAMP_INIT_UPDATE],
                'Group update time'
            )->addColumn(
                'sort_order',
                Table::TYPE_INTEGER,
                null,
                ['nullable'=>false,'default'=>99],
                'Sort order'
            )->addColumn(
                'is_active',
                Table::TYPE_SMALLINT,
                null,
                ['nullable'=>false,'default'=>0],
                'Show group in front end'
            );
        $setup->getConnection()->createTable($table);

        /*
         * Create table 'thanhnd_footerlink_link'
         */
        $table=$setup->getConnection()->newTable($setup->getTable('thanhnd_footerlink_link'))
            ->addColumn(
               'link_id',
                Table::TYPE_INTEGER,
                null,
                ['indentity'=>true,'nullable'=>false,'primary'=>true],
                'Footer link id'
            )->addColumn(
                'link_name',
                Table::TYPE_TEXT,
                255,
                ['nullable'=>false],
                'Link name'
            )->addColumn(
                'link',
                Table::TYPE_TEXT,
                255,
                ['nullable'=>false],
                'Target link'
            )->addColumn(
                'group_id',
                Table::TYPE_INTEGER,
                null,
                ['nullable'=>false],
                'Group id'
            )->addColumn(
                'creation_time',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable'=>false,'default'=>Table::TIMESTAMP_INIT],
                'Creattion time'
            )->addColumn(
                'upate_time',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable'=>false,'default'=>Table::TIMESTAMP_INIT_UPDATE],
                'Udate time'
            )->addColumn(
                'sort_order',
                Table::TYPE_INTEGER,
                null,
                ['nullable'=>false,'default'=>99],
                'Sort order'
            )->addColumn(
                'is_active',
                Table::TYPE_SMALLINT,
                null,
                ['nullable'=>false,'default'=>0],
                'Show in link group'
            )->addForeignKey(
                $setup->getFkName(
                    $setup->getTable('thanhnd_footerlink_link'),
                    'group_id',
                    $setup->getTable('thanhnd_footerlink_group'),
                    'group_id'
                ),
                'group_id',
                $setup->getTable('thanhnd_footerlink_group'),
                'group_id'
            );
        $setup->getConnection()->createTable($table);
    }
}