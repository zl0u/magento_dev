<?php

namespace GorbanSv\CustomWidget\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

/**
 * Class Banner
 * @package GorbanSv\CustomWidget\Block\Widget
 */
class Banner extends Template implements BlockInterface
{
    /**
     * @var string
     */
    protected $_template = "widget/banner.phtml";

    /**
     * @var \Magento\Cms\Model\BlockRepository
     */
    private $staticBlockRepository;

    /**
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
    private $filterProvider;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * Banner constructor.
     * @param Template\Context $context
     * @param \Magento\Cms\Model\BlockRepository $staticBlockRepository
     * @param \Magento\Cms\Model\Template\FilterProvider $filterProvider
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Cms\Model\BlockRepository $staticBlockRepository,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        array $data = []
    ) {
        $this->staticBlockRepository = $staticBlockRepository;
        $this->filterProvider = $filterProvider;
        $this->storeManager = $context->getStoreManager();
        $this->logger = $context->getLogger();

        parent::__construct($context, $data);
    }

    /**
     * @return bool|\Magento\Cms\Model\Block
     */
    public function getStaticBlock()
    {
        try {
            return $this->staticBlockRepository->getById($this->getCmsBlock());
        } catch (\Exception $e) {
            $this->logger->warning($e->getMessage());
        }

        return false;
    }

    /**
     * @return \Magento\Framework\Phrase
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getStaticContent()
    {
        $staticBlock = $this->getStaticBlock();

        if ($staticBlock && $staticBlock->isActive()) {
            return $this->filterProvider
                        ->getBlockFilter()
                        ->setStoreId($this->storeManager->getStore()->getId())
                        ->filter($staticBlock->getContent());
        }

        return __('Static block content not found');
    }
}
