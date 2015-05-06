<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
$installer = $this;
$tableNews = $installer->getTable('newstoremembers/table_newstoremembers');
$installer->startSetup();

$installer->getConnection()->dropTable($tableNews);
$table = $installer->getConnection()
    ->newTable($tableNews)
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
    ))
    ->addColumn('unique_key', Varien_Db_Ddl_Table::TYPE_VARCHAR, '255', array(
        'nullable'  => false,
        'unique'=>true
    ))
    ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => true,
    ))
    ->addColumn('expire_date', Varien_Db_Ddl_Table::TYPE_DATE, null, array(
        'nullable'  => true,
    ))
    ->addForeignKey(
        $installer->getFkName('newstoremembers/table_newstoremembers', 'customer_id', 'customer/entity', 'entity_id'),
        'customer_id',
        $installer->getTable('customer/entity'),
        'entity_id',
        Varien_Db_Ddl_Table::ACTION_SET_NULL,
        Varien_Db_Ddl_Table::ACTION_SET_NULL);

$installer->getConnection()->createTable($table);

$installer->endSetup();
