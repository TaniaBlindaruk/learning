<?php

class ISM_NewstoreMember_Block_Adminhtml_Newstoremember_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    protected function _prepareCollection() {
        /**@var $collection ISM_NewstoreMember_Model_Resource_Newstoremember_Collection*/
        $collection = Mage::getModel('newstoremember/newstoremember')
            ->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
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