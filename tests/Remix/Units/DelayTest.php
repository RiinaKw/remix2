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
        // add a log
        Delay::log('test message');
        $this->assertSame(['test message'], Delay::get());

        // add another log
        Delay::log('more message');
        $this->assertSame(['test message', 'more message'], Delay::get());
    }

    public function testFlush(): void
    {
        // add a log
        Delay::log('test message');

        // the count is one
        $this->assertSame(1, count(Delay::get()));

        // flush log
        Delay::flush();

        // return to zero
        $this->assertSame(0, count(Delay::get()));
    }

    public function testCount()
    {
        // add a log, the count is one
        Delay::log('test message');
        $this->assertSame(1, Delay::count());

        // add another log, the count is two
        Delay::log('more message');
        $this->assertSame(2, Delay::count());

        // flush the log, the count should back to zero
        Delay::flush();
        $this->assertSame(0, Delay::count());
    }

    public function testBirthAndDeath(): void
    {
        // add log
        Delay::logBirth('test class');
        $this->assertSame(['[birth] test class'], Delay::get());

        // add another log
        Delay::logDeath('test class');
        $this->assertSame(['[birth] test class', '[death] test class'], Delay::get());
    }
}
