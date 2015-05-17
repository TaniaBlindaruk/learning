<?php

class ISM_NewstoreMember_Model_Customer extends Mage_Customer_Model_Customer
{
    public function setCustomerGroup($idCustomer ,$idGroup)
    {
        $customer = $this
            ->load($idCustomer, 'entity_id');
        $prevGroupId = $customer->getGroupId();
        if ($prevGroupId !== Mage::helper('newstoremember')->getNewstoreMembersGroupId()) {
            $customer->setPrevGroupId($prevGroupId);
        }
        $customer->setGroupId($idGroup)->save();
    }

    public function toPrevCustomerGroup($idCustomer){
        /**@var $customer ISM_NewstoreMember_Model_Resource_Newstoremember_Collection*/
        $collection = $this->getCollection()->addAttributeToSelect('prev_group_id');
        $customer=$collection->getItemByColumnValue('entity_id',$idCustomer);
        $customer->setGroupId($customer->getPrevGroupId())
            ->save();
    }
}