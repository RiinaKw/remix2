<?php

namespace Remix\Effectors;

use Remix\Effector;

class Version extends Effector
{
    public function index()
    {
        echo 'v0.0.1-alpha';
        return 0;
    }
}
