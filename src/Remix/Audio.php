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
        Delay::log(static::class . ' birth');
    }

    public function __destruct()
    {
        Delay::log(static::class . ' death');
    }

    public static function destroy()
    {
        static::$audio = null;
    }
}
