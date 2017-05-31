<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace MagentoEse\B2bOrderApproval\Setup;

use Magento\Framework\Setup;

class Installer implements Setup\SampleData\InstallerInterface
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


    public function __construct(
        \MagentoEse\B2bOrderApproval\Model\CustomerAttributes $customerAttributeSetup,
        \MagentoEse\B2bOrderApproval\Model\Customers $setCustomerApprovalAmount,
        \MagentoEse\B2bOrderApproval\Model\OrderStatus $orderStatus
    ) {
        $this->customerAttributeSetup = $customerAttributeSetup;
        $this->setCustomerApprovalAmount = $setCustomerApprovalAmount;
        $this->orderStatus = $orderStatus;
    }


    public function install()
    {
        $this->customerAttributeSetup->install();
        $this->setCustomerApprovalAmount->install(['MagentoEse_B2bOrderApproval::fixtures/0.0.1_customerUpdate.csv']);
        $this->orderStatus->install();
    }
}