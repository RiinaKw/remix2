<?php

namespace Remix\Utilities\Reflection;

/**
 * Reflection for private/protected members
 *
 * @package  Remix\Utilities\Reflection
 */
class ReflectionObject extends Base
{
    /**
     * Target object
     * @var object
     */

    private $target = null;

    /**
     * Set up the ReflectionClass object.
     *
     * @param object $target    target object
     */
    public function __construct(object $target)
    {
        parent::__construct(get_class($target));
        $this->target = $target;
    }

    /**
     * Get the value of property object.
     *
     * @param  string $name property name
     * @return mixed        property value
     */
    public function getProp(string $name)
    {
        return $this->propReflection($name)
            ->getValue($this->target);
    }

    /**
     * Set the value of property object.
     *
     * @param string $name  property name
     * @param mixed  $value property value
     * @return void
     */
    public function setProp(string $name, $value): void
    {
        $this->propReflection($name)
            ->setValue($this->target, $value);
    }

    /**
     * Call the method.
     *
     * @param string  $name method name
     * @param mixed ..$args arguments of method
     * @return mixed        return value of the method
     */
    public function executeMethod(string $name, ...$args)
    {
        return $this->methodReflection($name)
            ->invokeArgs($this->target, $args);
    }
}
