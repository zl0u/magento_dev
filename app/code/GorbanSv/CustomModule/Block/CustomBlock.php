<?php

namespace GorbanSv\CustomModule\Block;

class CustomBlock extends \Magento\Framework\View\Element\Template
{
    /**
     * get JsonResponse Url
     */
    public function getJsonResponseUrl()
    {
        return $this->getUrl('home_work/jsonresponse/index');
    }
}
