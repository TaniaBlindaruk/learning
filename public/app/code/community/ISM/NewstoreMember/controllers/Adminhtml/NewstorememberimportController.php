<?php

/**
 * Created by PhpStorm.
 * User: tania
 * Date: 04.05.15
 * Time: 15:20
 */
class ISM_NewstoreMember_Adminhtml_NewstorememberimportController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('newstoremember');
        $contentBlock = $this->getLayout()->createBlock('newstoremember/adminhtml_newstorememberimport_edit');
        $this->_addContent($contentBlock);
        $this->renderLayout();
    }

    public function validateAction(){


        try {

            Mage::helper('newstoremember')->import();
            Mage::getSingleton('core/session')->addError('asdasd');
        }
        catch(Exception $e){
            Mage::getSingleton('core/session')->addError($e->getMessage());
        }
        $this->loadLayout();
        $this->_setActiveMenu('newstoremember');
        $contentBlock = $this->getLayout()->createBlock('newstoremember/adminhtml_newstorememberimport_edit');
        $this->_addContent($contentBlock);
        $this->renderLayout();
    }
}