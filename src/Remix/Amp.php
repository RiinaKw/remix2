<?php

namespace Remix;

use Remix\Exceptions\RemixRuntimeException;
use Throwable;

class Amp
{
    public function play(array $argv): int
    {
        try {
            array_shift($argv);

            $command = array_shift($argv);
            $class = '\\Remix\\Effectors\\' . ucfirst($command);

            if (! class_exists($class)) {
                throw new RemixRuntimeException("command '{$command}' not exists");
            }

            $effector = new $class();
            $result = $effector->index();
            echo "\n";
            return $result;
        } catch (Throwable $e) {
            if ($e instanceof RemixRuntimeException) {
                echo Effector::decorate($e->getMessage(), '', 'red', 'bold');
                echo "\n";
                return 1;
            } else {
                throw $e;
            }
        }
    }
}
