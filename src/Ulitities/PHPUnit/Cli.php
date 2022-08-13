<?php

namespace RemixUtilities\PHPUnit;

use Remix\Effector;

trait Cli
{
    public function capture(callable $callback)
    {
        ob_start();
        $callback();
        $output = ob_get_clean();
        return Effector::trimDecoration($output);
    }
}
