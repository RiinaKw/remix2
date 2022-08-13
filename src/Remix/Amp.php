<?php

namespace Remix;

class Amp
{
    public function play(array $argv): int
    {
        array_shift($argv);

        $command = array_shift($argv);
        $class = '\\Remix\\Effectors\\' . ucfirst($command);

        if (! class_exists($class)) {
            echo Effector::decorate("command '{$command}' not exists", '', 'red', 'bold');
            echo "\n";
            return 1;
        }

        $effector = new $class();
        return $effector->index();
    }
}
