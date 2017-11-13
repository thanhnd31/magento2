<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 18/07/2017
 * Time: 10:07
 */

namespace ThanhND\Blog\Setup;


use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        // TODO: Implement install() method.
        $installer = $setup;
        $installer->startSetup();
        $table = $installer->getConnection()
            ->newTable($installer->getTable('thanhnd_blog_post'))
            ->addColumn('post_id',Table::TYPE_SMALLINT,null,
                ['identity'=>true,'nullable'=>false,'primary'=>true],'Post ID')
            ->addColumn('title',Table::TYPE_TEXT,255,
                ['nullable'=>false],'Blog Title')
            ->addColumn('content',Table::TYPE_TEXT,'2M',
                [],'Blog Content')
            ->addColumn('url_key',Table::TYPE_TEXT,100,
                ['nullable'=>true,'default'=>null],'Url Key')
            ->addColumn('is_active',Table::TYPE_SMALLINT,null,
                ['nullable'=>false,'default'=>0],'Is actived post')
            ->addColumn('creation_time',Table::TYPE_TIMESTAMP,null,
                ['nullable'=>false,'default'=>Table::TIMESTAMP_INIT],'Creation time')
            ->addColumn('update_time',Table::TYPE_TIMESTAMP, null,
                ['nullable'=>false,'default'=>Table::TIMESTAMP_INIT],'Update time')
            ->addIndex(
                $installer->getIdxName('thanhnd_blog_post',['url_key']),['url_key']
            )->setComment('ThanhND Blog Posts');

        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}