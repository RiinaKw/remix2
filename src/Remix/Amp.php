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

                // find the classes of the command
                $dir = realpath(__DIR__ . '/Effectors');
                $this->findCommands($dir);

                $commands = [];
                foreach($this->findCommands($dir) as $file) {
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

                    // class name to command name
                    $arr = explode('\\', $class);
                    $command = strtolower(array_pop($arr));

                    // exists class?
                    $ns = '\\Remix\\Effectors\\';
                    $class_with_ns = $ns . $class;
                    if (! class_exists($class_with_ns)) {
                        throw new \Exception("class '{$class_with_ns}' not found");
                    }

                    // mapping class names and commands
                    $commands[$command] = $class_with_ns;
                }

                // show the title of command classes
                foreach ($commands as $command => $class) {
                    $effector = new ($class_with_ns)();

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

    /**
     * Recursively search command classes.
     *
     * @param string $dir
     * @return array<int, string>
     */
    private function findCommands(string $dir): array
    {
        if (! is_dir($dir)) {
            throw new \Exception("'{$dir}' is not directory");
        }
        $dir = realpath($dir);

        $files = [];
        $dh = opendir($dir);
        while (($file = readdir($dh)) !== false) {
            if (strpos($file, '.') === 0) {
                continue;
            }
            $path =realpath($dir . '/' . $file);
            if (is_dir($path)) {
                $arr = $this->findCommands($path);
                $files += $arr;
            } else {
                $files[] = realpath($dir . '/' . $file);
            }
        }
        closedir($dh);

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
