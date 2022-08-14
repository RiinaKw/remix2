<?php

namespace Remix\Tests;

use RemixUtilities\PHPUnit\BaseTestCase;
use Remix\Amp;
use ReflectionClass;
use Remix\Exceptions\RemixLogicException;

class AmpTest extends BaseTestCase
{
    public function testInvalidDirectory(): void
    {
        $this->expectException(RemixLogicException::class);
        $this->expectExceptionMessage("'/track/is/muted' is not directory");
        $this->expectOutputRegex('/Internal fatal error in Remix/');

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
        $this->expectOutputRegex('/Internal fatal error in Remix/');

        $amp = new Amp();

        $reflection = new ReflectionClass(Amp::class);
        $property = $reflection->getProperty('effectors_namespace');
        $property->setAccessible(true);
        $property->setValue($amp, '\\Remix\\Distortions\\');

        $amp->play(['amp']);
    }

    public function testValid(): void
    {
        $this->expectOutputRegex('/Remix framework/');
        $this->expectOutputRegex('/v0\.0\.1\-alpha/');

        // Effector that certainly exists
        (new Amp())->play(['version']);
    }

    public function testInvalid(): void
    {
        $this->expectOutputRegex("/command 'fizzle' not exists/");

        // Effector that certainly does not exist
        (new Amp())->play(['fizzle']);
    }

    public function testNoise(): void
    {
        $this->expectOutputRegex("/Make some noise!!/");

        // Effector that throw an exception
        (new Amp())->play(['noise']);
    }

    public function testNoisecore(): void
    {
        $this->expectException(RemixLogicException::class);
        $this->expectOutputRegex('/Internal fatal error in Remix/');
        $this->expectOutputRegex('/This is a test of logic exception./');

        // Effector that throw an RemixLogicException
        (new Amp())->play(['noise:core']);
    }

    public function testArguments(): void
    {
        $this->expectOutputRegex('/Make it louder!!/');

        // Effector that outputs change with arguments
        (new Amp())->play(['noise', '--voice=Make it louder!!']);
    }

    public function testSwitch(): void
    {
        $this->expectOutputRegex('/MAKE SOME NOISE!!/');

        // Effector that outputs change with switch
        (new Amp())->play(['noise', '-C']);
    }

    public function testArgumentsAndSwitch(): void
    {
        $this->expectOutputRegex('/MAKE IT LOUDER!!/');

        // Effector that outputs change with switch and arguments
        (new Amp())->play(['noise', '-C', '--voice=Make it louder!!']);
    }
}
