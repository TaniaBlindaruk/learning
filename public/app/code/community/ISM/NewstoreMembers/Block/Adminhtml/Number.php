<?php

class ISM_NewstoreMembers_Block_Adminhtml_Number extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function _construct()
    {
        parent::_construct();

        $helper = Mage::helper('newstoremembers');
        $this->_blockGroup = 'newstoremembers';
        $this->_controller = 'adminhtml_number';

        $this->_headerText = $helper->__('Newstore Key');
        $this->_addButtonLabel = $helper->__('Add Key');
    }

}