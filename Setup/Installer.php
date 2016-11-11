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
     * @var \MagentoEse\B2BOrderApproval\Model\SetCustomerApprovalAmount
     */
    protected $setCustomerApprovalAmount;


    public function __construct(
        \MagentoEse\B2bOrderApproval\Model\CustomerAttributes $customerAttributeSetup,
        \MagentoEse\B2bOrderApproval\Model\SetCustomerApprovalAmount $setCustomerApprovalAmount
    ) {
        $this->customerAttributeSetup = $customerAttributeSetup;
        $this->setCustomerApprovalAmount = $setCustomerApprovalAmount;
    }


    public function install()
    {
        $this->customerAttributeSetup->install();
        $this->setCustomerApprovalAmount->install(['MagentoEse_B2bOrderApproval::fixtures/0.0.1_customerUpdate.csv']);
    }
}