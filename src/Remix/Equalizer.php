<?php

namespace Remix;

use Remix\Exceptions\RemixLogicException;

class Equalizer
{
    private $container = [];

    public function singleton(string $class, ...$args): Gear
    {
        if (! array_key_exists($class, $this->container)) {
            $this->container[$class] = $this->instance($class, $args);
        }
        return $this->container[$class];
    }

    public function instance(string $class, ...$args): Gear
    {
        if (! class_exists($class)) {
            throw new RemixLogicException("Class '{$class}' not found");
        }

        $instance = new $class(...$args);

        if (! $instance instanceof Gear) {
            throw new RemixLogicException("Class '{$class}' is not a subclass of Gear");
        }

        return $instance;
    }
}
