<?php
/**
 * Created by PhpStorm.
 * User: jbritts
 * Date: 11/10/16
 * Time: 10:22 AM
 */

namespace MagentoEse\B2bOrderApproval\Controller\OrderApproval;

class ApproveOrder extends \Magento\Framework\App\Action\Action
{

    /**
     * @var \Magento\Framework\App\Action\Context
     */
    protected $context;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Sales\Model\OrderFactory
     */
    protected $orderFactory;

    /**
     * ApproveOrder constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Sales\Model\OrderFactory $orderFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Sales\Model\OrderFactory $orderFactory

    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->orderFactory = $orderFactory;

    }

    public function execute()
    {
        $orderId = $this->getRequest()->getParam('order_id');
        $comments = $this->getRequest()->getParam('comments');
        $order = $this->orderFactory->create();
        $order->load($orderId);
        $order->setStatus('approved');
        $order->addStatusHistoryComment(__('Your order has been approved: ').$comments)->setIsVisibleOnFront(true)->setIsCustomerNotified();
        $order->save();
        $this->_redirect('sales/order/view/order_id/'.$orderId);
    }
}