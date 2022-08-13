<?php

namespace Remix;

/**
 * Remix Delay : log manager.
 *
 * @package Remix\Core
 */
final class Delay
{
    /**
     * Internal log array.
     *
     * @var array<int, string>
     */
    private static $log = [];

    /**
     * Add a log.
     *
     * @param string $message
     * @return void
     */
    public static function log(string $message): void
    {
        static::$log[] = $message;
    }

    /**
     * Get the log list.
     *
     * @return array<int, string>
     */
    public static function get(): array
    {
        return static::$log;
    }

    /**
     * Empty the log list.
     *
     * @return void
     */
    public static function flush(): void
    {
        static::$log = [];
    }

    /**
     * Get the count of logs.
     *
     * @return integer
     */
    public static function count(): int
    {
        return count(static::$log);
    }

    /**
     * Add a log indicating that the object was constructed.
     *
     * @param string $classname
     * @return void
     */
    public static function logBirth(string $classname): void
    {
        static::$log[] = '[birth] ' . $classname;
    }

    /**
     * Add a log indicating that the object was destructed.
     *
     * @param string $classname
     * @return void
     */
    public static function logDeath(string $classname): void
    {
        static::$log[] = '[death] ' . $classname;
    }
}
