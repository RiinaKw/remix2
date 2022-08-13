<?php

namespace Remix;

class Audio
{
    /**
     * The only instance.
     * @var Audio
     */
    private static $audio = null;

    public static function instance(): self
    {
        if (! static::$audio) {
            static::$audio = new static();
        }
        return static::$audio;
    }

    private function __construct()
    {
        Delay::logBirth(static::class);
    }

    public function __destruct()
    {
        Delay::logDeath(static::class);
    }

    public static function destroy()
    {
        static::$audio = null;
    }
}
