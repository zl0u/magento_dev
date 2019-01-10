<?php
namespace GorbanSv\CustomWidget\Plugin;

use Magento\Framework\Data\Tree\NodeFactory;

/**
 * Class Topmenu
 * @package GorbanSv\CustomWidget\Plugin
 */
class Topmenu
{
    private $nodeFactory;
    private $storeManager;
    private $pageFactory;
    private $urlBuilder;

    /**
     * Topmenu constructor.
     * @param NodeFactory $nodeFactory
     * @param \Magento\Cms\Model\PageFactory $pageFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\UrlInterface $urlBuilder
     */
    public function __construct(
        NodeFactory $nodeFactory,
        \Magento\Cms\Model\PageFactory $pageFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\UrlInterface $urlBuilder
    ) {
        $this->nodeFactory = $nodeFactory;
        $this->pageFactory = $pageFactory;
        $this->storeManager = $storeManager;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @param \Magento\Theme\Block\Html\Topmenu $subject
     */
    public function beforeGetHtml(
        \Magento\Theme\Block\Html\Topmenu $subject
    ) {
        /* Showing  Cms page GeekHub CMS at menu */
        $page = $this->getCmsPage('geekhub-cms');
        if ($page == null) {
            return;
        }

        $node = $this->nodeFactory->create(
            [
                'data' => [
                    'name' => $page->getTitle(),
                    'id' => $page->getIdentifier(),
                    'url' =>  $this->urlBuilder->getUrl(null, ['_direct' => $page->getIdentifier()]),
                    'has_active' => false,
                    'is_active' => false // (expression to determine if menu item is selected or not)
                ],
                'idField' => 'id',
                'tree' => $subject->getMenu()->getTree()
            ]
        );
        $subject->getMenu()->addChild($node);
    }

    /**
     * @param $identifier
     * @return \Magento\Cms\Model\Page|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getCmsPage($identifier)
    {
        $page = $this->pageFactory->create();
        $pageId = $page->checkIdentifier($identifier, $this->storeManager->getStore()->getId());

        if (!$pageId) {
            return null;
        }

        $page->setStoreId($this->storeManager->getStore()->getId());

        if (!$page->load($pageId)) {
            return null;
        }

        if (!$page->getId()) {
            return null;
        }

        return $page;
    }
}
