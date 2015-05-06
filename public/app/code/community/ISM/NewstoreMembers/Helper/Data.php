<?php

class ISM_NewstoreMembers_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getUsers(){
        /** @var Mage_Customer_Model_Resource_Customer_Collection $customers */
        $customers = Mage::getModel('customer/customer')->getCollection()->addNameToSelect();

        $customers->toOptionArray();

        $result[]=array(
            'value'=>null,
            'label'=>'-------------------'
        );
        foreach($customers as $customer){
            $push = array(
                'value'=>$customer->getId(),
                'label'=>$customer->getName()
            );
            $result[]=$push;
        }
        return $result;
    }
}