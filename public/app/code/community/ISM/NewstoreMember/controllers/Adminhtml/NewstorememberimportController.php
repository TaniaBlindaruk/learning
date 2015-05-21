<?php

/**
 * Created by PhpStorm.
 * User: tania
 * Date: 04.05.15
 * Time: 15:20
 */
class ISM_NewstoreMember_Adminhtml_NewstorememberimportController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('newstoremember');

        $contentBlock = $this->getLayout()->createBlock('newstoremember/adminhtml_newstorememberimport_edit');
        $this->_addContent($contentBlock);
        $this->renderLayout();
    }

    public function validateAction(){
        $varienFileCsv  = new Varien_File_Csv();
        $data = $varienFileCsv->getData($_FILES['import_file']['tmp_name']);
        $nameAttribute = array();
        if($data){
            $row =count($data);
            if(isset($data[0])){
                $firsRow = $data[0];
                $cel =count($firsRow);
                for($i =0; $i<$cel;++$i){
                    if($firsRow[$i]=='sku'){
                        $nameAttribute['sku'] = $i;
                        continue;
                    }
                    if($firsRow[$i]=='ism_newstoremembers_price'){
                        $nameAttribute['ism_newstoremembers_price'] = $i;
                        continue;
                    }
                }
            }

            for($i=1;$i<$row;++$i){
                $sku = $data[$i][$nameAttribute['sku']];
                $data[$i][$nameAttribute['ism_newstoremembers_price']];

                $collection = Mage::getModel('catalog/product')->getCollection();
                $collection->getSelect()->addAttributeToFilter('sku', array(
                    'in' => array(100, 'asd')
                ));

            }
        }
        //Varien_File_Csv()
        //file_get_contents($_FILES['io_file']['tmp_name'])
        // Varien_File_Uploader('io_file')
    }
}