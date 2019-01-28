<?php

namespace GorbanSv\AskQuestion\Observer\Model;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class SaveBefore
 * @package GorbanSv\AskQuestion\Observer\Model
 */
class SaveBefore implements ObserverInterface
{
    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $data = $observer->getEvent()->getData();
    }
}
