<?php

class ISM_News_Block_Adminhtml_News_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('news/news')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $helper = Mage::helper('news');

        $this->addColumn('news_id', array(
            'header' => $helper->__('News ID'),
            'index' => 'news_id'
        ));

        $this->addColumn('title', array(
            'header' => $helper->__('Title'),
            'index' => 'title',
            'type' => 'text',
        ));

//        $this->addColumn('created', array(
//            'header' => $helper->__('Created'),
//            'index' => 'created',
//            'type' => 'date',
//        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($model)
    {
        return $this->getUrl('*/*/edit', array(
            'id' => $model->getId(),
        ));
    }
}