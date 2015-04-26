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

        $this->loadLayout();
        $this->renderLayout();
        $this->_forward('no-route');
    }
}