<?php

class ISM_News_Model_Resource_News extends Mage_Core_Model_Mysql4_Abstract
{

    public function _construct()
    {
        $this->_init('news/entity', 'news_id');
    }

}