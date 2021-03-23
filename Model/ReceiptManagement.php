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

use Exception;
use Lof\Outlet\Model\Outlet;
use Lof\PosReceipt\Api\ReceiptManagementInterface;
use Magento\Cms\Model\Template\FilterProvider;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class ReceiptManagement
 * @package Lof\PosReceipt\Model
 */
class ReceiptManagement implements ReceiptManagementInterface
{
    /**
     * @var Receipt
     */
    private $receipt;
    /**
     * @var Outlet
     */
    private $outlet;
    /**
     * @var FilterProvider
     */
    protected $_filterProvider;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * ReceiptManagement constructor.
     * @param Receipt $receipt
     * @param FilterProvider $filterProvider
     * @param Outlet $outlet
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Receipt $receipt,
        FilterProvider $filterProvider,
        Outlet $outlet,
        StoreManagerInterface $storeManager
    ) {
        $this->receipt = $receipt;
        $this->_filterProvider = $filterProvider;
        $this->outlet = $outlet;
        $this->storeManager = $storeManager;

    }

    /**
     * {@inheritdoc}
     * @throws Exception
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
        $data = $receipt->getData();
        $data['icon'] = $this->getMediaUrl().$receipt->getIcon();
        return $data;
    }


    /**
     * @param string $value
     * @return string
     * @throws Exception
     */
    public function getCmsFilterContent($value = '')
    {
        return $this->_filterProvider->getPageFilter()->filter($value);
    }

    /**
     * @return string
     * @throws NoSuchEntityException
     */
    public function getMediaUrl()
    {
        return $this->storeManager->getStore()
                ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA).$this->receipt::ICON_URL_PATH;
    }
}
