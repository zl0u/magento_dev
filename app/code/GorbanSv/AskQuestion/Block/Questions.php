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
     * @return Collection
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getQuestions(): Collection
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        $collection->getSelect()->orderRand();

        if ($limit = $this->getData('limit')) {
            $collection->setPageSize($limit);
        }

        return $collection;
    }
}
