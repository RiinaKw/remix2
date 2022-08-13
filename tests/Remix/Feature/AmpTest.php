<?php

namespace Remix\Tests;

use PHPUnit\Framework\TestCase;
use Remix\Amp;
use Remix\Effector;

class AmpTest extends TestCase
{
    public function testValid(): void
    {
        $amp = new Amp();

        ob_start();
        $amp->play(['amp', 'version']);
        $output = ob_get_clean();

        $regex = '/' . str_replace('[', '\\[', Effector::DECORATION_START) . '.*?m/';
        $output = preg_replace($regex, '', $output);

        $this->assertSame('Remix framework v0.0.1-alpha', trim($output));
    }

    public function testInvalid(): void
    {
        $amp = new Amp();

        ob_start();
        $amp->play(['amp', 'boo']);
        $output = ob_get_clean();

        $regex = '/' . str_replace('[', '\\[', Effector::DECORATION_START) . '.*?m/';
        $output = preg_replace($regex, '', $output);

        $this->assertSame("command 'boo' not exists", trim($output));
    }

    public function testNoise(): void
    {
        $amp = new Amp();

        ob_start();
        $amp->play(['amp', 'noise']);
        $output = ob_get_clean();

        $regex = '/' . str_replace('[', '\\[', Effector::DECORATION_START) . '.*?m/';
        $output = preg_replace($regex, '', $output);

        $this->assertSame('Make some noise!!', trim($output));
    }
}
