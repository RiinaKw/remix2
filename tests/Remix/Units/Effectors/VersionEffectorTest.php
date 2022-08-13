<?php

namespace Remix\Tests\Effectors;

use PHPUnit\Framework\TestCase;
use Remix\Effectors\Version as VersionEffector;

class VersionEffectorTest extends TestCase
{
    public function testIndex(): void
    {
        $effector = new VersionEffector();

        ob_start();
        $effector->index();
        $output = ob_get_clean();

        $this->assertSame('v0.0.1-alpha', $output);
    }

    public function testTitle(): void
    {
        $effector = new VersionEffector();

        ob_start();
        $effector->index();
        $output = ob_get_clean();

        $this->assertSame('Show version of Remix framework.', $effector->title());
    }
}
