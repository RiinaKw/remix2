<?php

namespace Remix\Effectors;

use Remix\Effector;
use Remix\Exceptions\RemixException;

class Noise extends Effector
{
    protected const TITLE = 'Always throw an exception.';

    public function index()
    {
        throw new RemixException('Make some noise!!');
    }
}
