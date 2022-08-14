<?php

namespace Remix;

use RemixUtilities\Cli;

/**
 * Remix Effector : command line controller.
 *
 * @package Remix\Cli
 */
abstract class Effector
{
    /**
     * Available subcommands and descriptions.
     */
    protected $available = [
        '' => 'This Effector is abstract class, prease override.',
    ];

    public function __construct()
    {
        Delay::logBirth(static::class);
    }

    public function __destruct()
    {
        Delay::logDeath(static::class);
    }

    /**
     * Get all available subcommands.
     *
     * @return array<string, string>
     */
    public function available(): array
    {
        return $this->available;
    }

    /**
     * Get description of the subcomman.
     *
     * @param string $subcommands
     * @return string|null
     */
    public function description(string $subcommands): ?string
    {
        return $this->available[$subcommands] ?? null;
    }

    /**
     * Output one line　to stdout.
     *
     * @param string $message
     * @return self
     */
    protected function line(string $output = ''): self
    {
        Cli::line($output);
        return $this;
    }
}
