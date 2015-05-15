<?php

class ISM_NewstoreMembers_Block_Adminhtml_Number_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    protected function _construct()
    {
        $this->_blockGroup = 'newstoremembers';
        $this->_controller = 'adminhtml_Number';
    }

    public function getHeaderText()
    {
        $helper = Mage::helper('newstoremembers');
        $model = Mage::getSingleton('newstoremembers/number');

        if ($model->getId()) {
            return $helper->__("Edit Key '%s'", $this->escapeHtml($model->getTitle()));
        } else {
            return $helper->__("Add Key");
        }
    }

}