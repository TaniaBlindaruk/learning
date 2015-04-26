<?php

class ISM_News_IndexController extends Mage_Core_Controller_Front_Action
{

    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function viewAction()
    {
        $newsId = Mage::app()->getRequest()->getParam('id', 0);
        $news = Mage::getModel('news/news')->load($newsId);
        if(!$news->getId()||$news->getPublish()==='0'){
            $this->_forward('no-route');
        }else{
            Mage::register('news',$news);
            $this->loadLayout();
            $this->renderLayout();
        }
    }
}