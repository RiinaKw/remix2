<?php

namespace Remix;

use RemixUtilities\Cli;
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
    private $effectors_dir = __DIR__ . '/Effectors';
    private $effectors_namespace = '\\Remix\\Effectors\\';

    /**
     * Create a mapping between command names and class names.
     *
     * @return array
     */
    private function mapCommand(): array
    {
        $commands = [];
        foreach ($this->findCommands($this->effectors_dir) as $file) {
            // is it the php file?
            if (substr($file, -4) !== '.php') {
                continue;
            }
            // trim directory path and first slash
            $class = substr($file, strlen($this->effectors_dir) + 1);
            // trim extensioin
            $class = substr($class, 0, -4);
            // slash to backslash
            $class = str_replace('/', '\\', $class);

            // exists class?
            $class_with_ns = $this->effectors_namespace . $class;
            if (! class_exists($class_with_ns)) {
                throw new RemixLogicException("class '{$class_with_ns}' not found");
            }

            // mapping class names and commands
            $arr = explode('\\', $class);
            $command = strtolower(array_pop($arr));
            $commands[$command] = $class_with_ns;
        }
        return $commands;
    }

    /**
     * Show details of available subcommands
     *
     * @param string $command
     * @param string $class
     * @return void
     */
    protected function showSubcommands(string $command, string $class)
    {
        $effector = new $class();
        foreach ($effector->available() as $subcommand => $description) {
            $name = Cli::decorate($command . ($subcommand ? ':' . $subcommand : ''), 'yellow', '', 'bold');
            Cli::line("    {$name} : {$description}");
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
            // load commands
            $commands = $this->mapCommand();

            // get a command
            $command = array_shift($argv);

            // if no argument is given, show the command list
            if ($command === null) {
                (new Effectors\Version())->index();
                Cli::line();
                Cli::lineDecorate('Available commands', 'yellow');

                // show the details of command classes
                foreach ($commands as $command => $class) {
                    Cli::lineDecorate('  ' . $command, 'green', '', 'bold');
                    $this->showSubcommands($command, $class);
                }
                return 0;
            }

            // split into command name and method
            if (strpos($command, ':') !== false) {
                list($class, $method) = explode(':', $command, 2);
            } else {
                $class = $command;
                $method = 'index';
            }

            // is it mapped?
            if (! array_key_exists($class, $commands)) {
                throw new RemixRuntimeException("command '{$class}' not exists");
            }

            // class is already guaranteed to exist
            $class_name = $commands[$class];
            $effector = new $class_name();

            // exists method?
            if (! is_callable([$effector, $method])) {
                throw new RemixRuntimeException("command '{$command}' not exists");
            }

            // parse command arguments
            $args = $this->parseArguments($argv);

            // play it loud
            return $effector->$method($args);
        } catch (Throwable $e) {
            if ($e instanceof RemixRuntimeException) {
                // runtime error, e.g. wrong command name
                Cli::lineDecorate($e->getMessage(), 'red', '', 'bold');
                return 1;
            } elseif ($e instanceof RemixLogicException) {
                // I think I made an implementation error somewhere...
                $message = Cli::decorate('Internal fatal error in Remix', '', 'red', 'bold') . '' . Cli::decorate($e->getMessage(), 'red');
                Cli::line($message);
                Cli::lineDecorate('If you see this error, please report it.', 'red', '');
                Cli::line();
            }
            throw $e;
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
