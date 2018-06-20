<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace MagentoEse\B2bOrderApproval\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Customer\Setup\CustomerSetupFactory;

class UpgradeData implements UpgradeDataInterface
{

    /**
     * Customer setup factory
     *
     * @var CustomerSetupFactory
     */
    private $customerSetupFactory;

    /**
     * Init
     *
     * @param CustomerSetupFactory $customerSetupFactory
     */
    public function __construct(CustomerSetupFactory $customerSetupFactory)
    {
        $this->customerSetupFactory = $customerSetupFactory;
    }

    public function upgrade( ModuleDataSetupInterface $setup, ModuleContextInterface $context )
    {
        //fix attribute setting so it shows in customer admin
        if (version_compare($context->getVersion(), '0.0.1', '<=')) {
            $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);
            $disableAGCAttribute = $customerSetup->getEavConfig()->getAttribute('customer', 'order_approval_amount');
            $disableAGCAttribute->setData('used_in_forms', ['customer_account_edit']);
            $disableAGCAttribute->setData('is_visible', 0);
            $disableAGCAttribute->save();
        }

    }

}
