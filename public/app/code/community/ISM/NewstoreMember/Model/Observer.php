<?php

class ISM_NewstoreMember_Model_Observer
{

    public function catalogProductSaveBefore(Varien_Event_Observer $observer)
    {
        $product = $observer->getProduct();
        $data  = $product->getData();
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
        if (!$newstorememberPrice && $newstorememberPrice!=='') {
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
        /**@var $helper ISM_NewstoreMember_Helper_Data */
        $customer = $observer->getCustomer();
        $helper = Mage::helper('newstoremember');
        $origDataCustomer = $customer->getOrigData();
        $dataCustomer = $customer->getData();
        $origGroupId = $origDataCustomer['group_id'];
        $groupId = $dataCustomer['group_id'];
        $newstoremembersGroupId = $helper->getNewstoreMembersGroupId();
        if ($origGroupId !== $groupId) {
            $customerId = $dataCustomer['entity_id'];
            $model = Mage::getModel('newstoremember/newstoremember');
            if ($origGroupId === $newstoremembersGroupId) {
                $model->unsetNewstoremembersCustomer($customerId);
            } else if ($origGroupId !== $helper->getNewstoreMembersGroupId() && $groupId === $newstoremembersGroupId) {
                $model->addCustomerToNewstoremembers($customerId);
            }
        }
    }

    public function catalogProductImportFinishBefore(Varien_Event_Observer $observer){
        echo "asd";
    }

    public function checkoutTypeOnepageSaveOrderAfter(Varien_Event_Observer $observer)
    {
        $order = $observer->getOrder();
        $customer = $order->getCustomer();
        $collection = Mage::getModel('newstoremember/newstoremember')->getCollection()
            ->getItemByColumnValue('customer_id', $customer->getEntityId());
        $helper = Mage::helper('newstoremember');
        if ($customer->getGroupId() === $helper->getNewstoreMembersGroupId() && $collection->hasUniqueKey()) {
            $key = $collection->getUniqueKey();
            $order->setNewstoremembersNumber($key)->save();
            $observer->getQuote()->setNewstoremembersNumber($key)->save();
        }
    }

    public function crontabNewstorememberExpireDate()
    {
        $var = now(true);
        /**@var $model ISM_NewstoreMember_Model_Newstoremember*/
        $model = Mage::getModel('newstoremember/newstoremember');
        /**@var $customers ISM_NewstoreMember_Model_Resource_Newstoremember_Collection*/
        $customers  = $model->getCollection()
            ->addFieldToFilter('expire_date', array(
                'to'=>$var
            ));
        $masCustomerId  = [];
        foreach($customers as $customer){
            $customerId = $customer->getCustomerId();
            if($customerId) {
                $masCustomerId[] = $customerId;
            }
            $customer->setCustomerId(null)->save();
        }
        /**@var $modelCustomer ISM_NewstoreMember_Model_Customer*/
        $modelCustomer = Mage::getModel('newstoremember/customer');
        foreach($masCustomerId as $customerId){
            $modelCustomer->toPrevCustomerGroup($customerId);
        }
    }
}
