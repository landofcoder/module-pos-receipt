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
namespace Lof\PosReceipt\Controller\Adminhtml\Receipt;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Backend\App\Action\Context;
use Lof\PosReceipt\Model\ReceiptFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\Filter\Date;
/**
 * Save Lof Receipt action.
 */
class Save extends \Lof\PosReceipt\Controller\Adminhtml\Receipt implements HttpPostActionInterface
{
    protected $dataPersistor;
    private $ReceiptFactory = null;
    private $receiptRepository = null;
    public function __construct(
        \Magento\Framework\Stdlib\DateTime\Filter\Date  $date = null,
        Context $context,
        DataPersistorInterface $dataPersistor,
        ReceiptFactory $ReceiptFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->ReceiptFactory = $ReceiptFactory
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(ReceiptFactory::class);
        parent::__construct($context, $date);
    }

    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            if (isset($data['status']) && $data['status'] === 'true') {
                $data['status'] = Receipt::STATUS_ENABLED;
            }
            if (empty($data['receipt_id'])) {
                $data['receipt_id'] = null;
            }
            if (empty($data['order_id_label'])) {
                $data['order_id_label'] = "Order id";
            }
            if (empty($data['discount_label'])) {
                $data['discount_label'] = "Discount";
            }
            if (empty($data['tax_label'])) {
                $data['tax_label'] = "Tax";
            }
            if (empty($data['credit_label'])) {
                $data['credit_label'] = "Credit";
            }
            if (empty($data['change_label'])) {
                $data['change_label'] = "Change";
            }
            if (empty($data['cashier_label'])) {
                $data['cashier_label'] = "Cashier";
            }
            if (empty($data['grand_total_label'])) {
                $data['grand_total_label'] = "Grand total";
            }
            // if (!empty($data['cashier_label'])) {
            //     $data['cashier_label'] = "Cashier";
            // }
            if (empty($data['subtotal_label'])) {
                $data['subtotal_label'] = "Subtotal";
            }
            if (!empty($data['receipt_title'])) {
                $data['receipt_title'] = preg_replace('/(#)|(%)|(&)|({)|(})|(!)|(@)|(:)|(;)|(,)|(<)|(>)|(=)/', '', $data['receipt_title']);
                $data['receipt_title'] = trim($data['receipt_title']);
            }
            /** @var \Lof\PosReceipt\Model\Receipt $model */
            $model = $this->ReceiptFactory->create();
            $id = $data['receipt_id'];
            if ($id) {
                try {
                    $model = $model->load($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This receipt no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }
            $data = $this->_filterFoodData($data);
            $model->setData($data);
            $model->save();
            $this->_eventManager->dispatch(
                'lof_PosReceipt_prepare_save',
                ['receipt' => $model, 'request' => $this->getRequest()]
            );
            try{
                $model->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the receipt.'));
                $this->dataPersistor->clear('lof_pos_receipt');
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/receipt/edit', ['receipt_id' => $model->getReceiptId(), '_current' => true]);
                    return;
                }
                else{
                    $this->_redirect('*/receipt/index');
                    return;
                }
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }
        return $resultRedirect->setPath('*/*/');
    }
    public function _filterFoodData(array $rawData)
    {
        $data = $rawData;
        if (isset($data['icon'][0]['name'])) {
            $data['icon'] = $data['icon'][0]['name'];
        } else {
            $data['icon'] = null;
        }
        return $data;
    }
}