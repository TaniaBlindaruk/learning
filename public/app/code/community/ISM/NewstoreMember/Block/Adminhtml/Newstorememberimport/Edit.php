<?php

class ISM_NewstoreMember_Block_Adminhtml_Newstorememberimport_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->removeButton('back')
            ->removeButton('reset');
    }

    protected function _construct()
    {
        parent::_construct();
        $this->_blockGroup = 'newstorememberimport';
        $this->_controller = 'adminhtml_newstorememberimport';
    }

    public function getHeaderText()
    {
        return Mage::helper('newstoremember')->__('asdajd ');
    }

}
