<?php

class ISM_NewstoreMembers_Model_Number extends Mage_Core_Model_Abstract
{

    public function _construct()
    {
        parent::_construct();
        $this->_init('newstoremembers/number');
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