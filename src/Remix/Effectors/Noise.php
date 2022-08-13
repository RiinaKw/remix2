<?php

namespace Remix\Effectors;

use Remix\Effector;
use Remix\Exceptions\RemixRuntimeException;
use LogicException;

class Noise extends Effector
{
    protected const TITLE = 'Always throw an exception.';

    public function index()
    {
        throw new RemixRuntimeException('Make some noise!!');
    }

    public function core()
    {
        throw new LogicException('This is a test of logic exception.');
    }
}
