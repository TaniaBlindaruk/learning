<?php

class ISM_NewstoreMember_Model_Resource_Newstoremember_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    public function _construct()
    {
        parent::_construct();
        $this->_init('newstoremember/newstoremember');
    }

    public function toCustomerOptionArray(){
        $firstName = Mage::getModel('eav/entity_attribute')
            ->loadByCode('1', 'firstname');
        $lastName = Mage::getModel('eav/entity_attribute')
            ->loadByCode('1', 'lastname');
        $this->getSelect()
            ->columns(new Zend_Db_Expr("CONCAT(`cev1`.`value`, ' ',"
                . "`cev2`.`value`) AS fullname"))
            ->joinLeft(array('ce' => 'customer_entity'),
                'ce.entity_id=main_table.customer_id',
                array('email' => 'email'))
            ->joinRight(array('cev1' => 'customer_entity_varchar'),
                'cev1.entity_id=main_table.customer_id',
                array('firstname' => 'value'))
            ->joinRight(array('cev2' => 'customer_entity_varchar'),
                'cev2.entity_id=main_table.customer_id',
                array('lastname' => 'value'))
            ->where('cev1.attribute_id=' . $firstName->getAttributeId())
            ->where('cev2.attribute_id=' .$lastName->getAttributeId());
        return parent::_toOptionArray('customer_id','fullname');
    }

}