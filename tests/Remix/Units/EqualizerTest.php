<?php

namespace Remix\Tests\Unit;

use Remix\Utilities\PHPUnit\BaseTestCase;
use Remix\Equalizer;
use Remix\Utilities\Reflection\ReflectionObject;
use Remix\Tests\TestClasses\ClassWithNoArgs;
use Remix\Tests\TestClasses\ClassWithArgs;
use Remix\Tests\TestClasses\ClassWithoutGear;
use Remix\Exceptions\RemixLogicException;

class EqualizerTest extends BaseTestCase
{
    public function testInstance(): void
    {
        $equalizer = new Equalizer();

        $instance1 = $equalizer->instance(ClassWithNoArgs::class);
        $this->assertNotNull($instance1);

        $instance2 = $equalizer->instance(ClassWithNoArgs::class);
        $this->assertNotSame($instance1, $instance2);
    }

    public function testSingleton(): void
    {
        $equalizer = new Equalizer();

        $instance1 = $equalizer->singleton(ClassWithNoArgs::class);
        $this->assertNotNull($instance1);

        $instance2 = $equalizer->singleton(ClassWithNoArgs::class);
        $this->assertSame($instance1, $instance2);
    }

    public function testInstanceWithArgs(): void
    {
        $equalizer = new Equalizer();

        $instance = $equalizer->instance(ClassWithArgs::class, 'test arg 1', 2);
        $this->assertNotNull($instance);

        $arg1 = (new ReflectionObject($instance))->getProp('arg1');
        $arg2 = (new ReflectionObject($instance))->getProp('arg2');

        $this->assertSame('test arg 1', $arg1);
        $this->assertSame(2, $arg2);
    }

    public function testNonExists(): void
    {
        $classname = NonExistsClass::class;

        $this->expectException(RemixLogicException::class);
        $this->expectExceptionMessage("Class '{$classname}' not found");

        $equalizer = new Equalizer();

        $equalizer->instance($classname, 'test arg 1', 2);
    }

    public function testWithoutGear(): void
    {
        $classname = ClassWithoutGear::class;

        $this->expectException(RemixLogicException::class);
        $this->expectExceptionMessage("Class '{$classname}' is not a subclass of Gear");

        $equalizer = new Equalizer();

        $equalizer->instance($classname, 'test arg 1', 2);
    }
}
