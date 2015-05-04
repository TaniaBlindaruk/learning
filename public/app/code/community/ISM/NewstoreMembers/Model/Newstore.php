<?php

class ISM_NewstoreMembers_Model_Newstore extends Mage_Core_Model_Abstract
{

    public function _construct()
    {
        parent::_construct();
        $this->_init('newstoremembers/newstore');
    }

}