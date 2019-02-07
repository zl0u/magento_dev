<?php

namespace GorbanSv\AskQuestion\Observer\Model\ResourceModel;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use GorbanSv\AskQuestion\Model\ResourceModel\AskQuestion\Collection as AskQuestionCollection;

/**
 * Class LoadBefore
 * @package GorbanSv\AskQuestion\Observer\Model\ResourceModel
 */
class LoadBefore implements ObserverInterface
{
    private $askQuestionCollection;

    public function __construct(AskQuestionCollection $askQuestionCollection)
    {
        $this->askQuestionCollection = $askQuestionCollection;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $this->askQuestionCollection->addStoreFilter(2);
    }
}
