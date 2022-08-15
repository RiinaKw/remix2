<?php

namespace Remix\Tests\TestClasses;

use Remix\Gear;

class ClassWithArgs extends Gear
{
    private $arg1;
    private $arg2;

    public function __construct($arg1, $arg2)
    {
        $this->arg1 = $arg1;
        $this->arg2 = $arg2;
    }
}
