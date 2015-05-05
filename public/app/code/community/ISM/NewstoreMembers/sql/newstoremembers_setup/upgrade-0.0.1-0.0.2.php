<?php

$installer = $this;
$installer->startSetup();

/**
 * Drop foreign keys
 */
$connection = $installer->getConnection()->dropForeignKey(
    $installer->getTable('newstoremembers/table_newstoremembers'),
    $installer->getFkName('newstoremembers/table_newstoremembers', 'id', 'customer/entity', 'entity_id')
);

$installer->endSetup();