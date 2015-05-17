<?php


class ISM_NewstoreMember_Helper_Data extends ISM_NewstoreMember_Helper_Customer
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

    public function isUnique($model, $field, $value)
    {
        //Check value for uniqueness
        $model->load($value, $field);
        if (empty($model->getData())) {
            return true;
        }
        return false;
    }
}