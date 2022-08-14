<?php

namespace Remix\Tests;

use PHPUnit\Framework\TestCase;
use RemixUtilities\PHPUnit\Cli;
use Remix\Amp;
use ReflectionClass;
use Remix\Exceptions\RemixLogicException;

class AmpTest extends TestCase
{
    use Cli;

    public function testInvalidDirectory(): void
    {
        $this->expectException(RemixLogicException::class);
        $this->expectExceptionMessage("'/track/is/muted' is not directory");

        $amp = new Amp();

        $reflection = new ReflectionClass(Amp::class);
        $property = $reflection->getProperty('effectors_dir');
        $property->setAccessible(true);
        $property->setValue($amp, '/track/is/muted');

        $amp->play(['amp']);
    }

    public function testInvalidNamespace(): void
    {
        $this->expectException(RemixLogicException::class);
        // Since there is no way to check "if the namespace exists," I don't know which class will be called first.
        // Therefore, the exact exception message cannot be identified...
        $this->expectExceptionMessage("class '\\Remix\\Distortions\\");
        $this->expectExceptionMessage("not found");

        $amp = new Amp();

        $reflection = new ReflectionClass(Amp::class);
        $property = $reflection->getProperty('effectors_namespace');
        $property->setAccessible(true);
        $property->setValue($amp, '\\Remix\\Distortions\\');

        $amp->play([]);
    }

    public function testValid(): void
    {
        // Effector that certainly exists
        $output = $this->capture(function () {
            (new Amp())->play(['version']);
        });

        $this->assertSame('Remix framework v0.0.1-alpha', $output);
    }

    public function testInvalid(): void
    {
        // Effector that certainly does not exist
        $output = $this->capture(function () {
            (new Amp())->play(['fizzle']);
        });

        $this->assertSame("command 'fizzle' not exists", $output);
    }

    public function testNoise(): void
    {
        // Effector that throw an exception
        $output = $this->capture(function () {
            (new Amp())->play(['noise']);
        });

        $this->assertSame('Make some noise!!', $output);
    }

    public function testNoisecore(): void
    {
        $this->expectException(RemixLogicException::class);

        // Effector that throw an RemixLogicException
        (new Amp())->play(['noise:core']);
    }

    public function testArguments(): void
    {
        // Effector that outputs change with arguments
        $output = $this->capture(function () {
            (new Amp())->play(['noise', '--voice=Make it louder!!']);
        });
        $this->assertSame('Make it louder!!', $output);
    }

    public function testSwitch(): void
    {
        // Effector that outputs change with switch
        $output = $this->capture(function () {
            (new Amp())->play(['noise', '-C']);
        });
        $this->assertSame('MAKE SOME NOISE!!', $output);

        // Effector that outputs change with switch and arguments
        $output = $this->capture(function () {
            (new Amp())->play(['noise', '-C', '--voice=Make it louder!!']);
        });
        $this->assertSame('MAKE IT LOUDER!!', $output);
    }
}
