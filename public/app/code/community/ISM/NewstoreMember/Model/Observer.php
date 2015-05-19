<?php

class ISM_NewstoreMember_Model_Observer
{

    public function catalogProductSaveBefore(Varien_Event_Observer $observer)
    {
        $product = $observer->getProduct();
        $data = $product->getData();
        $newstorememberPrice = &$data['ism_newstoremembers_price'];
        if ($data['price'] < $newstorememberPrice) {
            $origData = $product->getOrigData();
            $newstorememberPrice = $origData['ism_newstoremembers_price'];
        }
        $delete = '';
        $newstorememberGroupId = Mage::helper('newstoremember')->getNewstoreMembersGroupId();
        $newstorememberPriceArray = array(
            "website_id" => '0',
            "cust_group" => $newstorememberGroupId,
            "price" => $newstorememberPrice,
            "delete" => $delete
        );
        if (!$newstorememberPrice && $newstorememberPrice !== '') {
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
        $product->setData($data);
    }

    public function customerSaveBefore(Varien_Event_Observer $observer)
    {


    }
}
