<?php

namespace Remix\Utilities\Reflection;

/**
 * Reflection for private/protected static members.
 *
 * @package  Remix\Utilities\Reflection
 */
class ReflectionStatic extends Base
{
    /**
     * Set up the ReflectionClass object.
     *
     * @param string $classname target class name
     */
    public function __construct(string $classname)
    {
        parent::__construct($classname);
    }

    /**
     * Get the value of static property object.
     *
     * @param  string $name property name
     * @return mixed        property value
     */
    public function getProp(string $name)
    {
        return $this->propReflection($name)
            ->getValue();
    }

    /**
     * Set the value of static property object.
     *
     * @param string $name  property name
     * @param mixed  $value property value
     * @return void
     */
    public function setProp(string $name, $value): void
    {
        $this->propReflection($name)
            ->setValue($value);
    }

    /**
     * Call the static method.
     *
     * @param  string $name     method name
     * @param  midex  ...$args  arguments of method
     * @return mixed            return value of the method
     */
    public function executeMethod(string $name, ...$args)
    {
        return $this->methodReflection($name)
            ->invokeArgs(null, $args);
    }
}
