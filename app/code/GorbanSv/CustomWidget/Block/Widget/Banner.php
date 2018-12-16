<?php

namespace GorbanSv\CustomWidget\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class Banner extends Template implements BlockInterface
{
    /**
     * @var string
     */
    protected $_template = "widget/banner.phtml";
}
