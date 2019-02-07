<?php

namespace GorbanSv\AskQuestion\Observer\Model\ResourceModel;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Registry;

/**
 * Class LoadBefore
 * @package GorbanSv\AskQuestion\Observer\Model\ResourceModel
 */
class LoadBefore implements ObserverInterface
{
    /**
     * @var Registry 
     */
    private $registry;

    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $observer->getEvent()
                 ->getData('ask_question_collection_object')
                 ->addFieldToFilter('sku', $this->registry->registry('product')->getSku());
    }
}
