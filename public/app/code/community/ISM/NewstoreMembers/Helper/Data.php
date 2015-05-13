<?php

class ISM_NewstoreMembers_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getUsers()
    {
        /** @var Mage_Customer_Model_Resource_Customer_Collection $customers */
        $customers = Mage::getModel('customer/customer')->getCollection()->addNameToSelect();
//        $customers->toOptionArray();
        $result[] = array(
            'value' => null,
            'label' => '-------------------'
        );
        foreach ($customers as $customer) {
            $push = array(
                'value' => $customer->getId(),
                'label' => $customer->getName()
            );
            $result[] = $push;
        }
        return $result;
    }

    public function setUserGroup($idCustomer)
    {
        Mage::getModel('customer/customer')->load($idCustomer, 'entity_id')
            ->setPrevGroupId(12)
            ->setGroupId(Mage::getStoreConfig('newstoremembers/newstoremembers_group/newstoremembers_field_group'))
            ->save();
    }

    private function checkNewstoreMembersGroupUser($idCustomer)
    {
        if (Mage::getModel('customer/customer')
                ->load($idCustomer, 'entity_id')
                ->getGroupId() === Mage::getStoreConfig('newstoremembers/newstoremembers_group/newstoremembers_field_group')
        ) {
            return false;
        }
        return true;
    }

    public function setMemberAndGroup($number)
    {
        /**@var $collection ISM_NewstoreMembers_Model_Resource_Numbers_Collection */
        $collection = Mage::getModel('newstoremembers/numbers')->getCollection();
        $var = $collection->getItemsByColumnValue('unique_key', $number);

        $customerId = Mage::getModel('customer/session')->getCustomer()->getEntityId();
        if (isset($var[0]) && $this->checkNewstoreMembersGroupUser($customerId) && !$var[0]['customer_id']) {
            $this->setUserGroup($customerId);
            $var[0]['customer_id'] = $customerId;
            Mage::getModel('newstoremembers/numbers')->setData($var[0]->toArray())->save();
        }
    }

}