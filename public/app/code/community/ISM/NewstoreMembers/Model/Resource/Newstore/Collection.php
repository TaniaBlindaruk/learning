<?php

class ISM_NewstoreMembers_Model_Resource_Newstore_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{

    public function _construct()
    {
        parent::_construct();
        $this->_init('newstoremembers/newstore');
    }
    public function loadUser()
    {
        $acl = Mage::getModel('customer/acl');
        $adapter = $this->_getReadAdapter();

        Mage::getSingleton('api/config')->loadAclResources($acl);

        $rolesArr = $adapter->fetchAll(
            $adapter->select()
                ->from($this->getTable('api/role'))
                ->order(array('tree_level', 'role_type'))
        );
        $this->loadRoles($acl, $rolesArr);

        $rulesArr =  $adapter->fetchAll(
            $adapter->select()
                ->from(array('r'=>$this->getTable('api/rule')))
                ->joinLeft(
                    array('a'=>$this->getTable('api/assert')),
                    'a.assert_id=r.assert_id',
                    array('assert_type', 'assert_data')
                ));
        $this->loadRules($acl, $rulesArr);
        return $acl;
    }

}