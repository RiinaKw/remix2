<?php

namespace Remix\Effectors;

use Remix\Effector;
use Remix\Utilities\Cli;

/**
 * Remix Version Effector : show the version of Remix.
 *
 * @package  Remix\Cli\Effectors
 */
class Version extends Effector
{
    /**
     * Available subcommands and descriptions.
     */
    protected $available = [
        '' => 'Show the version of Remix framework.',
    ];

    /**
     * Show the version of Remix framework.
     *
     * @return integer
     */
    public function index(): int
    {
        $version = Cli::decorate('v0.0.1-alpha', 'yellow', 'green', 'bold');
        $this->line('Remix framework ' . $version);
        return 0;
    }
}
