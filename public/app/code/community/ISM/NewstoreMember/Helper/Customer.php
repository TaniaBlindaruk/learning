<?php


class ISM_NewstoreMember_Helper_Customer extends Mage_Core_Helper_Abstract
{
    public function setCustomerGroup($idCustomer ,$idGroup)
    {
        $customer = Mage::getModel('customer/customer')
            ->load($idCustomer, 'entity_id');
        $prevGroupId = $customer->getGroupId();
        if ($prevGroupId !== Mage::helper('newstoremember')->getNewstoreMembersGroupId()) {
            $customer->setPrevGroupId($prevGroupId);
        }
        $customer->setGroupId($idGroup)->save();
    }

    public function toPrevCustomerGroup($idCustomer){
        /**@var $customer ISM_NewstoreMember_Model_Resource_Newstoremember_Collection*/
        $collection = Mage::getModel('customer/customer')->getCollection()->addAttributeToSelect('prev_group_id');
        $customer=$collection->getItemByColumnValue('entity_id',$idCustomer);
//            ->load($idCustomer, 'entity_id');
        $customer->setGroupId($customer->getPrevGroupId())
            ->save();
    }
}