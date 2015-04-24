<?php

class ISM_News_Block_View extends Mage_Core_Block_Template
{
    public function getNewsById()
    {
        $newsId = Mage::app()->getRequest()->getParam('id', 0);
        $news = Mage::getModel('news/news')->load($newsId);
        return $news;
    }
}