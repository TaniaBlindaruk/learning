<?php

class ISM_NewstoreMembers_Model_Import_Entity_Product extends Mage_ImportExport_Model_Import_Entity_Product
{

    /**
     * Gather and save information about product entities.
     *
     * @return Mage_ImportExport_Model_Import_Entity_Product
     */
    protected function _saveProducts()
    {
//        $priceIsGlobal  = Mage::helper('catalog')->isPriceGlobal();
//        $productLimit   = null;
//        $productsQty    = null;
//
//        while ($bunch = $this->_dataSourceModel->getNextBunch()) {
//            $entityRowsIn = array();
//            $entityRowsUp = array();
//            $attributes   = array();
//            $websites     = array();
//            $categories   = array();
//            $tierPrices   = array();
//            $groupPrices  = array();
//            $mediaGallery = array();
//            $uploadedGalleryFiles = array();
//            $previousType = null;
//            $previousAttributeSet = null;
//
//            foreach ($bunch as $rowNum => $rowData) {
//                $this->_filterRowData($rowData);
//                if (!$this->validateRow($rowData, $rowNum)) {
//                    continue;
//                }
//                $rowScope = $this->getRowScope($rowData);
//
//                if (self::SCOPE_DEFAULT == $rowScope) {
//                    $rowSku = $rowData[self::COL_SKU];
//
//                    // 1. Entity phase
//                    if (isset($this->_oldSku[$rowSku])) { // existing row
//                        $entityRowsUp[] = array(
//                            'updated_at' => now(),
//                            'entity_id'  => $this->_oldSku[$rowSku]['entity_id']
//                        );
//                    } else { // new row
//                        if (!$productLimit || $productsQty < $productLimit) {
//                            $entityRowsIn[$rowSku] = array(
//                                'entity_type_id'   => $this->_entityTypeId,
//                                'attribute_set_id' => $this->_newSku[$rowSku]['attr_set_id'],
//                                'type_id'          => $this->_newSku[$rowSku]['type_id'],
//                                'sku'              => $rowSku,
//                                'created_at'       => now(),
//                                'updated_at'       => now()
//                            );
//                            $productsQty++;
//                        } else {
//                            $rowSku = null; // sign for child rows to be skipped
//                            $this->_rowsToSkip[$rowNum] = true;
//                            continue;
//                        }
//                    }
//                } elseif (null === $rowSku) {
//                    $this->_rowsToSkip[$rowNum] = true;
//                    continue; // skip rows when SKU is NULL
//                } elseif (self::SCOPE_STORE == $rowScope) { // set necessary data from SCOPE_DEFAULT row
//                    $rowData[self::COL_TYPE]     = $this->_newSku[$rowSku]['type_id'];
//                    $rowData['attribute_set_id'] = $this->_newSku[$rowSku]['attr_set_id'];
//                    $rowData[self::COL_ATTR_SET] = $this->_newSku[$rowSku]['attr_set_code'];
//                }
//                if (!empty($rowData['_product_websites'])) { // 2. Product-to-Website phase
//                    $websites[$rowSku][$this->_websiteCodeToId[$rowData['_product_websites']]] = true;
//                }
//
//                // 3. Categories phase
//                $categoryPath = empty($rowData[self::COL_CATEGORY]) ? '' : $rowData[self::COL_CATEGORY];
//                if (!empty($rowData[self::COL_ROOT_CATEGORY])) {
//                    $categoryId = $this->_categoriesWithRoots[$rowData[self::COL_ROOT_CATEGORY]][$categoryPath];
//                    $categories[$rowSku][$categoryId] = true;
//                } elseif (!empty($categoryPath)) {
//                    $categories[$rowSku][$this->_categories[$categoryPath]] = true;
//                }
//
//                if (!empty($rowData['_tier_price_website'])) { // 4.1. Tier prices phase
//                    $tierPrices[$rowSku][] = array(
//                        'all_groups'        => $rowData['_tier_price_customer_group'] == self::VALUE_ALL,
//                        'customer_group_id' => ($rowData['_tier_price_customer_group'] == self::VALUE_ALL)
//                            ? 0 : $rowData['_tier_price_customer_group'],
//                        'qty'               => $rowData['_tier_price_qty'],
//                        'value'             => $rowData['_tier_price_price'],
//                        'website_id'        => (self::VALUE_ALL == $rowData['_tier_price_website'] || $priceIsGlobal)
//                            ? 0 : $this->_websiteCodeToId[$rowData['_tier_price_website']]
//                    );
//                }
//                if (!empty($rowData['_group_price_website'])) { // 4.2. Group prices phase
//                    $groupPrices[$rowSku][] = array(
//                        'all_groups'        => $rowData['_group_price_customer_group'] == self::VALUE_ALL,
//                        'customer_group_id' => ($rowData['_group_price_customer_group'] == self::VALUE_ALL)
//                            ? 0 : $rowData['_group_price_customer_group'],
//                        'value'             => $rowData['_group_price_price'],
//                        'website_id'        => (self::VALUE_ALL == $rowData['_group_price_website'] || $priceIsGlobal)
//                            ? 0 : $this->_websiteCodeToId[$rowData['_group_price_website']]
//                    );
//                }
//                foreach ($this->_imagesArrayKeys as $imageCol) {
//                    if (!empty($rowData[$imageCol])) { // 5. Media gallery phase
//                        if (!array_key_exists($rowData[$imageCol], $uploadedGalleryFiles)) {
//                            $uploadedGalleryFiles[$rowData[$imageCol]] = $this->_uploadMediaFiles($rowData[$imageCol]);
//                        }
//                        $rowData[$imageCol] = $uploadedGalleryFiles[$rowData[$imageCol]];
//                    }
//                }
//                if (!empty($rowData['_media_image'])) {
//                    $mediaGallery[$rowSku][] = array(
//                        'attribute_id'      => $rowData['_media_attribute_id'],
//                        'label'             => $rowData['_media_lable'],
//                        'position'          => $rowData['_media_position'],
//                        'disabled'          => $rowData['_media_is_disabled'],
//                        'value'             => $rowData['_media_image']
//                    );
//                }
//                // 6. Attributes phase
//                $rowStore     = self::SCOPE_STORE == $rowScope ? $this->_storeCodeToId[$rowData[self::COL_STORE]] : 0;
//                $productType  = isset($rowData[self::COL_TYPE]) ? $rowData[self::COL_TYPE] : null;
//                if (!is_null($productType)) {
//                    $previousType = $productType;
//                }
//                if (!is_null($rowData[self::COL_ATTR_SET])) {
//                    $previousAttributeSet = $rowData[Mage_ImportExport_Model_Import_Entity_Product::COL_ATTR_SET];
//                }
//                if (self::SCOPE_NULL == $rowScope) {
//                    // for multiselect attributes only
//                    if (!is_null($previousAttributeSet)) {
//                        $rowData[Mage_ImportExport_Model_Import_Entity_Product::COL_ATTR_SET] = $previousAttributeSet;
//                    }
//                    if (is_null($productType) && !is_null($previousType)) {
//                        $productType = $previousType;
//                    }
//                    if (is_null($productType)) {
//                        continue;
//                    }
//                }
//                $rowData = $this->_productTypeModels[$productType]->prepareAttributesForSave(
//                    $rowData,
//                    !isset($this->_oldSku[$rowSku])
//                );
//                try {
//                    $attributes = $this->_prepareAttributes($rowData, $rowScope, $attributes, $rowSku, $rowStore);
//                } catch (Exception $e) {
//                    Mage::logException($e);
//                    continue;
//                }
//            }
//
//            $this->_saveProductEntity($entityRowsIn, $entityRowsUp)
//                ->_saveProductWebsites($websites)
//                ->_saveProductCategories($categories)
//                ->_saveProductTierPrices($tierPrices)
//                ->_saveProductGroupPrices($groupPrices)
//                ->_saveMediaGallery($mediaGallery)
//                ->_saveProductAttributes($attributes);
//        }
//        return $this;
        parent::_saveProducts();

    }
}
