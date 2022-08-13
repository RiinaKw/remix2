<?php

namespace RemixUtilities\PHPUnit;

use Remix\Effector;

/**
 * Utility trait for CLI testing.
 *
 * purpose used by PHPUnit\Framework\TestCase
 *
 * @package Remix\Utilities\PHPUnit
 */
trait Cli
{
    /**
     * Capture the output.
     *
     * @param callable $callback    Callable method with output
     * @return string
     */
    public function capture(callable $callback): string
    {
        ob_start();
        $callback();
        $output = ob_get_clean();
        return Effector::trimDecoration($output);
    }
}
