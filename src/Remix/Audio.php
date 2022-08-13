<?php

namespace Remix;

/**
 * Remix Audio : application handler.
 *
 * @package Remix\Core
 */
class Audio
{
    /**
     * The only instance.
     * @var Audio
     */
    private static $audio = null;

    private function __construct()
    {
        Delay::logBirth(static::class);
    }

    public function __destruct()
    {
        Delay::logDeath(static::class);
    }

    /**
     * Get the only instance, or create one if it does not exist.
     *
     * @return self
     */
    public static function instance(): self
    {
        if (! static::$audio) {
            static::$audio = new static();
        }
        return static::$audio;
    }

    /**
     * Destroy the instances it holds.
     *
     * @return void
     */
    public static function destroy(): void
    {
        static::$audio = null;
    }
}
