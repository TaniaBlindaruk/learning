<?php


class ISM_NewstoreMember_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getUserListIsNotNewstoreMembers($currentId)
    {
        function compare($key1, $key2)
        {
            return $key1['value'] == $key2['value'] ? 0 : -1;
        }

        /** @var Mage_Customer_Model_Resource_Customer_Collection $customers */
        $customers = Mage::getModel('customer/customer')->getCollection()->addNameToSelect();
        $newstoremembers = Mage::getModel('newstoremember/newstoremember')->getCollection()->toCustomerOptionArray();
        $fullCustomer = array_merge(array(array(
            'value' => null,
            'label' => '-------------------'
        )), $customers->toOptionArray());
        $newstoremembers = array_udiff($newstoremembers,
            array(
                array(
                    'value' => $currentId
                )
            ),
            'compare');
        $result = array_udiff($fullCustomer, $newstoremembers, 'compare');
        return $result;
    }

    public function getNewstoreMembersGroupId()
    {
        return Mage::getStoreConfig('newstoremember/newstoremember_group/newstoremember_field_group');
    }

    public function getNewQniqueNumber()
    {
        return Mage::helper('core')->getRandomString(10);
    }

    public function addCustomerToNewstoreMemberFrontend($number)
    {
        /**@var $singltonSession Mage_Core_Model_Session */
        $singltonSession = Mage::getSingleton('core/session');
        $customer = Mage::getSingleton('customer/session')->getCustomer();
        $billingAddress = $customer->getPrimaryBillingAddress();
        if ($billingAddress) {

            /**@var $model ISM_NewstoreMember_Model_Newstoremember */
            $model = Mage::getSingleton('newstoremember/newstoremember');
            /**@var $collectionNewstoremember ISM_NewstoreMember_Model_Resource_Newstoremember_Collection */
            $collectionNewstoremember = $model->getCollection();
            $newstoremember = $collectionNewstoremember->getItemByColumnValue('unique_key', $number);
            if (empty($newstoremember)) {
                $singltonSession->addError('Your newstoremember number is invalid!');
                return false;
            } else {

                if ($newstorememberCustomerId = $newstoremember -> getCustomerId()) {
                    $singltonSession->addError('This newstoremember number is not free!');
                    return false;
                }

                $newstorememberExpireDate = $newstoremember -> getExpireDate();
                if ($newstorememberExpireDate < now()) {
                    $singltonSession->addError('This newstoremember number is invalid');
                    return false;
                }

                if ($billingAddress->getPostcode() !== $newstoremember->getPostCode()) {
                    $singltonSession->addError('Sorry, but your postcode is invalid.');
                    return false;
                }

                $newstoremember->setCustomerId($customer->getEntityId());
                $model->setData($newstoremember->getData())->save();
                return true;

            }
        } else {
            $singltonSession->addError('Please, create address');
            return false;
        }
    }


    public function import(){
        $varienFileCsv = new Varien_File_Csv();
        $file = $_FILES['import_file'];
        if($file['type']=='text/csv') {
            $data = $varienFileCsv->getData($file['tmp_name']);
            $nameAttribute = array();
            if ($data) {
                $row = count($data);
                if (isset($data[0])) {
                    $firsRow = $data[0];
                    $cel = count($firsRow);
                    for ($i = 0; $i < $cel; ++$i) {
                        if ($firsRow[$i] == 'sku') {
                            $nameAttribute['sku'] = $i;
                            continue;
                        }
                        if ($firsRow[$i] == 'ism_newstoremembers_price') {
                            $nameAttribute['ism_newstoremembers_price'] = $i;
                            continue;
                        }
                    }
                }

                $selectSku = array();
                $arraySkuPrice = array();
                for ($i = 1; $i < $row; ++$i) {
                    $sku = $data[$i][$nameAttribute['sku']];
                    $selectSku[] = $sku;
                    $arraySkuPrice[$sku] = $data[$i][$nameAttribute['ism_newstoremembers_price']];
                }

                $collection = Mage::getModel('catalog/product')->getCollection()
                    ->addAttributeToSelect('*')
                    ->addAttributeToFilter('sku', array(
                        'in' => $selectSku
                    ));

                foreach ($collection as $coll) {
                    try {
                        $coll->setIsmNewstoremembersPrice($arraySkuPrice[$coll->getSku()])->save();
                    } catch (Exception $e) {

                    }
                }
            }
        }else{
            throw new Exception('!csv');
        }
    }
}