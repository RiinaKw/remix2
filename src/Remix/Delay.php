<?php

namespace Remix;

use RemixUtilities\Cli;

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

    private static $handle = 'php://stderr';

    public static function mute(): void
    {
        static::$handle = '.delay.phpunit.cache';
    }

    /**
     * Add a log.
     *
     * @param string $message
     * @return void
     */
    public static function log(string $type, string $message): void
    {
        $log = [
            'type' => $type,
            'log' => $message,
        ];
        static::$log[] = $log;

        if (php_sapi_name() == 'cli') {
            $text_color = '';
            $background_color = '';
            switch ($log['type']) {
                case 'BODY':
                    $text_color = 'green';
                    break;
                case 'TRACE':
                    $text_color = 'light_blue';
                    break;
                case 'MEMORY':
                    $text_color = 'yellow';
                    break;
                case 'TIME':
                    $text_color = 'purple';
                    break;
                case 'QUERY':
                    $text_color = 'cyan';
                    break;
            }
            $message = Cli::decorate($message, $text_color, $background_color);
            file_put_contents(static::$handle, $message . "\n");
        }
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
        static::log('TRACE', '[birth] ' . $classname);
    }

    /**
     * Add a log indicating that the object was destructed.
     *
     * @param string $classname
     * @return void
     */
    public static function logDeath(string $classname): void
    {
        static::log('TRACE', '[death] ' . $classname);
    }
}
