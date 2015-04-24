<?php

class ISM_News_Block_News extends Mage_Core_Block_Template
{

    public function getNewsCollection()
    {
        $newsCollection = Mage::getModel('news/news')->getCollection();
        return $newsCollection;
    }

}