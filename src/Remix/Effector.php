<?php

namespace Remix;

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
    protected function line(string $message): self
    {
        echo $message . "\n";
        return $this;
    }
}
