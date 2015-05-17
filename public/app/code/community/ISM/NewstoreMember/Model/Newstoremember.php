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
}