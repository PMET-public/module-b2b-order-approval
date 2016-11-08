<?php


namespace MagentoEse\B2BOrderApproval\Observer\Sales;


class FlagOrderApproval implements \Magento\Framework\Event\ObserverInterface {
    protected $currentCustomer;
    protected $order;
    protected $_messageManager;

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


        $t=1;

    }
}