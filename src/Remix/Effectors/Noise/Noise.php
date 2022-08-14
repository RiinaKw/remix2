<?php

namespace Remix\Effectors\Noise;

use Remix\Effector;
use Remix\Exceptions\RemixRuntimeException;
use Remix\Exceptions\RemixLogicException;

/**
 * Remix Noise Effector : throw exceptions for debugging.
 *
 * @package  Remix\Cli\Effectors
 */
class Noise extends Effector
{
    /**
     * Available subcommands and descriptions.
     */
    protected $available = [
        ''      => 'Always throw an runtime exception.',
        'core'  => 'Always throw an logic exception.',
    ];

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
        throw new RemixLogicException('This is a test of logic exception.');
    }
}
