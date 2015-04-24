<?php

class ISM_News_IndexController extends Mage_Core_Controller_Front_Action
{

    public function indexAction()
    {
        $resource = Mage::getSingleton('core/resource');
        $read = $resource->getConnection('core_read');
        $table = $resource->getTableName('news/entity');

        $select = $read->select()
            ->from($table, array('news_id', 'title', 'content'));

        $news = $read->fetchAll($select);
        Mage::register('news', $news);

        $this->loadLayout();
        $this->renderLayout();
    }

}