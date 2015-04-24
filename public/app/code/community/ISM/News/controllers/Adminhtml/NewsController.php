<?php

class ISM_News_Adminhtml_NewsController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('news');
        $contentBlock = $this->getLayout()->createBlock('news/adminhtml_news');
        $this->_addContent($contentBlock);
        $this->renderLayout();
    }

}