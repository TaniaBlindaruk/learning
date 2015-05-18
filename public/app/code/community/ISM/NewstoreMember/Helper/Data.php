<?php


class ISM_NewstoreMember_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getUserListIsNotNewstoreMembers($currentId)
    {
        function compare($key1, $key2)
        {
            return $key1['value'] == $key2['value'] ? 0 : -1;
        }

        /** @var Mage_Customer_Model_Resource_Customer_Collection $customers */
        $customers = Mage::getModel('customer/customer')->getCollection()->addNameToSelect();
        $newstoremembers = Mage::getModel('newstoremember/newstoremember')->getCollection()->toCustomerOptionArray();
        $fullCustomer = array_merge(array(array(
            'value' => null,
            'label' => '-------------------'
        )), $customers->toOptionArray());
        $newstoremembers = array_udiff($newstoremembers,
            array(
                array(
                    'value' => $currentId
                )
            ),
            'compare');
        $result = array_udiff($fullCustomer, $newstoremembers, 'compare');
        return $result;
    }

    public function getNewstoreMembersGroupId()
    {
        return Mage::getStoreConfig('newstoremember/newstoremember_group/newstoremember_field_group');
    }

    public function addCustomerToNewstoreMemberFrontend($number){
        /**@var $model ISM_NewstoreMember_Model_Resource_Newstoremember_Collection*/
        $model=Mage::getModel('newstoremember/newstoremember')->getCollection();
        $modelData=$model->getItemByColumnValue('unique_key',$number);
        if(empty($modelData)){
            Mage::getSingleton('core/session')->addError('Your member number is invalid!');
            return false;
        }else if(!$modelData['customer_id']){
            /**@var $customerModel ISM_NewstoreMember_Model_Customer*/
            $customerModel = Mage::getModel('newstoremember/customer');
            $customerId=Mage::getSingleton('customer/session')->getCustomer()->getEntityId();
            $customerModel->setCustomerGroup($customerId,$this->getNewstoreMembersGroupId());
            $modelData->setCustomerId($customerId)->save();
            return true;
        }
        return false;
    }

    public function getNewQniqueNumber(){
        return Mage::helper('core')->getRandomString(10);
    }
}