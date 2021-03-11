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

/**
 * Class Receipt
 * @package Lof\PosReceipt\Model
 */
class Receipt extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    /**
     *
     */
    const CACHE_TAG = 'lof_pos_receipt';

    /**
     * @var string
     */
    protected $_cacheTag = 'lof_pos_receipt';

    /**
     * @var string
     */
    protected $_eventPrefix = 'lof_pos_receipt';

    /**
     *
     */
    const ICON_URL_PATH = 'pos/receipt/icon/';
    /**
     *
     */
    protected function _construct()
	{
		$this->_init('Lof\PosReceipt\Model\ResourceModel\Receipt');
	}

    /**
     * @return string[]
     */
    public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getReceiptId()];
	}

    /**
     * @param $identifier
     * @param $storeId
     * @param bool $isAdmin
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function checkReceiptTitle($identifier, $storeId, $isAdmin = false){
		return $this->_getResource()->checkIdentifier($identifier, $storeId, $isAdmin);
	}

}
