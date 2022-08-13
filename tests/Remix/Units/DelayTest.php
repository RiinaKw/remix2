<?php

namespace Remix\Tests;

use PHPUnit\Framework\TestCase;
use Remix\Delay;

class DelayTest extends TestCase
{
    public function testNoLog(): void
    {
        // no any logs
        $this->assertSame([], Delay::get());
    }

    public function testAdd(): void
    {
        // add log
        Delay::log('test message');
        $this->assertSame(['test message'], Delay::get());

        // add another log
        Delay::log('more message');
        $this->assertSame(['test message', 'more message'], Delay::get());
    }
}
