<?php

namespace Remix\Effectors;

use Remix\Effector;

class Version extends Effector
{
    protected const TITLE = 'Show version of Remix framework.';

    public function index()
    {
        echo 'v0.0.1-alpha';
        return 0;
    }
}
