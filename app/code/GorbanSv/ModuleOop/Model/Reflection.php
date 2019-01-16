<?php

namespace GorbanSv\ModuleOop\Model;

/**
 * Class Reflection
 * @package GorbanSv\ModuleOop\Model
 */
class Reflection extends DirContents
{
    public const REFLECTION_CONST = 'Reflection constant';

    /**
     * @return array
     * @throws \ReflectionException
     */
    public function getConstants() : array
    {
        $result = [];
        $current_class = new \ReflectionClass(__CLASS__);

        foreach ($current_class->getConstants() as $constant_name => $constant_value) {
            $result[$constant_name] = $constant_value;
        }

        return $result;
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public function getMethods() : array
    {
        $result = [];
        $current_class = new \ReflectionClass(__CLASS__);

        foreach ($current_class->getMethods() as $method) {
            $result[] = $method;
        }

        return $result;
    }
}
