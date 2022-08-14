<?php

namespace RemixUtilities;

/**
 * Utility class for text output.
 *
 * @package Remix\Utilities
 */
class Output
{
    /**
     * Capture the output.
     *
     * @param callable $callback    Callable method with output
     * @return string
     */
    public static function capture(callable $callback): string
    {
        ob_start();
        $callback();
        return ob_get_clean();
    }
}
