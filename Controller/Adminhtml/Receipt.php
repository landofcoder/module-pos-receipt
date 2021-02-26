<?php
/**
 * Landofcoder
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * http://www.landofcoder.com/license-agreement.html
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category   Landofcoder
 * @package    Lof_PosReceipt
 * @copyright  Copyright (c) 2020 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */

declare(strict_types=1);
namespace Lof\PosReceipt\Controller\Adminhtml;
use Magento\Store\Model\Store;
/**
 * Catalog Receipt controller
 */
abstract class Receipt extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Lof_PosReceipt::Receipt';
    /**
     * @var \Magento\Framework\Stdlib\DateTime\Filter\Date
     */
    protected $dateFilter;
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Stdlib\DateTime\Filter\Date|null $dateFilter
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter = null
    ) {
        $this->dateFilter = $dateFilter;
        parent::__construct($context);
    }
    /**
     * Initialize requested category and put it into registry.
     * Root category can be returned, if inappropriate store/category is specified
     *
     * @return \Lof\PosReceipt\Model\Receipt|false
     */
    protected function _initReceipt()
    {
        $receiptId = $this->resolveReceiptId();
        $storeId = $this->resolveStoreId();
        $receipt = $this->_objectManager->create(\Lof\PosReceipt\Model\Receipt::class);
        if ($receiptId) {
            $receipt->load($receiptId);
        }
        $this->_objectManager->get(\Magento\Framework\Registry::class)->register('receipt', $receipt);
        $this->_objectManager->get(\Magento\Framework\Registry::class)->register('current_receipt', $receipt);
        $this->_objectManager->get(\Magento\Cms\Model\Wysiwyg\Config::class)
            ->setStoreId($storeId);
        return $receipt;
    }
    /**
     * Resolve Category Id (from get or from post)
     *
     * @return int
     */
    private function resolveReceiptId() : int
    {
        $receiptId = (int)$this->getRequest()->getParam('receipt_id', false);
        return $receiptId ?: (int)$this->getRequest()->getParam('entity_id', false);
    }
    /**
     * Resolve store id
     *
     * Tries to take store id from store HTTP parameter
     * @see Store
     *
     * @return int
     */
    private function resolveStoreId() : int
    {
        $storeId = (int)$this->getRequest()->getParam('store', false);
        return $storeId ?: (int)$this->getRequest()->getParam('store_id', Store::DEFAULT_STORE_ID);
    }
}