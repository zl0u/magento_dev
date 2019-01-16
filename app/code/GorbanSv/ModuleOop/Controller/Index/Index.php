<?php

namespace GorbanSv\ModuleOop\Controller\Index;

use Magento\Framework\Controller\ResultFactory;

/**
 * Class Index
 * @package GorbanSv\ModuleOop\Controller\Index
 */
class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        return $resultPage;
    }
}
