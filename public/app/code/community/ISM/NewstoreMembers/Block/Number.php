<?php

class ISM_NewstoreMembers_Block_Number extends Mage_Core_Block_Template
{

    public function getCustomer(){
        return Mage::getSingleton('customer/session')->getCustomer();
    }

    public function getNewstoreMembersGroupId(){
        return Mage::getStoreConfig('newstoremembers/newstoremembers_group/newstoremembers_field_group');
    }

    public function checkUserNewstoreMember(){
        if($this->getCustomer()->getGroupId()===$this->getNewstoreMembersGroupId()){
            return true;
        }
        return false;
    }
}