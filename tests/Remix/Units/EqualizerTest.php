<?php

namespace Remix\Tests\Unit;

use Remix\Utilities\PHPUnit\BaseTestCase;
use Remix\Equalizer;
use Remix\Tests\TestClasses\ClassWithNoArgs;
use Remix\Tests\TestClasses\ClassWithArgs;

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

        $this->assertSame(['test arg 1', 2], $instance->get());
    }
}
