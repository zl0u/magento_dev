<?php

namespace GorbanSv\AskQuestion\Observer\Model;

use Psr\Log\LoggerInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class SaveBefore
 * @package GorbanSv\AskQuestion\Observer\Model
 */
class SaveBefore implements ObserverInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * SaveBefore constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $data = $observer->getEvent()->getObject()->getData();
        $this->logger->info('Customer "'.$data['name'].'" sent a question for product with SKU "'.$data['sku'].'"');
    }
}
