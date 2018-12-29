<?php

namespace GorbanSv\ProductCustomFields\Ui\Component\Form;

use Magento\Cron\Model\ResourceModel\Schedule\CollectionFactory;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Magento\Cron\Model\ResourceModel\Schedule\Collection
     */
    protected $collection;
    /**
     * @var array
     */
    protected $loadedData;
    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $blockCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $blockCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $blockCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        return [];
    }
    public function getMeta()
    {
        $meta = parent::getMeta();
        $meta['general']['children']['custom_field'] = [
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