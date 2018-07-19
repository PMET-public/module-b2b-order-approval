<?php
/**
 * Created by PhpStorm.
 * User: jbritts
 * Date: 11/10/16
 * Time: 10:22 AM
 */

namespace MagentoEse\B2bOrderApproval\Controller\OrderApproval;

use MagentoEse\B2bOrderApproval\Model\ProcessApproval;

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
     * @var ProcessApproval
     */

    protected $ProcessApproval;

     /**
     * ApproveOrder constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        ProcessApproval $processApproval

    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->processApproval = $processApproval;

    }

    public function execute()
    {
        $orderId = $this->getRequest()->getParam('order_id');
        $comments = $this->getRequest()->getParam('comments');
        $this->processApproval->approve($orderId,$comments);
        $this->_redirect('sales/order/view/order_id/'.$orderId);
    }
}