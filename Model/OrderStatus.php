<?php

namespace MagentoEse\B2bOrderApproval\Model;




class OrderStatus
{
    /**
     * @var \Magento\Sales\Model\Order\StatusFactory
     */
    protected $statusFactory;

    /**
     * OrderStatus constructor.
     * @param \Magento\Sales\Model\Order\StatusFactory $statusFactory
     */
    public function __construct(\Magento\Sales\Model\Order\StatusFactory $statusFactory)
    {
        $this->statusFactory = $statusFactory;
    }

    public function install(){
        $status = $this->statusFactory->create();
        $status->setStatus('needs_approval')->setLabel('Pending Approval');
        $status->save();
        $status->assignState('processing',false,true);
        $status->save();

        $status = $this->statusFactory->create();
        $status->setStatus('approved')->setLabel('Approved');
        $status->save();
        $status->assignState('processing',false,true);
        $status->save();

        $status = $this->statusFactory->create();
        $status->setStatus('rejected')->setLabel('Rejected');
        $status->save();
        $status->assignState('canceled',false,true);
        $status->save();


    }

}
