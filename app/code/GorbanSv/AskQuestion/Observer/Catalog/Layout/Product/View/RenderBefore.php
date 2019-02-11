<?php

namespace GorbanSv\AskQuestion\Observer\Catalog\Layout\Product\View;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Registry;
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
     * RenderBefore constructor.
     * @param Registry $registry
     */
    public function __construct(
        Registry $registry,
        Data $helper
    ) {
        $this->registry = $registry;
        $this->helper = $helper;
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

        if ($this->helper->isEnabled() && $product->getShowQuestionsForm()) {
            $layout = $observer->getLayout();
            $layout->getUpdate()->addHandle('ask_question');
        }

        return $this;
    }
}
