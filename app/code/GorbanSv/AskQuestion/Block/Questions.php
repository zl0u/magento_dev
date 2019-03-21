<?php

namespace GorbanSv\AskQuestion\Block;

use GorbanSv\AskQuestion\Model\ResourceModel\AskQuestion\Collection;

/**
 * Class Questions
 * @package GorbanSv\AskQuestion\Block
 */
class Questions extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \GorbanSv\AskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory
     */
    private $collectionFactory;

    /**
     * Questions constructor.
     * @param \GorbanSv\AskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory $collectionFactory
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \GorbanSv\AskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory $collectionFactory,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
        $this->productRepository = $productRepository;
    }

    /**
     * @param null $limit
     * @param null $order
     * @return Collection
     */
    public function getQuestions($limit = null, $order = null): Collection
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();

        if ($order)
        {
            $collection->getSelect()->order($order);
        }
        else
        {
            $collection->getSelect()->orderRand();
        }

        if ($limit = $limit ? $limit : $this->getData('limit'))
        {
            $collection->setPageSize($limit);
        }

        return $collection;
    }
}
