<?php

class ISM_NewstoreMembers_Block_Adminhtml_Key_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    protected function _construct()
    {
        $this->_blockGroup = 'newstoremembers';
        $this->_controller = 'adminhtml_key';
    }

    public function getHeaderText()
    {
        $helper = Mage::helper('newstoremembers');
        $model = Mage::registry('key_info');

        if ($model->getId()) {
            return $helper->__("Edit Key '%s'", $this->escapeHtml($model->getTitle()));
        } else {
            return $helper->__("Add Key");
        }
    }

}