<?php
/**
 * Copyright © LandOfCoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\PosReceipt\Model\Resolver;

use Lof\PosReceipt\Api\ReceiptManagementInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\GraphQl\Model\Query\ContextInterface;


/**
 * Class Receipt
 * @package Lof\PosReceipt\Model\Resolver
 */
class Receipt implements ResolverInterface
{

    /**
     * @var ReceiptManagementInterface
     */
    private $receiptManagement;

    /**
     * ProductByBarcode constructor.
     * @param ReceiptManagementInterface $receiptManagement
     */
    public function __construct(
        ReceiptManagementInterface $receiptManagement
    ) {
        $this->receiptManagement = $receiptManagement;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        /** @var ContextInterface $context */
        if (!$context->getUserId()) {
            throw new GraphQlAuthorizationException(__('The current user isn\'t authorized.'));
        }
        return $this->receiptManagement->getReceipt($args['outlet_id']);
    }
}

