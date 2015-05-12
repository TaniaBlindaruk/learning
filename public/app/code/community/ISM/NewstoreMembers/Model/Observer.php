<?php

class ISM_NewstoreMembers_Model_Observer {

    public function checkoutTypeOnepageSaveOrderAfter(Varien_Event_Observer $observer) {
        $observer->getQuote()->setNewtoremembersNumber(123);
        $observer->getOrder()->setNewtoremembersNumber(123);
    }
}
