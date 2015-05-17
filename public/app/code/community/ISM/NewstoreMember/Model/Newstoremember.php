<?php

class ISM_NewstoreMember_Model_Newstoremember extends Mage_Core_Model_Abstract
{

    public function _construct()
    {
        parent::_construct();
        $this->_init('newstoremember/newstoremember');
    }

    public function save(){
        if($this->getCustomerId()===''){
            $this->setCustomerId(null);
        }
        if($this->getId()===''){
            $this->setId(null);
        }
        return parent::save();
    }

    public function unsetNewstoremembersCustomer($customerId)
    {
        /**@var $model ISM_NewstoreMember_Model_Resource_Newstoremember_Collection */
        $model = $this->getCollection();
        $data = $model->getItemByColumnValue('customer_id', $customerId);
        $data->setCustomerId(null)->save();
    }

    public function addCustomerToNewstoremembers($customerId)
    {
        $this->setData(
            array(
                'customer_id' => $customerId,
                'unique_key' => Mage::helper('core')->getRandomString(10),
                'expire_date' => now()
            )
        )->save();
    }
}