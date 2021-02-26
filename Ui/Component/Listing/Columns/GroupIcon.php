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

namespace Lof\PosReceipt\Ui\Component\Listing\Columns;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;
use Lof\PosReceipt\Block\Adminhtml\Receipt\Grid\Renderer\Action\UrlBuilder;

class GroupIcon extends Column
{
    const TAG_URL_PATH_EDIT = 'lof_posreceipt/receipt/preview';


    private $editUrl;
    protected $urlBuilder;
    protected $_storeManager;

    /**
     * @param ContextInterface $context
     * @param UrlInterface $urlBuilder
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param StoreManagerInterface $storeManager
     * @param array $data
     * @param string $editUrl
     */
    public function __construct(
        ContextInterface $context,
        UrlInterface $urlBuilder,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        StoreManagerInterface $storeManager,
        array $data = [],
        $editUrl = self::TAG_URL_PATH_EDIT
    ) {
        $this->editUrl = $editUrl;
        $this->urlBuilder = $urlBuilder;
        $this->_storeManager = $storeManager;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item['receipt_id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl($this->editUrl, ['receipt_id' => $item['receipt_id']]),
                        'target'=>'_blank',
                        'label' => __('Preview')
                    ];
                }
            }
        }
        return $dataSource;
    }
}
