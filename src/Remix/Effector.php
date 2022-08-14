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
     * Title of Effector.
     */
    protected const TITLE = 'this effector is abstract class';

    /**
     * Get title of this Effector.
     *
     * @return string
     */
    public function title(): string
    {
        return static::TITLE;
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
