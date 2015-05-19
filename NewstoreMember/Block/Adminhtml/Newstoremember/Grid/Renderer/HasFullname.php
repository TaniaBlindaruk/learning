<?php

class ISM_NewstoreMember_Block_Adminhtml_Newstoremember_Grid_Renderer_HasFullname extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        return $row->getFirstname() .' '. $row->getLastname();
//        $value = trim((string)$row->getData($this->getColumn()->getIndex()));
//        if (empty($value)) {
//            return 'No';
//        } else {
//            return 'Yes';
//        }
    }



}