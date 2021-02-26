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
namespace Lof\PosReceipt\Model;

use Lof\PosReceipt\Model\Receipt;
use Magento\Backend\App\Action\Context;
use Lof\Outlet\Model\Outlet;
use Lof\PosReceipt\Api\ReceiptManagementInterface;

class ReceiptManagement implements ReceiptManagementInterface
{
    private $receipt;
    private $outlet;
    /**
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
    protected $_filterProvider;

    public function __construct(
        Context $context,
        Receipt $receipt,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        Outlet $outlet
    ) {
        $this->receipt = $receipt;
        $this->_filterProvider = $filterProvider;
        $this->outlet = $outlet;
    }
    /**
     * {@inheritdoc}
     */
    public function getReceipt($outletId)
    {

        $outlet = $this->outlet->load($outletId);
        $receiptId = $outlet->getSelectReceipt();
        $receipt = $this->receipt->load($receiptId);
        $header_content =  $this->getCmsFilterContent($receipt->getHeaderContent());
        $footer_content =  $this->getCmsFilterContent($receipt->getFooterContent());
        $receipt->setHeaderContent($header_content);
        $receipt->setFooterContent($footer_content);
        $arrResult = [];
        $arrResult[]['data'] = $receipt->getData();
        return $arrResult;
    }

    /**
     * Prepare HTML content
     *
     * @return string
     * @throws \Exception
     */
    public function getCmsFilterContent($value = '')
    {
        $html = $this->_filterProvider->getPageFilter()->filter($value);
        return $html;
    }
}
