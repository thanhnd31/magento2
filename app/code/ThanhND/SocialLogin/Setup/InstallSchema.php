<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 26/09/2017
 * Time: 16:34
 */

namespace ThanhND\SocialLogin\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class InstallSchema
 * @package ThanhND\SocialLogin\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
	/**
	 * @param SchemaSetupInterface $setup
	 * @param ModuleContextInterface $context
	 */
	public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
	{
		$installer = $setup;
		$installer->startSetup();

		// Create table 'thanhnd_sociallogin'
		$table = $installer->getConnection()->newTable(
			$installer->getTable('thanhnd_sociallogin')
		)->addColumn(
			'entity_id',
			Table::TYPE_INTEGER,
			10,
			[
				'identity' => true,
				'nullable' => false,
				'primary'  => true,
				'unsigned' => true
			],
			'Entity ID'
		)->addColumn(
			'social_id',
			Table::TYPE_TEXT,
			50,
			[
				'nullable' => false
			],
			'Social Id'
		)->addColumn(
			'customer_id',
			Table::TYPE_INTEGER,
			10,
			[
				'nullable' => false,
				'unsigned' => true
			],
			'Customer Id'
		)->addColumn(
			'type',
			Table::TYPE_TEXT,
			50,
			[
				'default' => '',
				'nullable' => false
			],
			'Type'
		)->addColumn(
			'creation_time',
			Table::TYPE_TIMESTAMP,
			null,
			[
				'nullable' => false,
				'default' => Table::TIMESTAMP_INIT
			],
			'Creation Time'
		)->addColumn(
			'update_time',
			Table::TYPE_TIMESTAMP,
			null,
			[
				'nullable' => false,
				'default' => Table::TIMESTAMP_INIT_UPDATE
			],
			'Modification Time'
		);

		$installer->getConnection()->createTable($table);
		//END table setup

		$installer->getConnection()->addIndex(
			$installer->getTable('thanhnd_sociallogin'),
			$installer->getIdxName('thanhnd_sociallogin', ['social_id']),
			['social_id']
		);

		$installer->getConnection()->addIndex(
			$installer->getTable('thanhnd_sociallogin'),
			$installer->getIdxName('thanhnd_sociallogin', ['customer_id']),
			['customer_id']
		);

		$installer->getConnection()->addIndex(
			$installer->getTable('thanhnd_sociallogin'),
			$installer->getIdxName('thanhnd_sociallogin', ['type']),
			['type']
		);

		$installer->endSetup();
	}
}