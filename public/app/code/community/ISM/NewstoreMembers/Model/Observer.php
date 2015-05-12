<?php

class ISM_NewstoreMembers_Model_Observer {

    public function checkoutTypeOnepageSaveOrderAfter(Varien_Event_Observer $observer) {
        $observer->getOrder()->setNewstoremembersNumber(123)->save();
        $observer->getQuote()->setNewstoremembersNumber(123)->save();
    }
}
