<?php
/**
 * Created by PhpStorm.
 * User: tania
 * Date: 04.05.15
 * Time: 15:20
 */
class ISM_NewstoreMembers_Adminhtml_NewstoreController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('newstoremembers');

        $contentBlock = $this->getLayout()->createBlock('newstoremembers/adminhtml_newstore');
        $this->_addContent($contentBlock);
        $this->renderLayout();
    }

}