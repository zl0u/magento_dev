<?php

namespace GorbanSv\ProductCustomFields\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;

/**
 * Class Index
 * @package GorbanSv\ProductCustomFields\Controller\Adminhtml\Index
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
