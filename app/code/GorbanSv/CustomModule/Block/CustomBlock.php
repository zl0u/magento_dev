<?php

namespace GorbanSv\CustomModule\Block;

class CustomBlock extends \Magento\Framework\View\Element\Template
{
    const CUSTOM_BLOCK_TEMPLATE = "GorbanSv_CustomModule::custom_module/myhomework.phtml";

    /**
     * add custom template
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->setTemplate(self::CUSTOM_BLOCK_TEMPLATE);

        return $this;
    }

    /**
     * get JsonResponse Url
     */
    public function getJsonResponseUrl()
    {
        return $this->getUrl('home_work/jsonresponse/index');
    }
}
