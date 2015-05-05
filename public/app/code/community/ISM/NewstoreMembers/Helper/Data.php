<?php

class ISM_NewstoreMembers_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getMembersValue() {
        //Getting list of customers with their id
        $collection = Mage::getModel('customer/customer')
            ->getCollection()->addAttributeToSelect('*');
        $valuesArray[] = array(
            'value'=>null,
            'label'=>'-------------------'
        );
        foreach ($collection as $customer) {
            $customerArray = $customer->toArray();
            $member = $customerArray['firstname'] . " "
                . $customerArray['lastname'];
            $array = array(
                'value'=>$customerArray['entity_id'],
                'label'=>$member
            );
            $valuesArray[] = $array;
        }

        return $valuesArray;
    }
}