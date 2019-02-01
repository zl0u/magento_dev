<?php

namespace GorbanSv\ModuleOop\Block;

use Magento\Framework\View\Element\Template;
use GorbanSv\ModuleOop\Model\DirContents;
use GorbanSv\ModuleOop\Model\Reflection;
use GorbanSv\ModuleOop\Model\DiParams;

/**
 * Class OopBlock
 * @package GorbanSv\ModuleOop\Block
 */
class OopBlock extends \Magento\Framework\View\Element\Template
{
    /**
     * @var DirContents
     */
    private $dirContents;

    /**
     * @var Reflection
     */
    private $reflection;

    /**
     * @var DiParams
     */
    private $diParams;

    /**
     * OopBlock constructor.
     * @param Template\Context $context
     * @param DirContents $dirContents
     * @param Reflection $reflection
     * @param DiParams $diParams
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        DirContents $dirContents,
        Reflection $reflection,
        DiParams $diParams,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->dirContents = $dirContents;
        $this->reflection = $reflection;
        $this->diParams = $diParams;
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function getDirContents() : array
    {
        return $this->dirContents->getDirContents(true);
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public function getConstants() : array
    {
        return $this->reflection->getConstants();
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public function getMethods() : array
    {
        return $this->reflection->getMethods();
    }

    /**
     * @return array
     */
    public function getDiParams() : array
    {
        return $this->diParams->getParams();
    }
}
