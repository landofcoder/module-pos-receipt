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

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Lof\PosReceipt\Block\Adminhtml\Receipt\Edit\GenericButton;
class SaveButton extends GenericButton implements ButtonProviderInterface
{
    public function getButtonData()
    {
        return [
            'label' => __('Save Configuration'),
            'class' => 'save primary',
            // 'data_attribute' => [
            //     'mage-init' => ['button' => ['event' => 'save']],
            //     'form-role' => 'save',
            // ],
            'on_click' => sprintf("location.href= '%s';", $this->getSaveUrl()),
            'sort_order' => 90
        ];
    }
    public function getSaveUrl()
    {
        return $this->getUrl('*/receipt/index', []) ;
    }
}