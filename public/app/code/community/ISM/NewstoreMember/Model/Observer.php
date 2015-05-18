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

    public function newstorememberAdminhtmlCustomerPrepareSave(Varien_Event_Observer $observer)
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

    }
}
