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
}
