<?php

class ISM_NewstoreMember_Block_Adminhtml_Newstoremember_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    protected function _construct()
    {
        $this->_blockGroup = 'newstoremember';
        $this->_controller = 'adminhtml_newstoremember';
    }

    public function getHeaderText()
    {
        $helper = Mage::helper('newstoremember');
        $model = Mage::getSingleton('newstoremember/newstoremember');

        if ($model->getId()) {
            return $helper->__("Edit Key '%s'", $this->escapeHtml($model->getTitle()));
        } else {
            return $helper->__("Add Key");
        }
    }

}
