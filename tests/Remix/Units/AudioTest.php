<?php

namespace Remix\Tests;

use PHPUnit\Framework\TestCase;
use Remix\Audio;
use Remix\Delay;

class AudioTest extends TestCase
{
    protected function setUp(): void
    {
        Delay::mute();
    }

    /**
    * @runInSeparateProcess
    */
    public function testSingleton(): void
    {
        $audio = Audio::instance();
        $this->assertNotNull($audio);

        $new_audio = Audio::instance();
        $this->assertSame($audio, $new_audio);
    }
}
