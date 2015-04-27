<?php

class ISM_News_Block_News extends Mage_Core_Block_Template
{
    public function getNewsCollection()
    {
        /** @var ISM_News_Model_Resource_News_Collection $newsCollection */
//        AND publish_date >= "' . date("Y/m/d") . '"'
        $newsCollection = Mage::getModel('news/news')->getCollection();
        $newsCollection->myFilter();
        return $newsCollection;
    }
    public function getNewById(){
        return Mage::getSingleton('news/news')->load(Mage::app()->getRequest()->getParam('id', 0));
    }
}