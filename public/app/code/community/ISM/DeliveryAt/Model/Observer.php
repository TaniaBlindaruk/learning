<?php
/**
 * Created by PhpStorm.
 * User: tania
 * Date: 28.04.15
 * Time: 20:41
 */

class ISM_DeliveryAt_Model_Observer {

    public function checkoutControllerOnepageSaveShippingMethod(Varien_Event_Observer $observer) {
        $observer->getQuote()->setDeliverydate($observer->getRequest()->getPost('delivery_date'));
    }
}
