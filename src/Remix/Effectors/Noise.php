<?php

namespace Remix\Effectors;

use Remix\Effector;
use Remix\Exceptions\RemixRuntimeException;
use LogicException;

class Noise extends Effector
{
    protected const TITLE = 'Always throw an exception.';

    public function index(array $args = [])
    {
        $voice = $args['voice'] ?? 'Make some noise!!';
        throw new RemixRuntimeException($voice);
    }

    public function core()
    {
        throw new LogicException('This is a test of logic exception.');
    }
}
