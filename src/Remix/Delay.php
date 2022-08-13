<?php

namespace Remix;

final class Delay
{
    private static $log = [];

    public static function log(string $message): void
    {
        static::$log[] = $message;
    }

    public static function get(): array
    {
        return static::$log;
    }

    public static function flush()
    {
        static::$log = [];
    }

    public static function count(): int
    {
        return count(static::$log);
    }

    public static function logBirth(string $classname): void
    {
        static::$log[] = '[birth] ' . $classname;
    }

    public static function logDeath(string $classname): void
    {
        static::$log[] = '[death] ' . $classname;
    }
}
