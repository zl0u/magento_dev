<?php

namespace GorbanSv\CustomModule\Controller\JsonResponse;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @return ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $controllerResult */
        $controllerResult = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $data = ['content' => "JsonResponse"];
        return $controllerResult->setData($data);
    }
}
