<?php

namespace GorbanSv\AskQuestion\Cron;

use Psr\Log\LoggerInterface;
use GorbanSv\AskQuestion\Model\AskQuestion;
use GorbanSv\AskQuestion\Model\ResourceModel\AskQuestion\Collection;
use GorbanSv\AskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory;
use Magento\Framework\DB\Transaction;
use Magento\Framework\DB\TransactionFactory;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

/**
 * Class ChangeStatus
 * @package GorbanSv\AskQuestion\Cron
 */
class ChangeStatus
{
    /**
     * @var int
     */
    private $days = 3;
    /**
     * @var TimezoneInterface
     */
    private $timezone;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var TransactionFactory
     */
    private $transactionFactory;
    /**
     * ChangeStatus constructor.
     * @param LoggerInterface $logger
     * @param CollectionFactory $collectionFactory
     * @param TransactionFactory $transactionFactory
     * @param TimezoneInterface $timezone
     */
    public function __construct(
        LoggerInterface $logger,
        CollectionFactory $collectionFactory,
        TransactionFactory $transactionFactory,
        TimezoneInterface $timezone
    ) {
        $this->logger = $logger;
        $this->collectionFactory = $collectionFactory;
        $this->transactionFactory = $transactionFactory;
        $this->timezone = $timezone;
    }

    /**
     * @throws \Exception
     */
    public function execute()
    {
        $statusChangeDate = $this->timezone->date()
            ->sub(new \DateInterval('P'.$this->days.'D'))
            ->format('Y-m-d H:i:s');
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('created_at', ['lteq' => $statusChangeDate])
                   ->addFieldToFilter('status', AskQuestion::STATUS_PENDING)
                   ->getSelect();
        /** @var Transaction $transaction */
        $transaction = $this->transactionFactory->create();
        foreach ($collection as $item) {
            $item->setStatus(AskQuestion::STATUS_PROCESSED);
            $transaction->addObject($item);
        }
        $transaction->save();
        $this->logger->info('Cron job for change question status is implemented! Changed - ' . count($collection));
    }
}
