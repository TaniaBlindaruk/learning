<?php

class ISM_News_Block_News extends Mage_Core_Block_Template
{

    public function getNewsCollection()
    {
        $newsCollection = Mage::getModel('ismnews/news')->getCollection();
        return $newsCollection;
    }

    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

}