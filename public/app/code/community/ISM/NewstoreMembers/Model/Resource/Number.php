<?php

class ISM_NewstoreMembers_Model_Resource_Number extends Mage_Core_Model_Resource_Db_Abstract
{

    public function _construct()
    {
        $this->_init('newstoremembers/newstoremembers', 'id');
    }


}