<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace MagentoEse\B2bOrderApproval\Setup\Patch\Data;


use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;
use MagentoEse\B2bOrderApproval\Model\CustomerAttributes;
use MagentoEse\B2bOrderApproval\Model\Customers;
use MagentoEse\B2bOrderApproval\Model\OrderStatus;

class OldInstallData implements DataPatchInterface, PatchVersionInterface
{


    /**
     * @var \MagentoEse\B2BOrderApproval\Model\CustomerAttributes
     */
    protected $customerAttributeSetup;
    /**
     * @var \MagentoEse\B2BOrderApproval\Model\Customers
     */
    protected $setCustomerApprovalAmount;
    /**
     * @var \MagentoEse\B2BOrderApproval\Model\OrderStatus
     */
    protected $orderStatus;

    /**
     * Installer constructor.
     * @param \MagentoEse\B2bOrderApproval\Model\CustomerAttributes $customerAttributeSetup
     * @param \MagentoEse\B2bOrderApproval\Model\Customers $setCustomerApprovalAmount
     * @param \MagentoEse\B2bOrderApproval\Model\OrderStatus $orderStatus
     */
    public function __construct(
        CustomerAttributes $customerAttributeSetup,
        Customers $setCustomerApprovalAmount,
        OrderStatus $orderStatus
    ) {
        $this->customerAttributeSetup = $customerAttributeSetup;
        $this->setCustomerApprovalAmount = $setCustomerApprovalAmount;
        $this->orderStatus = $orderStatus;

    }

    public function apply()
    {
        $this->customerAttributeSetup->install();
        $this->orderStatus->install();
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }

    public static function getVersion()
    {
        return '0.0.2';
    }
}