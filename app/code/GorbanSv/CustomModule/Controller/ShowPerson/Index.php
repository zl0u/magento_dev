<?php

namespace GorbanSv\CustomModule\Controller\ShowPerson;

use Magento\Framework\Controller\ResultFactory;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage ->addHandle('custom_handle');

        $resultPage->getLayout()->getBlock('gorbansv.custom.block')->setName('Sergey');
        $resultPage->getLayout()->getBlock('gorbansv.custom.block')->setLastname('Gorban');

        return $resultPage;
    }
}
