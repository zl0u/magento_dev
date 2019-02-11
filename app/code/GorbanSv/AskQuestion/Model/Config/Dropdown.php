<?php

namespace GorbanSv\AskQuestion\Model\Config;

/**
 * Class Dropdown
 * @package GorbanSv\AskQuestion\Model\Config
 */
class Dropdown implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray() : array
    {
        return [
            ['value' => 0, 'label' => __('First')],
            ['value' => 1, 'label' => __('Second')],
            ['value' => 2, 'label' => __('Third')],
            ['value' => 3, 'label' => __('Fourth')]
        ];
    }
}
