<?php

namespace Remix\Utilities\Reflection;

use ReflectionClass;
use ReflectionProperty;
use ReflectionMethod;

/**
 * Wrapper class of Reflection
 *
 * @package  Remix\Utilities\Reflection
 */
abstract class Base
{
    /**
     * Reflection object
     * @var ReflectionClass
     */
    private $reflection = null;

    /**
     * Set up the ReflectionClass object.
     *
     * @param string $classname target class name
     */
    protected function __construct(string $classname)
    {
        $this->reflection = new ReflectionClass($classname);
    }

    /**
     * Get the property object.
     *
     * @param  string $name         property name
     * @return ReflectionProperty   property instance
     */
    protected function propReflection(string $name): ReflectionProperty
    {
        $prop = $this->reflection->getProperty($name);
        $prop->setAccessible(true);
        return $prop;
    }

    /**
     * Get the method object.
     *
     * @param string $name      method name
     * @return ReflectionMethod method instance
     */
    protected function methodReflection(string $name): ReflectionMethod
    {
        $method = $this->reflection->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }

    abstract public function getProp(string $name);
    abstract public function setProp(string $name, $value): void;
    abstract public function executeMethod(string $name, ...$args);
}
