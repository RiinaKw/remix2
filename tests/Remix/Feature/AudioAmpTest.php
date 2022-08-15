<?php

namespace Remix\Tests;

use Remix\Utilities\PHPUnit\BaseTestCase;
use Remix\Audio;
use Remix\Amp;

class AudioAmpTest extends BaseTestCase
{
    public function testAmp(): void
    {
        $amp = Audio::instance()->amp();
        $this->assertTrue($amp instanceof Amp);

        $amp2 = Audio::instance()->amp();
        $this->assertSame($amp, $amp2);
    }
}
