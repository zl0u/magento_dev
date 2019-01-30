<?php

namespace GorbanSv\AskQuestion\Model;

use GorbanSv\AskQuestion\Model\ResourceModel\AskQuestion as AskQuestionResource;
use Magento\Framework\Model\AbstractModel;

/**
 * Class AskQuestion
 * @package GorbanSv\AskQuestion\Model
 *
 * @method int|string getQuestionId()
 * @method int|string getName()
 * @method AskQuestion setName(string $name)
 * @method string getEmail()
 * @method AskQuestion setEmail(string $email)
 * @method string getPhone()
 * @method AskQuestion setPhone(string $phone)
 * @method string getProductName()
 * @method AskQuestion setProductName(string $productName)
 * @method string getSku()
 * @method AskQuestion setSku(string $sku)
 * @method string getQuestion()
 * @method AskQuestion setQuestion(string $question)
 * @method string getCreatedAt()
 * @method string getStatus()
 * @method AskQuestion setStatus(string $status)
 * @method int|string getStoreId()
 * @method AskQuestion setStoreId(int $storeId)
 */
class AskQuestion extends AbstractModel
{
    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'ask_question';

    public const STATUS_PENDING = 'pending';
    public const STATUS_PROCESSED = 'processed';

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->storeManager = $storeManager;
    }

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(AskQuestionResource::class);
    }

    /**
     * @return \Magento\Framework\Model\AbstractModel
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function beforeSave()
    {
        if (!$this->getStatus()) {
            $this->setStatus(self::STATUS_PENDING);
        }

        if (!$this->getStoreId()) {
            $this->setStoreId($this->storeManager->getStore()->getId());
        }

        return parent::beforeSave();
    }
}
