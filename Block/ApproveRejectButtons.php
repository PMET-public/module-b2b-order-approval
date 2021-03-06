<?php
namespace MagentoEse\B2bOrderApproval\Block;

class ApproveRejectButtons extends \Magento\Framework\View\Element\Template
{

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var \Magento\Framework\View\Element\Template\Context
     */
    protected $context;

    /**
     * @var \Magento\Framework\App\Http\Context
     */
    protected $httpContext;

    /**
     * @var \Magento\Customer\Helper\Session\CurrentCustomer
     */
    protected $currentCustomer;

    /**
     * @var \Magento\Company\Model\Customer\CompanyAttributes
     */
    protected $companyAttributes;

    /** @var  \Magento\Company\Api\CompanyRepositoryInterfaceFactory */
    protected $companyRepository;

    /**
     * ApproveRejectButtons constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\App\Http\Context $httpContext
     * @param array $data
     * @param \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer
     * @param \Magento\Company\Model\Customer\CompanyAttributes $companyAttributes
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Http\Context $httpContext,
        array $data = [],
        \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer,
        \Magento\Company\Model\Customer\CompanyAttributes $companyAttributes,
        \Magento\Company\Api\CompanyRepositoryInterface $companyRepository
    ) {
        $this->coreRegistry = $registry;
        $this->httpContext = $httpContext;
        parent::__construct($context, $data);
        $this->_isScopePrivate = true;
        $this->currentCustomer = $currentCustomer;
        $this->companyAttributes = $companyAttributes;
        $this->companyRepository = $companyRepository;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->coreRegistry->registry('current_order');
    }

    /**
     * @return \Magento\Customer\Api\Data\CustomerInterface
     */
    public function getCustomer(){
        return  $this->currentCustomer->getCustomer();
    }

    /**
     * @return bool
     */
    public function needsApproval(){
        $orderStatus = $this->getOrder()->getStatus();
        if ($orderStatus=='needs_approval'){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @return bool
     */
    public function isApprover(){

        $userId  = $this->companyAttributes->getCompanyAttributesByCustomer($this->getCustomer())->getCompanyId();
        $company = $this->companyRepository->get($this->companyAttributes->getCompanyAttributesByCustomer($this->getCustomer())->getCompanyId());
        $superUserId = $company->getSuperUserId();
        if($this->getCustomer()->getId() == $superUserId){
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $order
     * @return string
     */
    public function getApprovalUrl($order)
    {
        return $this->getUrl('approval/OrderApproval/ApproveOrder', ['order_id' => $order->getId()]);
    }
    public function getRejectionUrl($order)
    {
        return $this->getUrl('approval/OrderApproval/RejectOrder', ['order_id' => $order->getId()]);
    }

}