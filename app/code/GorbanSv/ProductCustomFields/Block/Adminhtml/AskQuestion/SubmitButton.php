<?php

namespace GorbanSv\ProductCustomFields\Block\Adminhtml\AskQuestion;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class SubmitButton
 * @package GorbanSv\ProductCustomFields\Block\Adminhtml\AskQuestion
 */
class SubmitButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Submit Form'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
    }
}
