<?php

class ISM_NewstoreMember_Model_Observer
{

    public function catalogProductSaveBefore(Varien_Event_Observer $observer)
    {
        $product = $observer->getProduct();
        $data = $product->getData();
        $groupPrices = $product->getData('group_price');
        if (is_null($groupPrices)) {
            $attribute = $product->getResource()->getAttribute('group_price');
            if ($attribute){
                $attribute->getBackend()->afterLoad($product);
                $data['group_price'] = $product->getData('group_price');
            }
        }

        $newstorememberPrice = &$data['ism_newstoremembers_price'];
        if ($product->getPrice() < $newstorememberPrice) {
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
        $product->setData($data);
    }

    public function customerSaveBefore(Varien_Event_Observer $observer)
    {
        /** @var $customer Mage_Customer_Model_Customer */
        $customer = $observer->getCustomer();

        $origDataCustomer = $customer->getOrigData();
        $dataCustomer = $customer->getData();

        $origGroupId = $origDataCustomer['group_id'];
        $groupId = $dataCustomer['group_id'];

        if ($origGroupId !== $groupId) {
            /**@var $helper ISM_NewstoreMember_Helper_Data */
            $helper = Mage::helper('newstoremember');
            $newstoremembersGroupId = $helper->getNewstoreMembersGroupId();
            /**@var $model ISM_NewstoreMember_Model_Newstoremember */
            $model = Mage::getModel('newstoremember/newstoremember');

            $customerId = $dataCustomer['entity_id'];
            if ($origGroupId === $newstoremembersGroupId) {
                $model->unsetNewstoremembersCustomer($origDataCustomer['entity_id']);
            } else if ($groupId === $newstoremembersGroupId && Mage::getSingleton('customer/customer')->getEntityId() !== $customerId) {
                $customer->setData($dataCustomer);
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

    public function customerLogin(Varien_Event_Observer $observer)
    {
        $customer = $observer->getCustomer();
        /**@var $newstorememberModel ISM_NewstoreMember_Model_Newstoremember */
        $newstorememberModel = Mage::getModel('newstoremember/newstoremember');
        $data = $newstorememberModel->getCollection()->getItemByColumnValue('customer_id', $customer->getEntityId());

        if ($data && $data->getExpireDate() < now(true)) {
            $customer->setGroupId($customer->getPrevGroupId())->save();
        }

    }
}
