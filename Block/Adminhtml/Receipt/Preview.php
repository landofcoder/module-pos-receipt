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
namespace Lof\PosReceipt\Block\Adminhtml\Receipt;

use Magento\Cms\Model\Template\FilterProvider;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\View\Element\Template;
use Lof\PosReceipt\Model\ReceiptFactory;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class Preview
 * @package Lof\PosReceipt\Block\Adminhtml\Receipt
 */
class Preview extends \Magento\Framework\View\Element\Template
{
    /**
     * @var ReceiptFactory|mixed
     */
    private $ReceiptFactory = null;
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;
    /**
     * @var FilterProvider
     */
    private $_filterProvider;

    /**
     * Preview constructor.
     * @param Context $context
     * @param ReceiptFactory $ReceiptFactory
     * @param UrlInterface $urlBuilder
     * @param FilterProvider $filterProvider
     * @param array $data
     */
    public function __construct(
        Context $context,
        ReceiptFactory $ReceiptFactory,
        UrlInterface $urlBuilder,
        FilterProvider $filterProvider,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->urlBuilder = $urlBuilder;
        $this->_filterProvider = $filterProvider;
        $this->ReceiptFactory = $ReceiptFactory
            ?: ObjectManager::getInstance()->get(ReceiptFactory::class);
    }

    /**
     *
     */
    public function execute()
    {
    }

    /**
     * Prepare HTML content
     *
     * @return string
     * @throws \Exception
     */
    public function getCmsFilterContent($value = '')
    {
        return $this->_filterProvider->getPageFilter()->filter($value);
    }

    /**
     * @param $asset
     * @return mixed
     */
    public function getAssetUrl($asset)
    {
        $objectManager = ObjectManager::getInstance();
        $assetRepository = $objectManager->get('Magento\Framework\View\Asset\Repository');
        return $assetRepository->createAsset($asset)->getUrl();
    }

    /**
     * @return mixed
     */
    public function getReceipt()
    {
        $model = $this->ReceiptFactory->create();
        $id = $this->getRequest()->getParam('receipt_id');
        return $model->load($id);
    }

    /**
     * @return string
     */
    public function getDomain()
    {
        return $this->urlBuilder->getBaseUrl();
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item['receipt_id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl('lof_posreceipt/receipt/preview', ['receipt_id' => $item['receipt_id']]),
                        'target'=>'_blank',
                        'label' => __('Preview')
                    ];
                }
            }
        }
        return $dataSource;
    }
}
