<?php

class ISM_NewstoreMember_Model_Newstoremember extends Mage_Core_Model_Abstract
{

    private $customer  = null;
    public function _construct()
    {
        parent::_construct();
        $this->_init('newstoremember/newstoremember');
    }

    public function delete()
    {
        $customerId = $this->getCustomerId();
        if ($customerId) {
            /**@var $modelCustomer Mage_Customer_Model_Customer */
            $modelCustomer = Mage::getSingleton('customer/customer');
            $modelCustomer->load($customerId)
                ->setGroupId($modelCustomer->getPrevGroupId())
                ->save();
        }
        return parent::delete();
    }

    public function save()
    {
        $customerId = $this->getCustomerId();
        $origCustomerId = $this->getOrigData('customer_id');
        $newtoreMemberId = $this->getId();
        if ($customerId === '') {
            $this->setCustomerId(null);
            $customerId =null;
        }
        if ($newtoreMemberId === '') {
            $this->setId(null);
        }
        if ($newtoreMemberId) {
            if ($customerId !== $origCustomerId) {
                $modelCustomer = Mage::getSingleton('customer/customer');
                if ($modelCustomer->isEmpty()) {
                    if ($customerId) {
                        $modelCustomer->load($customerId);
                        $modelCustomer->setPrevGroupId($modelCustomer->getGroupId());
                        $modelCustomer->setGroupId(Mage::helper('newstoremember')->getNewstoreMembersGroupId());
                        $modelCustomer->save();
                    }

                    if ($origCustomerId) {
                        $modelCustomer->load($origCustomerId);
                        $modelCustomer->setGroupId($modelCustomer->getPrevGroupId());
                        $modelCustomer->save();
                    }
                }
            }
        }
        return parent::save();
    }

    public function getCustomer(){
        $customerId = $this->getCustomerId();
        if(!$this->customer && $customerId){
            $this->customer = Mage::getModel('customer/customer')->load($this->getCustomerId());
        }
        return $this->customer;
    }

    public function load($id, $field=null){
        $this->customer =null;
        return parent::load($id, $field);
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
                'unique_key' => Mage::helper('newstoremember')->getNewQniqueNumber(),
                'expire_date' => now()
            )
        )->save();
    }
}