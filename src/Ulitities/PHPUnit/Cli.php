<?php

namespace RemixUtilities\PHPUnit;

use Remix\Effector;

trait Cli
{
    public function capture(callable $cb)
    {
        ob_start();
        $cb();
        $output = ob_get_clean();
        return Effector::trimDecoration($output);
    }
}
