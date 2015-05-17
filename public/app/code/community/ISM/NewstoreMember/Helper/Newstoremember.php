<?php


class ISM_NewstoreMember_Helper_Newstoremember extends Mage_Core_Helper_Abstract
{
    public function unsetNewstoremembersCustomer($customerId)
    {
        /**@var $model ISM_NewstoreMember_Model_Resource_Newstoremember_Collection */
        $model = Mage::getModel('newstoremember/newstoremember')->getCollection();
        $data = $model->getItemByColumnValue('customer_id', $customerId);
        $data->setCustomerId(null)->save();
    }

    public function addCustomerToNewstoremembers($customerId)
    {
        /**@var $model ISM_NewstoreMember_Model_Resource_Newstoremember_Collection */
        Mage::getModel('newstoremember/newstoremember')->setData(
            array(
                'customer_id' => $customerId,
                'unique_key' => Mage::helper('core')->getRandomString(10),
                'expire_date' => now()
            )
        )->save();
    }
}