<?php

namespace Remix\Utilities\PHPUnit;

use PHPUnit\Framework\TestCase;
use Remix\Delay;

/**
 * Base PHPUnit test case class for Remix
 *
 * @package  Remix\Utilities\PHPUnit
 */
class BaseTestCase extends TestCase
{
    protected function setUp(): void
    {
        Delay::mute();
    }
}
