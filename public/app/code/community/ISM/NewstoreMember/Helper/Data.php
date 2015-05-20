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

    public function getNewQniqueNumber()
    {
        return Mage::helper('core')->getRandomString(10);
    }

    public function addCustomerToNewstoreMemberFrontend($number)
    {
        /**@var $model ISM_NewstoreMember_Model_Resource_Newstoremember_Collection */
        $model = Mage::getModel('newstoremember/newstoremember')->getCollection();
        $modelData = $model->getItemByColumnValue('unique_key', $number);

        /**@var $singltonSession Mage_Core_Model_Session */
        $singltonSession = Mage::getSingleton('core/session');
        $customerId = $singltonSession->getVisitorData()['customer_id'];

        if (empty($modelData)) {
            $singltonSession->addError('Your newstoremember number is invalid!');
            return false;
        } else if (!$modelData['customer_id'] && $modelData['expire_date'] > now()) {

            $modelAddress = Mage::getModel('customer/address')->load($customerId);
            $customerPostcode = $modelAddress->getPostcode();
            if ($customerPostcode && $customerPostcode === $modelData->getPostCode()) {
                /**@var $customerModel ISM_NewstoreMember_Model_Customer */
                $modelData->setCustomerId($customerId)->save();
                return true;
            } else {
                $singltonSession->addError('Sorry, but your postcode is invalid.');
                return false;
            }
        }
        $singltonSession->addError('Your newstoremember number is\'t $customerIdfree or invalid expire date!');
        return false;
    }
}