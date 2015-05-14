<?php

class ISM_NewstoreMembers_Block_Adminhtml_Key_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    protected function _prepareCollection() {
        /**@var $collection ISM_NewstoreMembers_Model_Resource_Numbers_Collection*/
        $collection = Mage::getModel('newstoremembers/numbers')
            ->getCollection();
        $firstName = Mage::getModel('eav/entity_attribute')
            ->loadByCode('1', 'firstname');
        $lastName = Mage::getModel('eav/entity_attribute')
            ->loadByCode('1', 'lastname');
        $collection->getSelect()
            ->columns(new Zend_Db_Expr("CONCAT(`cev1`.`value`, ' ',"
                . "`cev2`.`value`) AS fullname"))
            ->joinLeft(array('ce' => 'customer_entity'),
                'ce.entity_id=main_table.customer_id',
                array('email' => 'email'))
            ->joinLeft(array('cev1' => 'customer_entity_varchar'),
                'cev1.entity_id=main_table.customer_id',
                array('firstname' => 'value'))
            ->joinLeft(array('cev2' => 'customer_entity_varchar'),
                'cev2.entity_id=main_table.customer_id',
                array('lastname' => 'value'))

            ->where('cev1.attribute_id=' . $firstName->getAttributeId())
            ->where('cev2.attribute_id=' . $lastName->getAttributeId());
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $helper = Mage::helper('newstoremembers');

        $this->addColumn('Id', array(
            'header' => $helper->__('News ID'),
            'index' => 'id'
        ));
        $this->addColumn('unique_key', array(
            'header' => $helper->__('Unique Key'),
            'index' => 'unique_key',
            'type' => 'text',
        ));
        $this->addColumn('customer_id', array(
            'header' => $helper->__('Customer Id'),
            'index' => 'customer_id',
            'type' => 'text',
        ));

        $this->addColumn('fullname', array(
            'header' => $helper->__('Customer Fullname'),
            'index' => 'fullname',
            'type' => 'text',
        ));

        $this->addColumn('email', array(
            'header' => $helper->__('email'),
            'align' => 'left',
            'index' => 'email',
        ));

        $this->addColumn('expire_date', array(
            'header' => $helper->__('Expire date'),
            'index' => 'expire_date',
            'type' => 'date',
        ));
        return parent::_prepareColumns();
    }
    public function getRowUrl($model)
    {
        return $this->getUrl('*/*/edit', array(
            'id' => $model->getId(),
        ));
    }

}