<?php

class ISM_NewstoreMembers_Block_Adminhtml_Key_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $helper = Mage::helper('newstoremembers');
        $model = Mage::registry('key_info');
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

        $fieldset->addField('unique_key', 'text', array(
            'label' => $helper->__('Unique key'),
            'required' => true,
            'name' => 'unique_key'
        ));


//        $fieldset->addField('content', 'editor', array(
//            'label' => $helper->__('Content'),
//            'required' => true,
//            'name' => 'content',
//        ));
//
        $fieldset->addField('expire_date', 'date', array(
            'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'label' => $helper->__('Expire date'),
            'name' => 'expire_date',
            'required' => true
        ));
        $modelCustomer = Mage::getModel('customer/customer')->getCollection();
        foreach($modelCustomer as $item){
//           echo "as";
        }
        $fieldset->addField('publish', 'select', array(
            'label' => $helper->__('Publish'),
            'name' => 'publish',
            'values' => array(
                array(
                    'value' => false,
                    'label' => $helper->__('No'),
                ),
                array(
                    'value' => true,
                    'label' =>  $helper->__('Yes'),

                )
            ),
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
