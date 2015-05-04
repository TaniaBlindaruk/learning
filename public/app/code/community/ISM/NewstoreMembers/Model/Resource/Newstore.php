<?php

class ISM_NewstoreMembers_Model_Resource_Newstore extends Mage_Core_Model_Mysql4_Abstract
{

    public function _construct()
    {
        $this->_init('newstoremembers/table_newstoremembers', 'id');
    }

}