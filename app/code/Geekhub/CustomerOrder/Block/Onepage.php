<?php
namespace Geekhub\CustomerOrder\Block;

class Onepage extends \Magento\Framework\View\Element\Template
{
    public function getJsLayout()
    {
        $this->jsLayout['components']['onepageScope']['children']['steps']['children']['customer-step']['config']['customersListUrl'] = $this->getUrl('geekhub/customer/getList');
        $this->jsLayout['components']['onepageScope']['children']['steps']['children']['product-step']['config']['productsListUrl'] = $this->getUrl('geekhub/product/getList');

        return json_encode($this->jsLayout, JSON_HEX_TAG);
    }
}
