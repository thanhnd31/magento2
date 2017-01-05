<?php

namespace ThanhND\SliderWidget\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '0.0.2') < 0) {
            $sortColumnDefinintion = array(
                'type'=>\Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                'comment'=>'Sort Order',
                'nullable'=>false,
                'default'=>99
            );
            
            // Add column 'sort_order' to table 'sliderwidget_banner'
            $table = $setup->getTable('sliderwidget_banner');
            $setup->getConnection()->addColumn($table,'sort_order',$sortColumnDefinintion);
        }

        $setup->endSetup();
    }
}