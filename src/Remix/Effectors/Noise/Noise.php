<?php

namespace Remix\Effectors\Noise;

use Remix\Effector;
use Remix\Exceptions\RemixRuntimeException;
use LogicException;

/**
 * Remix Noise Effector : throw exceptions for debugging.
 *
 * @package  Remix\Cli\Effectors
 */
class Noise extends Effector
{
    /**
     * Title of Effector.
     */
    protected const TITLE = 'Always throw an exception.';

    /**
     * Throw a general exception.
     *
     * @param array $args
     * @return integer
     */
    public function index(array $args = []): int
    {
        $voice = $args['args']['voice'] ?? 'Make some noise!!';
        if (in_array('C', $args['switches'])) {
            $voice = strtoupper($voice);
        }
        throw new RemixRuntimeException($voice);
    }

    /**
     * Throw a dangerous exception.
     *
     * @return integer
     */
    public function core(): int
    {
        throw new LogicException('This is a test of logic exception.');
    }
}
