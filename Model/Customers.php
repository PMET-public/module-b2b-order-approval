<?php
/**
 * Created by PhpStorm.
 * User: jbritts
 * Date: 10/19/16
 * Time: 10:40 AM
 */
namespace MagentoEse\B2bOrderApproval\Model;
use Magento\Framework\Setup\SampleData\Context as SampleDataContext;
class Customers
{
    protected $fixtureManager;
    protected $csvReader;
    protected $customerRepository;
    public function __construct(
        SampleDataContext $sampleDataContext,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Framework\App\State $appState
    ) {
        try {
            $appState->setAreaCode('adminhtml');
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            // intentionally left empty
        }
        $this->fixtureManager = $sampleDataContext->getFixtureManager();
        $this->csvReader = $sampleDataContext->getCsvReader();
        $this->customerRepository=$customerRepository;
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
                $customer = $this->customerRepository->get($customerData['email']);
                $customer->setCustomAttribute('order_approval_amount',$customerData['order_approval_amount']);
                $this->customerRepository->save($customer);
            }
            unset ($customerArray);
        }
    }
}
