<?php

class ISM_NewstoreMembers_Model_Observer {

    public function checkoutTypeOnepageSaveOrderAfter(Varien_Event_Observer $observer) {
        $order = $observer->getOrder();
        $collection=Mage::getModel('newstoremembers/numbers')->getCollection()
            ->getItemsByColumnValue('customer_id',$order->getCustomer()->getEntityId());
        if(isset($collection[0])){
            $key = $collection[0]->getUniqueKey();
            $observer->getOrder()->setNewstoremembersNumber($key)->save();
            $observer->getQuote()->setNewstoremembersNumber($key)->save();
        }
    }
}
