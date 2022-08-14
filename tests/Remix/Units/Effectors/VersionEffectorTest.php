<?php

namespace Remix\Tests\Effectors;

use RemixUtilities\PHPUnit\BaseTestCase;
use Remix\Effectors\Version as VersionEffector;

class VersionEffectorTest extends BaseTestCase
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
