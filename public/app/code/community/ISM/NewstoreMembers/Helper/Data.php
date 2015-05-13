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

    public function getNewstoreMembersGroupId()
    {
        return Mage::getStoreConfig('newstoremembers/newstoremembers_group/newstoremembers_field_group');
    }

    public function setUserGroup($idCustomer)
    {
        $customer = Mage::getModel('customer/customer')
            ->load($idCustomer, 'entity_id');
        $prevGroupId = $customer->getGroupId();
        if ($prevGroupId !== $this->getNewstoreMembersGroupId()) {
            $customer->setPrevGroupId($prevGroupId);
        }
        $customer->setGroupId($this->getNewstoreMembersGroupId())->save();
    }

    private function checkNewstoreMembersGroupUser($idGroup)
    {
        if ($idGroup === $this->getNewstoreMembersGroupId()
        ) {
            return false;
        }
        return true;
    }

    public function setMemberAndGroup($number)
    {
        /**@var $collection ISM_NewstoreMembers_Model_Resource_Numbers_Collection */
        $collection = Mage::getModel('newstoremembers/numbers')->getCollection();
        $newstoreRow = $collection->getItemByColumnValue('unique_key', $number);
        $newstoreRow = $newstoreRow->toArray();
        /**@var $customer Mage_Customer_Model_Customer */
        $customer = Mage::getModel('customer/session')->getCustomer();
        $customerId = $customer->getEntityId();
        if ($this->checkNewstoreMembersGroupUser($customer->getGroupId()) && !$newstoreRow['customer_id']) {
            $this->setUserGroup($customerId);
            $newstoreRow['customer_id'] = $customerId;
            Mage::getModel('newstoremembers/numbers')->setData($newstoreRow)->save();
        }
    }

}