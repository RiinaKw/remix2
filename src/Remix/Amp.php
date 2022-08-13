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

            if (strpos($command, ':') !== false) {
                list($class, $method) = explode(':', $command, 2);;
            } else {
                $class = $command;
                $method = 'index';
            }
            $class = '\\Remix\\Effectors\\' . ucfirst($class);

            if (! class_exists($class)) {
                throw new RemixRuntimeException("command '{$command}' not exists");
            }
            $effector = new $class();

            if (! method_exists($effector, $method)) {
                throw new RemixRuntimeException("command '{$command}' not exists");
            }

            $result = $effector->$method();
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
