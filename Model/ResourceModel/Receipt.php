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
namespace Lof\PosReceipt\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\Context;

/**
 * Class Receipt
 * @package Lof\PosReceipt\Model\ResourceModel
 */
class Receipt extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Receipt constructor.
     * @param Context $context
     */
    public function __construct(
		Context $context
	)
	{
		parent::__construct($context);
	}

    /**
     *
     */
    protected function _construct()
	{
		$this->_init('lof_pos_receipt', 'receipt_id');
	}

}
