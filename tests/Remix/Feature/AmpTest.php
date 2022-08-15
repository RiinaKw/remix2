<?php

namespace Remix\Tests;

use Remix\Utilities\PHPUnit\BaseTestCase;
use Remix\Amp;
use Remix\Utilities\Reflection\ReflectionObject;
use Remix\Exceptions\RemixLogicException;

class AmpTest extends BaseTestCase
{
    public function testInvalidDirectory(): void
    {
        $this->expectException(RemixLogicException::class);
        $this->expectExceptionMessage("'/track/is/muted' is not directory");
        $this->expectOutputRegex('/Internal fatal error in Remix/');

        $amp = new Amp();

        // rewrite lthe property by Reflection
        (new ReflectionObject($amp))->setProp('effectors_dir', '/track/is/muted');

        $amp->play();
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

        // rewrite lthe property by Reflection
        (new ReflectionObject($amp))->setProp('effectors_namespace', '\\Remix\\Distortions\\');

        $amp->play();
    }

    public function testValid(): void
    {
        $this->expectOutputRegex('/Remix framework/');
        $this->expectOutputRegex('/v0\.0\.1\-alpha/');

        // Effector that certainly exists
        (new Amp())->play(['amp', 'version']);
    }

    public function testInvalid(): void
    {
        $this->expectOutputRegex("/command 'fizzle' not exists/");

        // Effector that certainly does not exist
        (new Amp())->play(['amp', 'fizzle']);
    }

    public function testNoise(): void
    {
        $this->expectOutputRegex("/Make some noise!!/");

        // Effector that throw an exception
        (new Amp())->play(['amp', 'noise']);
    }

    public function testNoisecore(): void
    {
        $this->expectException(RemixLogicException::class);
        $this->expectOutputRegex('/Internal fatal error in Remix/');
        $this->expectOutputRegex('/This is a test of logic exception./');

        // Effector that throw an RemixLogicException
        (new Amp())->play(['amp', 'noise:core']);
    }

    public function testArguments(): void
    {
        $this->expectOutputRegex('/Make it louder!!/');

        // Effector that outputs change with arguments
        (new Amp())->play(['amp', 'noise', '--voice=Make it louder!!']);
    }

    public function testSwitch(): void
    {
        $this->expectOutputRegex('/MAKE SOME NOISE!!/');

        // Effector that outputs change with switch
        (new Amp())->play(['amp', 'noise', '-C']);
    }

    public function testArgumentsAndSwitch(): void
    {
        $this->expectOutputRegex('/MAKE IT LOUDER!!/');

        // Effector that outputs change with switch and arguments
        (new Amp())->play(['amp', 'noise', '-C', '--voice=Make it louder!!']);
    }
}
