<?php

class ISM_NewstoreMember_Block_Newstoremember extends Mage_Core_Block_Template
{
    private $newstoremembersGroupId;
    private $customer;

    public function __construct()
    {
        parent::__construct();
        $this->customer = Mage::getSingleton('customer/session')->getCustomer();
        $this->newstoremembersGroupId = Mage::helper('newstoremember')->getNewstoreMembersGroupId();
    }

    public function checkUserNewstoreMember()
    {
        if ($this->customer->getGroupId() === $this->newstoremembersGroupId) {
            return true;
        }
        return false;
    }

    public function checkLoginUser()
    {
        return Mage::getSingleton('customer/session')->isLoggedIn();
    }
}