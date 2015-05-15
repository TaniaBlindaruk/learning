<?php
/**
 * Created by PhpStorm.
 * User: tania
 * Date: 04.05.15
 * Time: 15:20
 */
class ISM_NewstoreMembers_Adminhtml_KeyController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('newstoremembers');

        $contentBlock = $this->getLayout()->createBlock('newstoremembers/adminhtml_key');
        $this->_addContent($contentBlock);
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        Mage::getSingleton('newstoremembers/numbers')->load($id);
        $this->loadLayout()->_setActiveMenu('newstoremembers');
        $this->_addContent($this->getLayout()->createBlock('newstoremembers/adminhtml_key_edit'));
        $this->renderLayout();
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            try {
//                $newstoremembersNumber = Mage::getModel('newstoremembers/numbers')->setData($data);
//                Mage::dispatchEvent('adminhtml_newstorenumbers_prepare_save', array(
//                    'customer'  => $newstoremembersNumber,
//                    'request'   => $this->getRequest()
//                ));
//                $newstoremembersNumber->save();
//                if($newstoremembersNumber->getCustomerId()!==$newstoremembersNumber->getOrigData('customer_id')){
//
//                }

                $helper =  Mage::helper('newstoremembers');
                Mage::getModel('newstoremembers/numbers')->setData($data)->save();
                if($data['customer_id']){
                    $helper
                        ->setUserGroup($data['customer_id'],$helper->getNewstoreMembersGroupId());
                }

                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('News was saved successfully'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array(
                    'id' => $this->getRequest()->getParam('id')
                ));
            }
            return;
        }
        Mage::getSingleton('adminhtml/session')->addError($this->__('Unable to find item to save'));
    }

    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                Mage::getModel('newstoremembers/numbers')->setId($id)->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('News was deleted successfully'));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $id));
            }
        }
    }
}