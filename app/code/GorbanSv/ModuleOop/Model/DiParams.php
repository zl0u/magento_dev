<?php

namespace GorbanSv\ModuleOop\Model;

/**
 * Class DiParams
 * @package GorbanSv\ModuleOop\Model
 */
class DiParams
{
    private $stringParam;
    private $instanceParam;
    private $boolParam;
    private $intParam;
    private $globalInitParam;
    private $constantParam;
    private $optionalParam;
    private $arrayParam;

    /**
     * DiParams constructor.
     * @param $stringParam
     * @param $instanceParam
     * @param $boolParam
     * @param $intParam
     * @param $globalInitParam
     * @param $constantParam
     * @param $optionalParam
     * @param $arrayParam
     */
    public function __construct(
        $stringParam,
        $instanceParam,
        $boolParam,
        $intParam,
        $globalInitParam,
        $constantParam,
        $optionalParam,
        $arrayParam
    ) {
        $this->stringParam = $stringParam;
        $this->instanceParam = $instanceParam;
        $this->boolParam = $boolParam;
        $this->intParam = $intParam;
        $this->globalInitParam = $globalInitParam;
        $this->constantParam = $constantParam;
        $this->optionalParam = $optionalParam;
        $this->arrayParam = $arrayParam;
    }

    /**
     * @return array
     */
    public function getParams() : array
    {
        $result = [];
        $result['stringParam'] = $this->stringParam;
        $result['instanceParam'] = $this->instanceParam;
        $result['boolParam'] = $this->boolParam;
        $result['intParam'] = $this->intParam;
        $result['globalInitParam'] = $this->globalInitParam;
        $result['constantParam'] = $this->constantParam;
        $result['optionalParam'] = $this->optionalParam;
        $result['arrayParam'] = $this->arrayParam;

        return $result;
    }
}
