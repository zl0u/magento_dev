<?php

namespace GorbanSv\AskQuestion\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;

/**
 * Class Index
 * @package GorbanSv\AskQuestion\Controller\Adminhtml\Index
 */
class Index extends \Magento\Backend\App\Action
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
