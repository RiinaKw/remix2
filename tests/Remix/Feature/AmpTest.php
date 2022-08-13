<?php

namespace Remix\Tests;

use PHPUnit\Framework\TestCase;
use RemixUtilities\PHPUnit\Cli;
use Remix\Amp;
use LogicException;

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

    public function testNoisecore(): void
    {
        $this->expectException(LogicException::class);

        // Effector that throw an LogicException
        (new Amp())->play(['amp', 'noise:core']);
    }

    public function testArguments(): void
    {
        // Effector that outputs change with arguments
        $output = $this->capture(function () {
            (new Amp())->play(['amp', 'noise', '--voice=Make it louder!!']);
        });
        $this->assertSame('Make it louder!!', $output);
    }

    public function testSwitch(): void
    {
        // Effector that outputs change with switch
        $output = $this->capture(function () {
            (new Amp())->play(['amp', 'noise', '-C']);
        });
        $this->assertSame('MAKE SOME NOISE!!', $output);

        // Effector that outputs change with switch and arguments
        $output = $this->capture(function () {
            (new Amp())->play(['amp', 'noise', '-C', '--voice=Make it louder!!']);
        });
        $this->assertSame('MAKE IT LOUDER!!', $output);
    }
}
