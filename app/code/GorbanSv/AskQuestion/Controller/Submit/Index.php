<?php
namespace GorbanSv\AskQuestion\Controller\Submit;

use GorbanSv\AskQuestion\Model\AskQuestion;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Index
 * @package GorbanSv\AskQuestion\Controller\Submit
 */
class Index extends \Magento\Framework\App\Action\Action
{
    const STATUS_ERROR = 'Error';
    const STATUS_SUCCESS = 'Success';

    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    private $formKeyValidator;

    /**
     * @var \GorbanSv\AskQuestion\Model\AskQuestionFactory
     */
    private $askQuestionFactory;

    /**
     * Index constructor.
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \GorbanSv\AskQuestion\Model\AskQuestionFactory $askQuestionFactory
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \GorbanSv\AskQuestion\Model\AskQuestionFactory $askQuestionFactory,
        \Magento\Framework\App\Action\Context $context
    ) {
        parent::__construct($context);
        $this->formKeyValidator = $formKeyValidator;
        $this->askQuestionFactory = $askQuestionFactory;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     * @throws \Exception
     */
    public function execute()
    {
        /** @var Http $request */
        $request = $this->getRequest();

        try {
            if (!$this->formKeyValidator->validate($request) || $request->getParam('hideit')) {
                throw new LocalizedException(__('Something went wrong. Probably you were away for quite a long time already. Please, reload the page and try again.'));
            }

            if (!$request->isAjax()) {
                throw new LocalizedException(__('This request is not valid and can not be processed.'));
            }

            /** @var AskQuestion $askQuestion */
            $askQuestion = $this->askQuestionFactory->create();

            $askQuestion->setName($request->getParam('name'))
                        ->setEmail($request->getParam('email'))
                        ->setPhone($request->getParam('phone'))
                        ->setProductName($request->getParam('product_name'))
                        ->setSku($request->getParam('sku'))
                        ->setQuestion($request->getParam('question'));

            $askQuestion->save();

            $data = [
                'status' => self::STATUS_SUCCESS,
                'message' => 'Thank you! Your question was submitted.'
            ];
        } catch (LocalizedException $e) {
            $data = [
                'status'  => self::STATUS_ERROR,
                'message' => $e->getMessage()
            ];
        }

        /**
         * @var \Magento\Framework\Controller\Result\Json $controllerResult
         */
        $controllerResult = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        return $controllerResult->setData($data);
    }
}
