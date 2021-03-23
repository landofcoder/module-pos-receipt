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

namespace Lof\PosReceipt\Block\Adminhtml\Receipt\Edit;

use Lof\PosReceipt\Model\ReceiptFactory;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class SaveAndContinue
 */
class SaveAndContinue extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return mixed
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save and Continue Edit'),
            'class' => 'save',
            'data_attribute' => [
                'mage-init' => [
                    'button' => ['event' => 'saveAndContinueEdit'],
                ],
            ],
            // 'on_click' => sprintf("location.href= '%s';", $this->getSaveUrl()),
            'sort_order' => 80,
        ];
    }

    /**
     * @return string
     */
    public function getSaveUrl()
    {
        return $this->getUrl('*/receipt/preview', []);
    }
}
