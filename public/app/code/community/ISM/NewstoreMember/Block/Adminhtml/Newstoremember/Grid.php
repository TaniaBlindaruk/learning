<?php

class ISM_NewstoreMember_Block_Adminhtml_Newstoremember_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    protected function _prepareCollection()
    {
        /**@var $collection ISM_NewstoreMember_Model_Resource_Newstoremember_Collection */
        $collection = Mage::getModel('newstoremember/newstoremember')
            ->getCollection();
        $firstName = Mage::getModel('eav/entity_attribute')
            ->loadByCode('1', 'firstname');
        $lastName = Mage::getModel('eav/entity_attribute')
            ->loadByCode('1', 'lastname');
        $firstnameAttributeId = $firstName->getAttributeId();
        $latnameAttributeId = $lastName->getAttributeId();
        $collection->getSelect()
            ->columns(new Zend_Db_Expr("CONCAT(`cev1`.`value`, ' ',"
                . "`cev2`.`value`) AS fullname"))
            ->joinLeft(array('ce' => 'customer_entity'),
                'ce.entity_id=main_table.customer_id',
                array('email' => 'email'))
            ->joinLeft(array('cev1' => 'customer_entity_varchar'),
                "cev1.entity_id=main_table.customer_id AND cev1.attribute_id= $firstnameAttributeId",
                array('firstname' => 'value'))
            ->joinLeft(array('cev2' => 'customer_entity_varchar'),
                "cev2.entity_id=main_table.customer_id AND cev2.attribute_id= $latnameAttributeId",
                array('lastname' => 'value'));
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _filterHasFullnameConditionCallback($collection, $column)
    {
//        if (!$value = $column->getFilter()->getValue()) {
//            return $this;
//        }
        $select = $collection->getSelect();
        $field = $column->getIndex();
        $value = $column->getFilter()->getValue();
        $select->having("fullname=?", $value);
//        $this->getCollection()->getSelect()->where("fullname like" , "%$value%");
//        return $this;
    }

    protected function _prepareColumns()
    {

        $helper = Mage::helper('newstoremember');

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
//            'renderer'=>  new ISM_NewstoreMember_Block_Adminhtml_Newstoremember_Grid_Renderer_HasFullname(),
            'filter_condition_callback'=>array($this, '_filterHasFullnameConditionCallback')
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