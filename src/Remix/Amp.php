<?php

namespace Remix;

use Remix\Exceptions\RemixException;

class Amp
{
    public function play(array $argv): int
    {
        try {
            array_shift($argv);

            $command = array_shift($argv);
            $class = '\\Remix\\Effectors\\' . ucfirst($command);

            if (! class_exists($class)) {
                throw new RemixException("command '{$command}' not exists");
            }

            $effector = new $class();
            $result = $effector->index();
            echo "\n";
            return $result;
        } catch (\Throwable $e) {
            echo Effector::decorate($e->getMessage(), '', 'red', 'bold');
            echo "\n";
            return 1;
        }
    }
}
