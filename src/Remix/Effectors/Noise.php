<?php

namespace Remix\Effectors;

use Remix\Effector;
use Remix\Exceptions\RemixRuntimeException;

class Noise extends Effector
{
    protected const TITLE = 'Always throw an exception.';

    public function index()
    {
        throw new RemixRuntimeException('Make some noise!!');
    }
}
