<?php

class ISM_NewstoreMember_Model_Observer
{

    public function controllerActionPredispatchAdminhtmlCatalogProductSave(Varien_Event_Observer $observer)
    {
        /**@var $request Mage_Core_Controller_Request_Http */
        $request = $observer->getControllerAction()->getRequest();
        $data = $request->getPost()['product'];
        $newstorememberPrice = &$data['ism_newstoremembers_price'];
        if ($data['price'] < $newstorememberPrice) {
            $newstorememberPrice = '';
        }
        $delete = '';
        $newstorememberGroupId = Mage::helper('newstoremember')->getNewstoreMembersGroupId();
        $newstorememberPriceArray = array(
            "website_id" => '0',
            "cust_group" => $newstorememberGroupId,
            "price" => $data['ism_newstoremembers_price'],
            "delete" => $delete
        );
        if (!$newstorememberPrice && $newstorememberPrice !== '0') {
            $newstorememberPriceArray['delete'] = '1';
            $arrayGroupPrice = &$data['group_price'];
            $countGroupPrice = count($arrayGroupPrice);
            for ($i = 0; $i < $countGroupPrice; ++$i) {
                if ($arrayGroupPrice[$i]['cust_group'] == $newstorememberGroupId) {
                    $arrayGroupPrice[$i] = $newstorememberPriceArray;
                    break;
                }
            }
        } else {
            $data['group_price'][] = $newstorememberPriceArray;
        }
        $request->setPost('product', $data);
    }
}
