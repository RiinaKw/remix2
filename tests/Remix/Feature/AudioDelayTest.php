<?php

namespace Remix\Tests;

use PHPUnit\Framework\TestCase;
use Remix\Audio;
use Remix\Delay;

class AudioDelayTest extends TestCase
{
    protected function setUp(): void
    {
        Delay::mute();
    }

    /**
    * @runInSeparateProcess
     *
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
    */
    public function testAudioInstanceLog(): void
    {
        // no any logs
        $this->assertSame([], Delay::get());

        $audio = Audio::instance();

        // birth log generated
        $this->assertSame([
            ['type' => 'TRACE', 'log' => '[birth] ' . Audio::class],
        ], Delay::get());

        // no logs added
        Audio::instance();
        $this->assertSame([
            ['type' => 'TRACE', 'log' => '[birth] ' . Audio::class],
        ], Delay::get());

        // no log added because referenced
        Audio::destroy();
        $this->assertSame([
            ['type' => 'TRACE', 'log' => '[birth] ' . Audio::class],
        ], Delay::get());

        // no longer refer
        $audio = null;
        Audio::destroy();

        // death log generated
        $this->assertSame([
            ['type' => 'TRACE', 'log' => '[birth] ' . Audio::class],
            ['type' => 'TRACE', 'log' => '[death] ' . Audio::class],
        ], Delay::get());
    }
}
