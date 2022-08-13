<?php

namespace Remix\Tests\Effectors;

use PHPUnit\Framework\TestCase;
use Remix\Effectors\Version as VersionEffector;
use RemixUtilities\PHPUnit\Cli;

class VersionEffectorTest extends TestCase
{
    use Cli;

    public function testIndex(): void
    {
        $output = $this->capture(function () {
            (new VersionEffector())->index();
        });
        $this->assertSame('Remix framework v0.0.1-alpha', $output);
    }

    public function testTitle(): void
    {
        $effector = new VersionEffector();

        $this->assertSame('Show the version of Remix framework.', $effector->title());
    }
}
