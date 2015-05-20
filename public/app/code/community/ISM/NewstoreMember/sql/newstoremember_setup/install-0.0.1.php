<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
$installer = $this;
$tableNumbers = $installer->getTable('newstoremember/newstoremember');
$installer->startSetup();

$installer->getConnection()->dropTable($tableNumbers);
$table = $installer->getConnection()
    ->newTable($tableNumbers)
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ))
    ->addColumn('unique_key', Varien_Db_Ddl_Table::TYPE_VARCHAR, '255', array(
        'nullable' => false
    ))
    ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable' => true,
        'default' => null
    ))
    ->addColumn('expire_date', Varien_Db_Ddl_Table::TYPE_DATE, null, array(
        'nullable' => true,
    ))
    ->addColumn('post_code', Varien_Db_Ddl_Table::TYPE_VARCHAR, '255', array(
        'nullable' => false,
        'default' => ''
    ))
    ->addForeignKey(
        $installer->getFkName('newstoremember/newstoremember', 'customer_id', 'customer/entity', 'entity_id'),
        'customer_id',
        $installer->getTable('customer/entity'),
        'entity_id',
        Varien_Db_Ddl_Table::ACTION_SET_NULL,
        Varien_Db_Ddl_Table::ACTION_SET_NULL)
    ->addIndex(
        $installer->getIdxName('newstoremember/newstoremember', array('unique_key'), Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE),
        array('unique_key'), array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE));

$installer->getConnection()->createTable($table);

$installer->getConnection()
    ->addColumn(
        "sales_flat_order", "newstoremembers_number", array(
            'nullable' => true,
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'length' => 256,
            'comment' => 'Newstoremembers Number'
        )
    );
$installer->getConnection()
    ->addColumn(
        "sales_flat_quote", "newstoremembers_number", array(
            'nullable' => true,
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'length' => 256,
            'comment' => 'Newstoremembers Number'
        )
    );
$eav = new Mage_Eav_Model_Entity_Setup('core_setup');

$eav->addAttribute('customer', 'prev_group_id', array(
    'type' => 'int'
));
$installer->endSetup();
