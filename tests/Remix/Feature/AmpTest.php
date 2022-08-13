<?php

namespace Remix\Tests;

use PHPUnit\Framework\TestCase;
use Remix\Amp;
use Remix\Effector;
use RemixUtilities\PHPUnit\Cli;

class AmpTest extends TestCase
{
    use Cli;

    public function testValid(): void
    {
        // Effector that certainly exists
        $output = $this->capture(function () {
            (new Amp())->play(['amp', 'version']);
        });

        $this->assertSame('Remix framework v0.0.1-alpha', $output);
    }

    public function testInvalid(): void
    {
        // Effector that certainly does not exist
        $output = $this->capture(function () {
            (new Amp())->play(['amp', 'boo']);
        });

        $this->assertSame("command 'boo' not exists", $output);
    }

    public function testNoise(): void
    {
        // Effector that throw an exception
        $output = $this->capture(function () {
            (new Amp())->play(['amp', 'noise']);
        });

        $this->assertSame('Make some noise!!', $output);
    }
}
