<?php

namespace GorbanSv\ProductCustomFields\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'label' => __('Pending'),
                'value' => 0,
            ],
            [
                'label' => __('Solved'),
                'value' => 1,
            ],
            [
                'label' => __('Unsolved'),
                'value' => 2,
            ],

        ];
    }
}