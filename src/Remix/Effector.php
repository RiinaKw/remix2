<?php

namespace Remix;

abstract class Effector
{
    protected const TITLE = 'this eccector is abstract class';

    public function title(): string
    {
        return static::TITLE;
    }
}
