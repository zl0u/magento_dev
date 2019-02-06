<?php

namespace GorbanSv\AskQuestion\Controller\Adminhtml\Question;

use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use GorbanSv\AskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\DB\Transaction;

/**
 * Class MassStatus
 * @package GorbanSv\AskQuestion\Controller\Adminhtml\Question
 */
class MassStatus extends \Magento\Backend\App\Action
{
    /**
     * @var Filter
     */
    private $filter;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var \Magento\Framework\DB\TransactionFactory
     */
    private $transactionFactory;

    /**
     * MassStatus constructor.
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        \Magento\Framework\DB\TransactionFactory $transactionFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->transactionFactory = $transactionFactory;
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $statusValue = $this->getRequest()->getParam('status');
        $collection = $this->filter->getCollection($this->collectionFactory->create());

        /** @var Transaction $transaction */
        $transaction = $this->transactionFactory->create();

        foreach ($collection as $item) {
            $item->setStatus($statusValue);
            $transaction->addObject($item);
        }

        $transaction->save();
        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been modified.', $collection->getSize()));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('customer_questions/index/index');
    }
}
