<?php


namespace MagentoEse\B2bOrderApproval\Observer\Sales;


class FlagOrderApproval implements \Magento\Framework\Event\ObserverInterface {

    /**
     * @var \Magento\Customer\Helper\Session\CurrentCustomer
     */
    protected $currentCustomer;

    /**
     * @var \Magento\Sales\Model\OrderFactory
     */
    protected $order;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * FlagOrderApproval constructor.
     * @param \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer
     * @param \Magento\Sales\Model\OrderFactory $order
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     */
    public function __construct(
        \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer,
        \Magento\Sales\Model\OrderFactory $order,
        \Magento\Framework\Message\ManagerInterface $messageManager){

        $this->currentCustomer = $currentCustomer;
        $this->order = $order;
        $this->messageManager = $messageManager;
    }

    public function execute(
        \Magento\Framework\Event\Observer $observer
    ){
        //get current customer
        $customer = $this->currentCustomer->getCustomer();
        //if customer has approval threshold, get order
        if($approvalAmount = $customer->getCustomAttribute('order_approval_amount')) {
            $approvalAmount = $customer->getCustomAttribute('order_approval_amount')->getValue();
            if ($approvalAmount >= 0) {
                $currentOrder = $this->order->create();
                $currentOrder->load($observer->getData('order_ids'));
                $orderTotal = $currentOrder->getTotalDue();
                //is order larger than approval amount
                if ($orderTotal > $approvalAmount) {
                    //set status to pending approval
                    $currentOrder->setStatus('needs_approval');
                    $currentOrder->save();
                    //set message for user
                    $this->messageManager->addNotice(__('This order requires approval. Status has been set to Pending Approval'));
                }
            }
        }
    }
}