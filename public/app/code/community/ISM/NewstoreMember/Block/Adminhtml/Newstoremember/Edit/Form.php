<?php

class ISM_NewstoreMember_Block_Adminhtml_Newstoremember_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        /**@var $helper ISM_NewstoreMember_Helper_Data */
        $helper = Mage::helper('newstoremember');
        $model = Mage::getSingleton('newstoremember/newstoremember');
        if (!$model->getUniqueKey()) {
            $model->setUniqueKey($helper->getNewQniqueNumber());
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

        $data = Mage::getSingleton('adminhtml/session')->getFormData();
        if ($data) {
            $customerId = $data['customer_id'];
        } else {
            $customerId = $model['customer_id'];
        }
        $fieldset->addField('customer_id', 'select', array(
            'label' => $helper->__('User'),
            'name' => 'customer_id',
            'values' => $helper->getUserListIsNotNewstoreMembers($customerId)
        ));
        $form->setUseContainer(true);

        if ($data) {
            $form->setValues($data);
        } else {
            $form->setValues($model->getData());
        }

        return parent::_prepareForm();
    }

}
