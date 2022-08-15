<?php

namespace Remix;

abstract class Gear
{
    public function __construct()
    {
        Delay::logBirth(static::class);
    }

    public function __destruct()
    {
        Delay::logDeath(static::class);
    }
}
