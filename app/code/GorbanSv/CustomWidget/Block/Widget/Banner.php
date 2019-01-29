<?php

namespace GorbanSv\CustomWidget\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

/**
 * Class Banner
 * @package GorbanSv\CustomWidget\Block\Widget
 */
class Banner extends Template implements BlockInterface
{
    /**
     * @var string
     */
    protected $_template = "widget/banner.phtml";

    /**
     * @return |null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCmsBlockHtml()
    {
        $cmsBlock = null;
        if ($this->getData('cms_block')) {
            $cmsBlock = $this->getLayout()
                             ->createBlock('Magento\Cms\Block\Block')
                             ->setBlockId($this->getData('cms_block'))
                             ->toHtml();
        }
        return $cmsBlock;
    }
}
