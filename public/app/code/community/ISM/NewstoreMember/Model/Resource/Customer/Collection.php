<?php

class ISM_NewstoreMember_Model_Resource_Customer_Collection extends Mage_Customer_Model_Resource_Customer_Collection
{
    public function toOptionArray(){
        return parent::_toOptionArray('entity_id','name');
    }
}