<?php

class ISM_News_Block_Adminhtml_News_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareLayout() {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
    }

    protected function _prepareForm()
    {
        $helper = Mage::helper('news');
        $model = Mage::registry('current_news');

        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array(
                'id' => $this->getRequest()->getParam('id')
            )),
            'method' => 'post',
            'enctype' => 'multipart/form-data'
        ));

        $this->setForm($form);

        $fieldset = $form->addFieldset('news_form', array('legend' => $helper->__('News Information')));

        $fieldset->addField('title', 'text', array(
            'label' => $helper->__('Title'),
            'required' => true,
            'name' => 'title',
        ));

        $fieldset->addField('content', 'editor', array(
            'label' => $helper->__('Content'),
            'required' => true,
            'name' => 'content',
            'config'    => Mage::getSingleton('cms/wysiwyg_config')->getConfig()
        ));

        $fieldset->addField('announce', 'editor', array(
            'label' => $helper->__('Announce'),
            'name' => 'announce',
        ));
//
        $fieldset->addField('publish_date', 'datetime', array(
            'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'label' => $helper->__('Publish date'),
            'name' => 'publish_date',
            'required' => true
        ));

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