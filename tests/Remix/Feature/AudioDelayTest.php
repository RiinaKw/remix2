<?php

namespace Remix\Tests;

use PHPUnit\Framework\TestCase;
use Remix\Audio;
use Remix\Delay;

class AudioDelayTest extends TestCase
{
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
        $this->assertSame([Audio::class . ' birth'], Delay::get());

        // no logs added
        Audio::instance();
        $this->assertSame([Audio::class . ' birth'], Delay::get());

        // no log added because referenced
        Audio::destroy();
        $this->assertSame([Audio::class . ' birth'], Delay::get());

        // no longer refer
        $audio = null;
        Audio::destroy();

        // death log generated
        $this->assertSame([Audio::class . ' birth', Audio::class . ' death'], Delay::get());
    }
}
