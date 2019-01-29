<?php

namespace GorbanSv\ProductCustomFields\Ui\Component\Form;

use Magento\Catalog\Ui\DataProvider\Product\Form\ProductDataProvider;

/**
 * Class DataProvider
 * @package GorbanSv\ProductCustomFields\Ui\Component\Form
 */
class DataProvider extends ProductDataProvider
{
    /**
     * Get Meta
     * @return array
     */
    public function getMeta() : array
    {
        $meta = parent::getMeta();
        $meta['content']['children']['custom_field'] = [
            'arguments' => [
                'data' => [
                    'config' => [
                        'componentType' => 'field',
                        'formElement'   => 'input',
                        'label'         => __('Custom Field'),
                        'dataType'      => 'text',
                        'sortOrder'     => 45,
                        'dataScope'     => 'custom_field',
                    ]
                ]
            ],
        ];
        return $meta;
    }
}
