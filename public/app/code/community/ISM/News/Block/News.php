<?php

class ISM_News_Block_News extends Mage_Core_Block_Template
{
    public function getNewsCollection()
    {
        /** @var ISM_News_Model_Resource_News_Collection $newsCollection */
        $newsCollection = Mage::getModel('news/news')->getCollection()->setOrder('publish_date', 'DESC')
        ->addFilter('publish = 1 AND publish_date >= "' . date("Y/m/d") . '"');
        return $newsCollection;
    }
    public function getNewById()
    {
        return Mage::getSingleton('news/news');
    }
}