<?php

class ISM_NewstoreMembers_Block_Adminhtml_Number_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    protected function _prepareCollection() {
        /**@var $collection ISM_NewstoreMembers_Model_Resource_Numbers_Collection*/
        $collection = Mage::getModel('newstoremembers/number')
            ->getCollection();
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