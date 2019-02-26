<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace MagentoEse\B2bOrderApproval\Setup\Patch\Data;


use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\AttributeRepository;
use Magento\Framework\Setup\Patch\DataPatchInterface;


class SetApprovalCustomerAttribute implements DataPatchInterface
{

    /** @var EavSetupFactory  */
    protected $eavSetupFactory;

    /** @var AttributeRepository  */
    protected $attributeRepository;

    /** @var CustomerSetupFactory  */
    protected $customerSetupFactory;

    public function __construct(CustomerSetupFactory $customerSetupFactory)
    {
        $this->customerSetupFactory = $customerSetupFactory;
    }

    public function apply()
    {
        $customerSetup = $this->customerSetupFactory->create();
        $usedInForms = ['adminhtml_customer', 'customer_account_edit'];

        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'order_approval_amount')
            ->addData([
                'used_in_forms' => $usedInForms,
            ]);
        $attribute->setData('is_visible', 0);
        $attribute->save();

    }

    public static function getDependencies()
    {
        return [OldInstallData::class];
    }

    public function getAliases()
    {
        return [];
    }

}