<?php

namespace RemixUtilities\PHPUnit;

use RemixUtilities\Output;
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
     * Capture the output and undecorate.
     *
     * @param callable $callback    Callable method with output
     * @return string
     */
    public function capture(callable $callback): string
    {
        $output = Output::capture($callback);
        return Effector::trimDecoration($output);
    }
}
