<?php

namespace Remix\Tests;

use Remix\Utilities\PHPUnit\BaseTestCase;
use Remix\Amp;
use Remix\Effectors\Noise\Noise;
use Remix\Delay;

class AmpDelayTest extends BaseTestCase
{
    public function testAmpWithDelay(): void
    {
        // just to suppress the STDERR
        $this->expectOutputRegex("//");

        // play thee Effector
        (new Amp())->play(['noise', '-C', '--voice=Make it louder!!']);

        $expected = [
            ['type' => 'TRACE', 'log' => '[birth] ' . Amp::class],
            ['type' => 'TRACE', 'log' => '[birth] ' . Noise::class],
            ['type' => 'BODY', 'log' => '\\' . Noise::class . '::index() {"args":{"voice":"Make it louder!!"},"switches":["C"]}'],
            ['type' => 'TRACE', 'log' => '[death] ' . Noise::class],
            ['type' => 'TRACE', 'log' => '[death] ' . Amp::class],
        ];
        $this->assertSame($expected, Delay::get());
    }
}
