<?php

class ISM_NewstoreMember_Model_Resource_Newstoremember extends Mage_Core_Model_Resource_Db_Abstract
{

    public function _construct()
    {
        $this->_init('newstoremember/newstoremember', 'id');
    }


}