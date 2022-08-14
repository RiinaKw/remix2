<?php

namespace Remix\Utilities\PHPUnit;

use PHPUnit\Framework\TestCase;
use Remix\Delay;

class BaseTestCase extends TestCase
{
    protected function setUp(): void
    {
        Delay::mute();
    }
}
