<?php

class ISM_News_Block_News extends Mage_Core_Block_Template
{

    public function getNewsCollection()
    {
        /** @var ISM_News_Model_Resource_News_Collection $newsCollection */
        $newsCollection = Mage::getModel('news/news')->getCollection();
        $newsCollection->myFilter();
        return $newsCollection;
    }

}