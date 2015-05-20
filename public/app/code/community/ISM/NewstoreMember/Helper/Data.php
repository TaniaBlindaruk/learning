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
        /**@var $singltonSession Mage_Core_Model_Session */
        $singltonSession = Mage::getSingleton('core/session');
        $customer = Mage::getSingleton('customer/session')->getCustomer();
        $billingAddress = $customer->getPrimaryBillingAddress();
        if ($billingAddress) {

            /**@var $model ISM_NewstoreMember_Model_Newstoremember */
            $model = Mage::getSingleton('newstoremember/newstoremember');
            /**@var $collectionNewstoremember ISM_NewstoreMember_Model_Resource_Newstoremember_Collection */
            $collectionNewstoremember = $model->getCollection();
            $newstoremember = $collectionNewstoremember->getItemByColumnValue('unique_key', $number);
            if (empty($newstoremember)) {
                $singltonSession->addError('Your newstoremember number is invalid!');
                return false;
            } else {

                if ($newstorememberCustomerId = $newstoremember -> getCustomerId()) {
                    $singltonSession->addError('This newstoremember number is not free!');
                    return false;
                }

                $newstorememberExpireDate = $newstoremember -> getExpireDate();
                if ($newstorememberExpireDate < now()) {
                    $singltonSession->addError('This newstoremember number is invalid');
                    return false;
                }

                if ($billingAddress->getPostcode() !== $newstoremember->getPostCode()) {
                    $singltonSession->addError('Sorry, but your postcode is invalid.');
                    return false;
                }

                $newstoremember->setCustomerId($customer->getEntityId());
                $model->setData($newstoremember->getData())->save();
                return true;

            }
        } else {
            $singltonSession->addError('Please, create address');
            return false;
        }
    }
}