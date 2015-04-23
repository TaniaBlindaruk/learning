<?php
$installer = $this;
$tableNews = $installer->getTable('news/entity');
$installer->startSetup();
$table = $installer->getConnection()
    ->newTable($tableNews)
    ->addColumn('news_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
    ))
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_VARCHAR, Varien_Db_Ddl_Table::DEFAULT_TEXT_SIZE, array(
        'nullable'  => false,
    ))
    ->addColumn('content', Varien_Db_Ddl_Table::TYPE_VARCHAR, Varien_Db_Ddl_Table::MAX_TEXT_SIZE, array(
        'nullable'  => false,
    ))
    ->addColumn('announce', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
        'nullable'  => true,
    ))
    ->addColumn('publish_date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'nullable'  => false,
    ))
    ->addColumn('publish', Varien_Db_Ddl_Table::TYPE_BOOLEAN, null, array(
        'nullable'  => false,
        'default'   => '1',
    ));
$installer->getConnection()->createTable($table);
$installer->endSetup();