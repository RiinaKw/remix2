<?php

namespace Remix\Tests;

use PHPUnit\Framework\TestCase;
use Remix\Audio;

class AudioTest extends TestCase
{
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
