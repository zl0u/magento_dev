<?php
namespace GorbanSv\ProductCustomFields\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Ui\Component\Form\Fieldset;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\Component\Form\Element\Select;
use Magento\Ui\Component\Form\Element\DataType\Text;

class NewField extends AbstractModifier
{
    private $locator;
    public function __construct(
        LocatorInterface $locator
    ) {
        $this->locator = $locator;
    }
    public function modifyData(array $data)
    {
        return $data;
    }
    public function modifyMeta(array $meta)
    {
        $meta = array_replace_recursive(
            $meta,
            [
                'custom_fieldset' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'label' => __('Custom Fieldset'),
                                'componentType' => Fieldset::NAME,
                                'dataScope' => 'data.product.custom_fieldset',
                                'collapsible' => true,
                                'sortOrder' => 5,
                            ],
                        ],

                    ],
                    'children' => [
                        'custom_select_field' => $this->getCustomSelectField(),
                        'custom_text_field' => $this->getCustomTextField()
                    ],
                ]
            ]
        );
        return $meta;
    }
    public function getCustomSelectField()
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Custom Select Field'),
                        'componentType' => Field::NAME,
                        'formElement' => Select::NAME,
                        'dataScope' => 'enabled',
                        'dataType' => Text::NAME,
                        'sortOrder' => 10,
                        'options' => [
                            ['value' => '0', 'label' => __('No')],
                            ['value' => '1', 'label' => __('Yes')]
                        ],
                    ],
                ],
            ],
        ];
    }
    public function getCustomTextField()
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Custom Text Field'),
                        'componentType' => Field::NAME,
                        'formElement' => \Magento\Ui\Component\Form\Element\Input::NAME,
                        'dataScope' => 'enabled',
                        'dataType' => Text::NAME,
                        'sortOrder' => 20,
                    ],
                ],
            ],
        ];
    }
}
