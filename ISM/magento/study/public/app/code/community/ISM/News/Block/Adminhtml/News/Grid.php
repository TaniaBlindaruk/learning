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
            'index' => 'news_id',
            'width' => '50px'
        ));

        $this->addColumn('title', array(
            'header' => $helper->__('Title'),
            'index' => 'title',
            'type' => 'text',
        ));

        $this->addColumn('publish_date', array(
            'header' => $helper->__('Publish date'),
            'index' => 'publish_date',
            'type' => 'date',
        ));

        $this->addColumn('publish', array(
            'header' => $helper->__('Publish'),
            'index' => 'publish',
            'type' => 'options',
            'options' => array(
                1 => 'Yes',
                0 => 'No',
            ),
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