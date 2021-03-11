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
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Lof\PosReceipt\Controller\Adminhtml\Receipt;

use Lof\PosReceipt\Block\Adminhtml\Receipt\Tab\Product;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\Result\Raw;
use Magento\Framework\Controller\Result\RawFactory;
use Magento\Framework\View\LayoutFactory;

/**
 * Class Grid
 * @package Lof\PosReceipt\Controller\Adminhtml\Receipt
 */
class Grid extends \Lof\PosReceipt\Controller\Adminhtml\Receipt
{
    /**
     * @var RawFactory
     */
    protected $resultRawFactory;
    /**
     * @var LayoutFactory
     */
    protected $layoutFactory;
    /**
     * @param Context $context
     * @param RawFactory $resultRawFactory
     * @param LayoutFactory $layoutFactory
     */
    public function __construct(
        Context $context,
        RawFactory $resultRawFactory,
        LayoutFactory $layoutFactory
    ) {
        parent::__construct($context);
        $this->resultRawFactory = $resultRawFactory;
        $this->layoutFactory = $layoutFactory;
    }
    /**
     * Grid Action
     * Display list of products related to current category
     *
     * @return Raw
     */
    public function execute()
    {
        $Receipt = $this->_initReceipt();
        if (!$Receipt) {
            /** @var Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('lof_PosReceipt/*/', ['_current' => true, 'receipt_id' => null]);
        }
        $resultRaw = $this->resultRawFactory->create();
        return $resultRaw->setContents(
            $this->layoutFactory->create()->createBlock(
                Product::class,
                'receipt.product.grid'
            )->toHtml()
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Lof_PosReceipt::receipt_view');
    }
}
