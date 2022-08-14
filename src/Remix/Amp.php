<?php

namespace Remix;

use Remix\Exceptions\RemixRuntimeException;
use Throwable;

/**
 * Remix Amp : command line interface.
 *
 * @package Remix\Cli
 */
class Amp
{
    /**
     * Play the Effector specified by the command.
     *
     * @param array $argv
     * @return integer
     */
    public function play(array $argv): int
    {
        try {
            array_shift($argv);

            $command = array_shift($argv);

            if ($command === null) {
                (new Effectors\Version())->index();
                echo "\n\n";
                echo Effector::decorate('Available commands', 'yellow'). "\n";

                foreach($this->findCommands(__DIR__ . '/Effectors') as $command => $class) {
                    $effector = new $class();
                    echo '  ' . Effector::decorate($command, 'green', '', 'bold'). "\n";
                    echo '    ' . $effector->title() . "\n";
                }
                return 0;
            }

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

            if (! is_callable([$effector, $method])) {
                throw new RemixRuntimeException("command '{$command}' not exists");
            }

            $args = $this->parseArguments($argv);

            $result = $effector->$method($args);
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

    private function findCommands(string $dir)
    {
        foreach (glob($dir . '/*.php') as $file) {
            $filename = ucfirst(basename($file));
            $classname = explode('.', $filename)[0];
            $class = '\\Remix\\Effectors\\' . $classname;

            $command = strtolower($classname);

            $commands[$command] = $class;
        }
        return $commands;
    }

    /**
     * Parse the arguments of the command.
     *
     * @param array $argv
     * @return array<string, array>
     */
    private function parseArguments(array $argv): array
    {
        $args = [];
        $switches = [];
        foreach ($argv as $arg) {
            if (strpos($arg, '--') === 0) {
                list($key, $value) = explode('=', ltrim($arg, '-'), 2);
                $args[$key] = $value;
            } else if (strpos($arg, '-') === 0) {
                $switch = ltrim($arg, '-');
                if (strlen($switch) > 1) {
                    throw new RemixRuntimeException("switch '{$arg}' not acceptable");
                }
                $switches[] = $switch;
            }
        }

        return [
            'args' => $args,
            'switches' => $switches,
        ];
    }
}
