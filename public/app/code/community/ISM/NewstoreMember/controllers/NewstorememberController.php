<?php

/**
 * Created by PhpStorm.
 * User: tania
 * Date: 04.05.15
 * Time: 15:20
 */
class ISM_NewstoreMember_NewstorememberController extends Mage_Core_Controller_Front_Action
{

    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function saveAction()
    {
        $this->_redirect('*/*/index');
        $data = $this->getRequest()->getPost();
        $number = $data['number'];
        if ($number) {
            /**@var $helper ISM_NewstoreMember_Helper_Data */
            $helper = Mage::helper('newstoremember');
            $helper->addCustomerToNewstoreMemberFrontend($number);
        }
    }
}