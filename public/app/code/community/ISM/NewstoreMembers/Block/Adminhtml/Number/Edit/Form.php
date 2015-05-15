<?php

class ISM_NewstoreMembers_Block_Adminhtml_Number_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $helper = Mage::helper('newstoremembers');
        $model = Mage::getSingleton('newstoremembers/number');
        if(!$model->getUniqueKey()) {
            $model->setUniqueKey(Mage::helper('core')->getRandomString(10));
        }
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array(
                'id' => $this->getRequest()->getParam('id')
            )),
            'method' => 'post',
            'enctype' => 'multipart/form-data'
        ));

        $this->setForm($form);
        $fieldset = $form->addFieldset('newstoremembers_form', array('legend' => $helper->__('Newstore Information')));

        $fieldset->addField('id', 'hidden', array(
            'name' => 'id'
        ));
        $fieldset->addField('unique_key', 'text', array(
            'label' => $helper->__('Unique key'),
            'required' => true,
            'name' => 'unique_key'
        ));

        $fieldset->addField('expire_date', 'date', array(
            'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'label' => $helper->__('Expire date'),
            'name' => 'expire_date',
            'required' => true
        ));
        $fieldset->addField('customer_id', 'select', array(
            'label' => $helper->__('User'),
            'name' => 'customer_id',
            'values' =>$helper->getUsers()
        ));

        $form->setUseContainer(true);

        if($data = Mage::getSingleton('adminhtml/session')->getFormData()){
            $form->setValues($data);
        } else {
            $form->setValues($model->getData());
        }

        return parent::_prepareForm();
    }

}
