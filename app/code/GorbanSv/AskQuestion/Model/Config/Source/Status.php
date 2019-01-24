<?php

namespace GorbanSv\AskQuestion\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use GorbanSv\AskQuestion\Model\AskQuestion;

/**
 * Class Status
 * @package GorbanSv\AskQuestion\Model\Config\Source
 */
class Status implements OptionSourceInterface
{
    /**
     * Get options
     * @return array
     */
    public function toOptionArray() : array
    {
        return [
            [
                'label' => __('Pending'),
                'value' => AskQuestion::STATUS_PENDING,
            ],
            [
                'label' => __('Answered'),
                'value' => AskQuestion::STATUS_PROCESSED,
            ],
        ];
    }
}
