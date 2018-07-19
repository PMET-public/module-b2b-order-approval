<?php
/**
 * Created by PhpStorm.
 * User: jbritts
 * Date: 11/10/16
 * Time: 10:22 AM
 */

namespace MagentoEse\B2bOrderApproval\Model;

class ProcessApproval 
{

       /**
     * @var \Magento\Sales\Model\OrderFactory
     */
    protected $orderFactory;

    /**
     * ApproveOrder constructor.
     * @param \Magento\Sales\Model\OrderFactory $orderFactory
     */
    public function __construct(
        \Magento\Sales\Model\OrderFactory $orderFactory

    ) {
        $this->orderFactory = $orderFactory;

    }

    public function approve($orderId, $comments)
    {
        $order = $this->orderFactory->create();
        $order->load($orderId);
        $order->setStatus('approved');
        $order->addStatusHistoryComment(__('Your order has been approved: ').$comments)->setIsVisibleOnFront(true)->setIsCustomerNotified();
        $order->save();
    }

    public function reject($orderId, $comments)
    {
        $order = $this->orderFactory->create();
        $order->load($orderId);
        $order->setStatus('rejected');
        $order->setState('canceled');
        $order->addStatusHistoryComment(__('Your order has been rejected: ').$comments)->setIsVisibleOnFront(true)->setIsCustomerNotified();
        $order->save();
    }
}