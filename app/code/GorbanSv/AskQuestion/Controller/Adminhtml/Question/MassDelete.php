<?php

namespace GorbanSv\AskQuestion\Controller\Adminhtml\Question;

use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use GorbanSv\AskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\DB\Transaction;

/**
 * Class MassDelete
 * @package GorbanSv\AskQuestion\Controller\Adminhtml\Question
 */
class MassDelete extends \Magento\Backend\App\Action
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
     * MassDelete constructor.
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param \Magento\Framework\DB\TransactionFactory $transactionFactory
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
     * @return \Magento\Backend\Model\View\Result\Redirect|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();

        /** @var Transaction $transaction */
        $transaction = $this->transactionFactory->create();

        foreach ($collection as $item) {
            $transaction->addObject($item);
        }

        $transaction->delete();
        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $collectionSize));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('customer_questions/index/index');
    }
}
