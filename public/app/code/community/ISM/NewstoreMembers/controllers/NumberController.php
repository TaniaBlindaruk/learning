<?php

/**
 * Created by PhpStorm.
 * User: tania
 * Date: 04.05.15
 * Time: 15:20
 */
class ISM_NewstoreMembers_NumberController extends Mage_Core_Controller_Front_Action
{

    public function indexAction()
    {
        $data = $this->getRequest()->getPost();
        /**@var $helper ISM_NewstoreMembers_Helper_Data*/
        $helper = Mage::helper('newstoremembers');
        $helper->setMemberAndGroup($data['number']);
        $this->loadLayout();
        $this->renderLayout();
    }

}