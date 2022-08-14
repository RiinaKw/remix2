<?php

namespace Remix;

class Equalizer
{
    private $container = [];

    public function singleton(string $class, ...$args)
    {
        if (! array_key_exists($class, $this->container)) {
            $this->container[$class] = $this->instance($class, $args);
        }
        return $this->container[$class];
    }

    public function instance(string $class, ...$args)
    {
        $instance = new $class(...$args);
        return $instance;
    }
}
