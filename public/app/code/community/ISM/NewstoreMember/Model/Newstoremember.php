<?php

class ISM_NewstoreMember_Model_Newstoremember extends Mage_Core_Model_Abstract
{

    public function _construct()
    {
        parent::_construct();
        $this->_init('newstoremember/newstoremember');
    }

    public function save()
    {
        $customerId = $this->getCustomerId();
        $origCustomerId = $this->getOrigData('customer_id');
        if ($customerId === '') {
            $this->setCustomerId(null);
        }
        if($customerId!==$origCustomerId){
            $modelCustomer = Mage::getModel('customer/customer');
            if($customerId) {
                $modelCustomer->load($customerId);
                $modelCustomer->setPrevGroupId($modelCustomer->getGroupId());
                $modelCustomer->setGroupId(Mage::helper('newstoremember')->getNewstoreMembersGroupId());
                $modelCustomer->save();
            }
            if($origCustomerId) {
                $modelCustomer->load($origCustomerId);
                $modelCustomer->setGroupId($modelCustomer->getPrevGroupId());
                $modelCustomer->save();
            }
        }
        if ($this->getId() === '') {
            $this->setId(null);
        }
        return parent::save();
    }
}