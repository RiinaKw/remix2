<?php

namespace Remix\Effectors;

use Remix\Effector;

class Version extends Effector
{
    protected const TITLE = 'Show version of Remix framework.';

    public function index()
    {
        $version = static::decorate('v0.0.1-alpha', 'yellow', 'green', 'bold');
        $this->line('Remix framework ' . $version);
        return 0;
    }
}
