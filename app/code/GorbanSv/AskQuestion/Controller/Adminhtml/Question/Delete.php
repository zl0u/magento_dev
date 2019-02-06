<?php

namespace GorbanSv\AskQuestion\Controller\Adminhtml\Question;

use Magento\Backend\App\Action;

/**
 * Class Delete
 * @package GorbanSv\AskQuestion\Controller\Adminhtml\Question
 */
class Delete extends Action
{
    /**
     * @var \GorbanSv\AskQuestion\Model\AskQuestion
     */
    private $model;

    /**
     * @param Action\Context $context
     * @param \GorbanSv\AskQuestion\Model\AskQuestion $model
     */
    public function __construct(
        Action\Context $context,
        \GorbanSv\AskQuestion\Model\AskQuestion $model
    ) {
        parent::__construct($context);
        $this->model = $model;
    }

    /**
     * Delete action
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id) {
            try {
                $model = $this->model;
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccessMessage(__('Question deleted'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }

            return $resultRedirect->setPath('*/index/index');
        }

        $this->messageManager->addErrorMessage(__('Question does not exist'));
        return $resultRedirect->setPath('*/index/index');
    }
}
