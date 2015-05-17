<?php

class ISM_NewstoreMember_Block_Adminhtml_Newstoremember extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function _construct()
    {
        parent::_construct();

        $helper = Mage::helper('newstoremember');
        $this->_blockGroup = 'newstoremember';
        $this->_controller = 'adminhtml_newstoremember';

        $this->_headerText = $helper->__('Newstore Key');
        $this->_addButtonLabel = $helper->__('Add Key');
    }

}