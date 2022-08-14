<?php

namespace RemixUtilities\PHPUnit;

use RemixUtilities\Cli as CliUtility;

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
        $output = CliUtility::capture($callback);
        return CliUtility::trimDecoration($output);
    }
}
