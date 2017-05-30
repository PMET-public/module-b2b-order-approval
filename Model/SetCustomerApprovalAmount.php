<?php
/**
 * Created by PhpStorm.
 * User: jbritts
 * Date: 10/19/16
 * Time: 10:40 AM
 */

namespace MagentoEse\B2bOrderApproval\Model;

use Magento\Framework\Setup\SampleData\Context as SampleDataContext;

class SetCustomerApprovalAmount
{
    protected $fixtureManager;
    protected $csvReader;
    protected $customerFactory;

    public function __construct(
        SampleDataContext $sampleDataContext,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Framework\App\State $appState
    ) {
        try {
            $appState->setAreaCode('adminhtml');
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            // intentionally left empty
        }
        $this->fixtureManager = $sampleDataContext->getFixtureManager();
        $this->csvReader = $sampleDataContext->getCsvReader();
        $this->customerFactory=$customerFactory;
    }

    public function install(array $customerFixtures)
    {

        foreach ($customerFixtures as $fileName) {
            $fileName = $this->fixtureManager->getFixture($fileName);
            if (!file_exists($fileName)) {
                continue;
            }

            $rows = $this->csvReader->getData($fileName);
            $header = array_shift($rows);

            foreach ($rows as $row) {
                $customerArray[] = array_combine($header, $row);
            }
            foreach($customerArray as $customerData){
                $customer = $this->customerFactory->create();
                //$customer->setWebsiteId(1);
                $customer->loadByEmail($customerData['email']);
                $customerData = $customer->getDataModel();
                $customerData->setCustomAttribute('order_approval_amount',$customerData['order_approval_amount']);
                $customer->updateData($customerData);
                $customer->save();
                //$customer->setData('order_approval_amount',$customerData['order_approval_amount']);
                //$customer->save();
            }

            unset ($customerArray);
        }

    }
}