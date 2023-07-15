<?php

namespace Tusker\Framework\Cli;

use ReflectionClass;

abstract class Command
{
    /**
     * holds commands and command classes
     *
     * @var array<mixed, mixed>
     */
    private static array $commands = [];

    /**
     * abstract function run needs to be implimented if we extends Command
     *
     * @param CommandInput $input
     * @param CommandOutput $output
     * @return void
     */
    abstract protected function run(CommandInput $input, CommandOutput $output): void;

    /**
     * setup commands
     *
     * @param string $command
     * @param string $class
     * @param string $description
     * @return void
     */
    protected static function setup(string $command, string $class, string $description = ''): void
    {
        self::$commands[$command] = [
            'class' => $class,
            'description' => $description
        ];
    }

    /**
     * return command info
     *
     * @param string $command
     * @return array<mixed, mixed>|null
     */
    public static function get(string $command): ?array
    {
        return isset(self::$commands[$command]) ? self::$commands[$command] : null;
    }

    /**
     * use to rcall run method of command class while executing a command
     *
     * @param string $command
     * @return void
     */
    public static function call(string $command): void
    {
        $command = self::get($command);

        if (null !== $command) {
            $om = getObjectManager();
            $om->add($command['class']);
            $class = new ReflectionClass($command['class']);
            $method = $class->getMethod('run');
            $params = $om->getDependency($method);
            $command = $om->get($command['class']);
            $command->run(...$params);
        } else {
            self::help();
        }
    }

    /**
     * returns all command details
     *
     * @return void
     */
    public static function help(): void
    {
        /**
         * @var OutputText $outputText
         */
        $outputText = getObjectManager()->get(OutputText::class);

        echo "\r\n You are running Tusker PHP version: ". $outputText->getColoredString(env('APP_VERSION', '0.0.0'), 'green'). "\r\n";

        ksort(self::$commands);
        
        $maxLen = count(self::$commands) > 0 ? (max(array_map('strlen', array_keys(self::$commands))) + 2) : 0;
        $heading = '';

        foreach (self::$commands as $key => $command)
        {
            $keyPart = explode(':', $key);
            if ($heading !== $keyPart[0]) {
                echo "\r\n". $outputText->getColoredString($keyPart[0], 'blue');
                $heading = $keyPart[0];
            }

            echo "\r\n  ". $outputText->getColoredString($key, 'green') . str_repeat(" ", strlen($key) < $maxLen ? ($maxLen - strlen($key)) : 0). $outputText->getColoredString($command['description'], 'yellow');
        }

        echo "\r\n";
        
    }
}
