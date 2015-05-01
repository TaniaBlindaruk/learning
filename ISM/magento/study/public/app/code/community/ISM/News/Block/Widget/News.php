<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright  Copyright (c) 2006-2014 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * New products widget
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class ISM_News_Block_Widget_News extends ISM_News_Block_News
    implements Mage_Widget_Block_Interface
{
    private function getLimit(){
        return $this->getData('news_count');
    }
    public function getNewsCollection()
    {
        $data = parent::getNewsCollection();
        $data->getSelect()->limit($this->getLimit());
        return $data;
    }
    protected function _prepareLayout()
    {
        parent::_prepareLayout(); // TODO: Change the autogenerated stub
        /** @var Mage_Core_Block_Template $block */
//        $block = $this->getLayout()->addBlock('core/template', 'news.title');
//        $block->setTemplate('news/widget/title.phtml');
//        $this->setChild('news.title', $block);

    }
    protected function _beforeToHtml()
    {
        return parent::_beforeToHtml(); // TODO: Change the autogenerated stub
    }
}
