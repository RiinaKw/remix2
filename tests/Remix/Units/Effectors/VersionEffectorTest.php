<?php

namespace Remix\Tests\Effectors;

use PHPUnit\Framework\TestCase;
use Remix\Effectors\Version as VersionEffector;
use RemixUtilities\PHPUnit\Cli;

class VersionEffectorTest extends TestCase
{
    public function testIndex(): void
    {
        $this->expectOutputRegex('/Remix framework/');
        $this->expectOutputRegex('/v0\.0\.1\-alpha/');

        (new VersionEffector())->index();
    }

    public function testTitle(): void
    {
        $effector = new VersionEffector();

        $this->assertSame('Show the version of Remix framework.', $effector->description(''));
    }
}
