<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace MagentoEse\B2BOrderApproval\Setup;

use Magento\Framework\Setup;

class Installer implements Setup\SampleData\InstallerInterface
{
    /**
     * Setup class for Customer Attributes
     *
     * @var \MagentoEse\B2BOrderApproval\Model\CustomerAttributes
     */
    protected $customerAttributeSetup;


    public function __construct(
        \MagentoEse\B2BOrderApproval\Model\CustomerAttributes $customerAttributeSetup
    ) {
        $this->customerAttributeSetup = $customerAttributeSetup;
    }

    /**
     * {@inheritdoc}
     */
    public function install()
    {
        $this->customerAttributeSetup->install();
    }
}