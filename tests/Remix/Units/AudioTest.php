<?php

namespace Remix\Tests;

use RemixUtilities\PHPUnit\BaseTestCase;
use Remix\Audio;

class AudioTest extends BaseTestCase
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
