<?php
namespace GorbanSv\CustomWidget\Plugin;

use Magento\Framework\Data\Tree\NodeFactory;

class Topmenu
{
    protected $nodeFactory;
    protected $_storeManager;
    protected $_pageFactory;
    protected $_urlBuilder;

    public function __construct(
        NodeFactory $nodeFactory,
        \Magento\Cms\Model\PageFactory $pageFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\UrlInterface $urlBuilder
    ) {
        $this->nodeFactory = $nodeFactory;
        $this->_pageFactory = $pageFactory;
        $this->_storeManager = $storeManager;
        $this->_urlBuilder = $urlBuilder;
    }

    public function beforeGetHtml(
        \Magento\Theme\Block\Html\Topmenu $subject,
        $outermostClass = '',
        $childrenWrapClass = '',
        $limit = 0
    ) {
        /* Showing  Cms page GeekHub CMS at menu */
        $page = $this->getCmspage('geekhub-cms');
        if($page == null){
            return;
        }


        $node = $this->nodeFactory->create(
            [
                'data' => [
                    'name' => $page->getTitle(),
                    'id' => $page->getIdentifier(),
                    'url' =>  $this->_urlBuilder->getUrl(null, ['_direct' => $page->getIdentifier()]),
                    'has_active' => false,
                    'is_active' => false // (expression to determine if menu item is selected or not)
                ],
                'idField' => 'id',
                'tree' => $subject->getMenu()->getTree()
            ]
        );
        $subject->getMenu()->addChild($node);
    }
    
    protected function getCmspage($identifier){

        $page = $this->_pageFactory->create();
        $pageId = $page->checkIdentifier($identifier, $this->_storeManager->getStore()->getId());

        if (!$pageId) {
            return null;
        }
        $page->setStoreId($this->_storeManager->getStore()->getId());
        if (!$page->load($pageId)) {
            return null;
        }

        if (!$page->getId()) {
            return null;
        }

        return $page;
    }

}
