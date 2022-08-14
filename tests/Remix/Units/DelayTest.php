<?php

namespace Remix\Tests;

use RemixUtilities\PHPUnit\BaseTestCase;
use Remix\Delay;

class DelayTest extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

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
        Delay::log('TEST', 'test message');
        $this->assertSame([
            ['type' => 'TEST', 'log' => 'test message'],
        ], Delay::get());

        // add another log
        Delay::log('TEST', 'more message');
        $this->assertSame([
            ['type' => 'TEST', 'log' => 'test message'],
            ['type' => 'TEST', 'log' => 'more message'],
        ], Delay::get());
    }

    public function testFlush(): void
    {
        // add a log
        Delay::log('TEST', 'test message');

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
        Delay::log('TEST', 'test message');
        $this->assertSame(1, Delay::count());

        // add another log, the count is two
        Delay::log('TEST', 'more message');
        $this->assertSame(2, Delay::count());

        // flush the log, the count should back to zero
        Delay::flush();
        $this->assertSame(0, Delay::count());
    }

    public function testBirthAndDeath(): void
    {
        // add log
        Delay::logBirth('test class');
        $this->assertSame([
            ['type' => 'TRACE', 'log' => '[birth] test class'],
        ], Delay::get());

        // add another log
        Delay::logDeath('test class');
        $this->assertSame([
            ['type' => 'TRACE', 'log' => '[birth] test class'],
            ['type' => 'TRACE', 'log' => '[death] test class'],
        ], Delay::get());
    }
}
