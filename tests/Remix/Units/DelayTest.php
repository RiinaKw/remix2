<?php

namespace Remix\Tests;

use PHPUnit\Framework\TestCase;
use Remix\Delay;

class DelayTest extends TestCase
{
    protected function setUp(): void
    {
        Delay::flush();
    }

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

    public function testFlush(): void
    {
        // add log
        Delay::log('test message');

        // the count is one
        $this->assertSame(1, count(Delay::get()));

        // flush log
        Delay::flush();

        // return to zero
        $this->assertSame(0, count(Delay::get()));
    }
}
