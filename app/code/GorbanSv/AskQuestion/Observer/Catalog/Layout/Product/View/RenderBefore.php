<?php

namespace GorbanSv\AskQuestion\Observer\Catalog\Layout\Product\View;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Registry;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Customer\Model\Group as CustomerGroupCollection;
use GorbanSv\AskQuestion\Helper\Config\Data;

/**
 * Class RenderBefore
 * @package GorbanSv\AskQuestion\Observer\Catalog\Layout\Product\View
 */
class RenderBefore implements ObserverInterface
{
    /**
     * @var Data
     */
    private $helper;

    /**
     * @var Registry
     */
    private $registry;

    /**
     * @var CustomerSession
     */
    private $customerSession;

    /**
     * @var CustomerGroupCollection
     */
    private $customerGroupCollection;

    /**
     * RenderBefore constructor.
     * @param Registry $registry
     * @param Data $helper
     * @param CustomerSession $customerSession
     * @param CustomerGroupCollection $customerGroupCollection
     */
    public function __construct(
        Registry $registry,
        Data $helper,
        CustomerSession $customerSession,
        CustomerGroupCollection $customerGroupCollection
    ) {
        $this->registry = $registry;
        $this->helper = $helper;
        $this->customerSession = $customerSession;
        $this->customerGroupCollection = $customerGroupCollection;
    }

    /**
     * Get Customer Group
     * @return string
     */
    protected function getCustomerGroup()
    {
        $currentGroupId = $this->customerSession->getCustomer()->getGroupId();
        $collection = $this->customerGroupCollection->load($currentGroupId);
        $customerGroupCode = $collection->getCustomerGroupCode();
        return $customerGroupCode;
    }

    /**
     * @param Observer $observer
     * @return $this|void
     */
    public function execute(Observer $observer)
    {
        $product = $this->registry->registry('current_product');

        if (!$product) {
            return $this;
        }

        if (
            $this->helper->isEnabled() &&
            $product->getShowQuestionsForm() &&
            !$this->customerSession->getCustomer()->getDisallowAskQuestion() &&
            $this->getCustomerGroup() !== 'Forbidden for Ask Question'
        ) {
            $layout = $observer->getLayout();
            $layout->getUpdate()->addHandle('ask_question');
        }

        return $this;
    }
}
