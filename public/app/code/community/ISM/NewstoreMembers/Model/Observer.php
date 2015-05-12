<?php

class ISM_NewstoreMembers_Model_Observer {

    public function checkoutTypeOnepageSaveOrderAfter(Varien_Event_Observer $observer) {
        $order = $observer->getOrder();
        $quote=$observer->getQuote();
        $collection=Mage::getModel('newstoremembers/numbers')->getCollection()
            ->getItemByColumnValue('customer_id',$order->getCustomer()->getEntityId());
        if(isset($collection[0])){
            $order->setNewstoremembersNumber($collection[0]['unique_key'])->save();
            $quote->setNewstoremembersNumber($collection[0]['unique_key'])->save();
        }

    }
}
