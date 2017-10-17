<?php
/**
 * Created by PhpStorm.
 * User: jbritts
 * Date: 10/19/16
 * Time: 10:40 AM
 */
namespace MagentoEse\B2bOrderApproval\Model;

class Customers
{

    /**
     * @var \Magento\Framework\Setup\SampleData\Context
     */
    protected $sampleDataContext;

    /**
     * @var \Magento\Framework\App\State
     */
    protected $appState;

    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    protected $customerRepository;


    /**
     * Customers constructor.
     * @param \Magento\Framework\Setup\SampleData\Context $sampleDataContext
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     * @param \Magento\Framework\App\State $appState
     */
    public function __construct(
        \Magento\Framework\Setup\SampleData\Context $sampleDataContext,
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
                throw new Exception('File not found: '.$fileName);
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
