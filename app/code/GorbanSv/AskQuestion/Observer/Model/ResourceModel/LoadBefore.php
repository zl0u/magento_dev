<?php

namespace GorbanSv\AskQuestion\Observer\Model\ResourceModel;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class LoadBefore
 * @package GorbanSv\AskQuestion\Observer\Model\ResourceModel
 */
class LoadBefore implements ObserverInterface
{
    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $data = $observer->getEvent()->getData();
    }
}
