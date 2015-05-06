<?php

class ISM_NewstoreMembers_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getUsers(){
        /** @var Mage_Customer_Model_Resource_Customer_Collection $customers */
        $customers = Mage::getModel('customer/customer')->getCollection()->addNameToSelect();

        $result[]=array(
            'value'=>null,
            'label'=>'-------------------'
        );
        $result  = array_merge($result,$customers->toOptionArray());
        return $result;
    }
}