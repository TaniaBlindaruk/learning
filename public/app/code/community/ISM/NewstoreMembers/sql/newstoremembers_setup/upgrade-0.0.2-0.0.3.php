<?php
/**
 * Created by PhpStorm.
 * User: t.blindaruk
 * Date: 05.05.15
 * Time: 16:13
 */

/** @var Mage_Core_Model_Resource_Setup $installer */
$installer = $this;

$installer->startSetup();


$installer->getConnection()

->addForeignKey(
    $installer->getFkName('newstoremembers/table_newstoremembers', 'customer_id', 'customer/entity', 'entity_id'),
    $installer->getTable('newstoremembers/table_newstoremembers'),
    'customer_id',
    $installer->getTable('customer/entity'),
    'entity_id',
    Varien_Db_Ddl_Table::ACTION_SET_NULL,
    Varien_Db_Ddl_Table::ACTION_SET_NULL);

$installer->endSetup();

