<?php

/**
 * Created by PhpStorm.
 * User: tania
 * Date: 04.05.15
 * Time: 15:20
 */
class ISM_NewstoreMember_Adminhtml_NewstorememberController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('newstoremember');

        $contentBlock = $this->getLayout()->createBlock('newstoremember/adminhtml_newstoremember');
        $this->_addContent($contentBlock);
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $id = (int)$this->getRequest()->getParam('id');
        Mage::getSingleton('newstoremember/newstoremember')->load($id);
        $this->loadLayout()->_setActiveMenu('newstoremember');
        $this->_addContent($this->getLayout()->createBlock('newstoremember/adminhtml_newstoremember_edit'));
        $this->renderLayout();
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            try {
                if(!$data['customer_id']){
                    $data['customer_id']=null;
                }
                $model = Mage::getModel('newstoremember/newstoremember');
                $model->load($data['id']);
                $model->setData($data)->save();
                /**@var $customerModel ISM_NewstoreMember_Model_Customer */
                $customerModel = Mage::getModel('newstoremember/customer');
                $customer = $data['customer_id'];
                if ($customer) {
                    $customerModel->setCustomerGroup($customer, Mage::helper('newstoremember')->getNewstoreMembersGroupId());
                }
                $prevCustomer = $model->getOrigData('customer_id');
                if ($prevCustomer && $prevCustomer !== $customer) {
                    $customerModel->toPrevCustomerGroup($prevCustomer);
                }
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('saved successfully'));
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
                $modelCustomer = Mage::getModel('newstoremember/customer');
                $model = Mage::getModel('newstoremember/newstoremember');
                $data = $model->load($id);
                $model->delete();
                $customerId = $data['customer_id'];
                if ($customerId) {
                    $modelCustomer->toPrevCustomerGroup($customerId);
                }
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('deleted successfully'));
                $this->_redirect('*/*/index');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $id));
            }
        }
    }
}