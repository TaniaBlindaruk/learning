<?php

class ISM_NewstoreMembers_Model_Observer {

    public function checkoutTypeOnepageSaveOrderAfter(Varien_Event_Observer $observer) {
        /**@var $helper ISM_NewstoreMembers_Helper_Data*/
        $order = $observer->getOrder();
        $customer = $order->getCustomer();
        $collection=Mage::getModel('newstoremembers/numbers')->getCollection()
            ->getItemByColumnValue('customer_id',$customer->getEntityId());
        $helper = Mage::helper('newstoremembers');
        if($collection->getGroupId()===$helper->getNewstoreMembersGroupId()&&$collection->hasUniqueKey()){
            $key = $collection->getUniqueKey();
            $observer->getOrder()->setNewstoremembersNumber($key)->save();
            $observer->getQuote()->setNewstoremembersNumber($key)->save();
        }
    }
    public function newstoremembersAdminhtmlCustomerPrepareSave(Varien_Event_Observer $observer){
        /**@var $helper ISM_NewstoreMembers_Helper_Data*/
        $customer = $observer->getCustomer();
        $helper = Mage::helper('newstoremembers');
        if($customer->getGroupId()===$helper->getNewstoreMembersGroupId()){
            $customer->setGroupId($customer->getOrigData('group_id'));
        }
    }
}
