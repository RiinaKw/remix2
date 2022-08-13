<?php

namespace Remix\Tests;

use PHPUnit\Framework\TestCase;
use Remix\Amp;
use Remix\Effector;

class AmpTest extends TestCase
{
    public function testValid(): void
    {
        $amp = new Amp();

        ob_start();
        $amp->play(['amp', 'version']);
        $output = ob_get_clean();

        $this->assertSame('Remix framework v0.0.1-alpha', Effector::trimDecorattion($output));
    }

    public function testInvalid(): void
    {
        $amp = new Amp();

        ob_start();
        $amp->play(['amp', 'boo']);
        $output = ob_get_clean();

        $this->assertSame("command 'boo' not exists", Effector::trimDecorattion($output));
    }

    public function testNoise(): void
    {
        $amp = new Amp();

        ob_start();
        $amp->play(['amp', 'noise']);
        $output = ob_get_clean();

        $this->assertSame('Make some noise!!', Effector::trimDecorattion($output));
    }
}
