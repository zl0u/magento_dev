<?php

namespace GorbanSv\AskQuestion\Controller\Customer;

class Questions extends \Magento\Framework\App\Action\Action
{
    public function __construct(\Magento\Framework\App\Action\Context $context) {
        parent::__construct($context);
    }

    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->getPage()->getConfig()->getTitle()->set(__('My Questions'));
        $this->_view->renderLayout();
    }
}
