<?php

namespace Remix\Tests;

use Remix\Utilities\PHPUnit\BaseTestCase;
use Remix\Audio;
use Remix\Amp;
use Remix\Effectors\Noise\Noise;
use Remix\Delay;

class AudioAmpTest extends BaseTestCase
{
    public function testAmp(): void
    {
        $amp = Audio::instance()->amp();
        $this->assertTrue($amp instanceof Amp);

        $amp2 = Audio::instance()->amp();
        $this->assertSame($amp, $amp2);
    }

    public function testDelay(): void
    {
        // just to suppress the STDERR
        $this->expectOutputRegex("//");

        $args = ['amp', 'noise', '-C', '--voice=Make it louder!!'];
        Audio::instance()->amp()->play($args);
        Audio::destroy();

        $expected = [
            ['type' => 'TRACE', 'log' => '[birth] ' . Audio::class],
            ['type' => 'TRACE', 'log' => '[birth] ' . Amp::class],
            ['type' => 'TRACE', 'log' => '[birth] ' . Noise::class],
            [
                'type' => 'BODY',
                'log' => Noise::class . '::index() {"args":{"voice":"Make it louder!!"},"switches":["C"]}'
            ],
            ['type' => 'TRACE', 'log' => '[death] ' . Noise::class],
            ['type' => 'TRACE', 'log' => '[death] ' . Amp::class],
            ['type' => 'TRACE', 'log' => '[death] ' . Audio::class],
        ];
        $this->assertSame($expected, Delay::get());
    }
}
