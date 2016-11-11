<?php
namespace MagentoEse\B2BOrderApproval\Block;

class ApproveRejectButtons extends \Magento\Framework\View\Element\Template
{

    protected $registry;
    protected $context;
    protected $httpContext;
    protected $currentCustomer;
    protected $companyAttributes;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Http\Context $httpContext,
        array $data = [],
        \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer,
        \Magento\Company\Model\Customer\CompanyAttributes $companyAttributes
    ) {
        $this->coreRegistry = $registry;
        $this->httpContext = $httpContext;
        parent::__construct($context, $data);
        $this->_isScopePrivate = true;
        $this->currentCustomer = $currentCustomer;
        $this->companyAttributes = $companyAttributes;
    }

    public function getOrder()
    {
        return $this->coreRegistry->registry('current_order');
    }
    public function getCustomer(){
        return  $this->currentCustomer->getCustomer();
    }
    public function needsApproval(){
        $orderStatus = $this->getOrder()->getStatus();
        if ($orderStatus=='needs_approval'){
            return true;
        }else{
            return false;
        }
    }
    public function isApprover(){
        if($this->companyAttributes->getCompanyAttributesByCustomer($this->getCustomer())->getIsSuperUser()){
            return true;
        } else {
            return false;
        }

    }
    public function getApprovalUrl($order)
    {
        return $this->getUrl('approval/OrderApproval/ApproveOrder', ['order_id' => $order->getId()]);
    }
    public function getRejectionUrl($order)
    {
        return $this->getUrl('approval/OrderApproval/RejectOrder', ['order_id' => $order->getId()]);
    }

}