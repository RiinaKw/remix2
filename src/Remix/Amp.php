<?php

namespace Remix;

use Remix\Exceptions\RemixRuntimeException;
use Remix\Exceptions\RemixLogicException;
use Throwable;

/**
 * Remix Amp : command line interface.
 *
 * @package Remix\Cli
 */
class Amp
{
    private $commands = [];

    private const EFFECTORS_DIR = __DIR__ . '/Effectors';
    private const EFFECTOR_NAMESPACE = '\\Remix\\Effectors\\';

    public function __construct()
    {
        $dir = realpath(static::EFFECTORS_DIR);

        foreach ($this->findCommands($dir) as $file) {
            // is it the php file?
            if (substr($file, -4) !== '.php') {
                continue;
            }
            // trim directory path and first slash
            $class = substr($file, strlen($dir) + 1);
            // trim extensioin
            $class = substr($class, 0, -4);
            // slash to backslash
            $class = str_replace('/', '\\', $class);

            // exists class?
            $class_with_ns = static::EFFECTOR_NAMESPACE . $class;
            if (! class_exists($class_with_ns)) {
                throw new RemixLogicException("class '{$class_with_ns}' not found");
            }

            // mapping class names and commands
            $arr = explode('\\', $class);
            $command = strtolower(array_pop($arr));
            $this->commands[$command] = $class_with_ns;
        }
    }

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
                echo Effector::decorate('Available commands', 'yellow') . "\n";

                // show the title of command classes
                foreach ($this->commands as $command => $class) {
                    $effector = new $class();

                    echo '  ' . Effector::decorate($command, 'green', '', 'bold') . "\n";
                    echo '    ' . $effector->title() . "\n";
                }
                return 0;
            }

            if (strpos($command, ':') !== false) {
                list($class, $method) = explode(':', $command, 2);
            } else {
                $class = $command;
                $method = 'index';
            }

            // is it mapped?
            if (! array_key_exists($class, $this->commands)) {
                throw new RemixRuntimeException("command '{$class}' not exists");
            }

            // class is already guaranteed to exist
            $class_name = $this->commands[$class];
            $effector = new $class_name();

            // exists method?
            if (! is_callable([$effector, $method])) {
                throw new RemixRuntimeException("command '{$command}' not exists");
            }

            // parse command arguments
            $args = $this->parseArguments($argv);

            // play it loud
            $result = $effector->$method($args);
            echo "\n";
            return $result;
        } catch (Throwable $e) {
            if ($e instanceof RemixRuntimeException) {
                // runtime error, e.g. wrong command name
                echo Effector::decorate($e->getMessage(), '', 'red', 'bold');
                echo "\n";
                return 1;
            } else {
                throw $e;
            }
        }
    }

    /**
     * Recursively search command classes.
     *
     * @param string $dir
     * @return array<int, string>
     */
    private function findCommands(string $dir): array
    {
        if (! is_dir($dir)) {
            throw new RemixLogicException("'{$dir}' is not directory");
        }
        $dir = realpath($dir);

        $files = [];
        $handler = opendir($dir);
        while (($file = readdir($handler)) !== false) {
            if (strpos($file, '.') === 0) {
                continue;
            }
            $path = realpath($dir . '/' . $file);
            if (is_dir($path)) {
                $arr = $this->findCommands($path);
                $files += $arr;
            } else {
                $files[] = realpath($dir . '/' . $file);
            }
        }
        closedir($handler);

        return $files;
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
            } elseif (strpos($arg, '-') === 0) {
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
