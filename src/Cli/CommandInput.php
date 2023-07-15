<?php

namespace Tusker\Framework\Cli;

class CommandInput
{
    public function __construct(private OutputText $outputText) {}

    /**
     * used to ask questions for cli and returns user input
     *
     * @param string $string
     * @param string $default
     * @return string
     */
    public function ask(string $string, string $default = ''): string
    {
        echo $this->outputText->getColoredString($string, 'white');
        if (!empty($default)) {
            echo $this->outputText->getColoredString(' ['.$default.']', 'yellow');
        }
        echo $this->outputText->getColoredString(' :', 'white');
        $line = $this->getCliInput();
        if (empty(trim($line))) {
            return $default;
        }

        return trim(trim($line, "\r\n"), " ");
    }

    /**
     * Undocumented function
     *
     * @param string $string
     * @param array<mixed, mixed> $options
     * @param string $default
     * @return string
     */
    public function choice(string $string, array $options = [], string $default = ''): string
    {
        $isList = array_is_list($options);

        foreach ($options as $key => $option)
        {
            if ($isList) {
                echo sprintf('%s: [%s]', ($key + 1), $option)."\r\n";
            } else {
                echo sprintf('%s: [%s]', $key, $option)."\r\n";
            }
        }

        $result = $this->ask($string, $default);

        if ($result === $default) {
            return $default;
        }
        
        if ($isList) {
            $result = (int)$result - 1;
        } else {
            $result = trim($result, "\r\n");
        }

        if (in_array($result, array_keys($options)) || empty(trim($result, ' '))) {
            return '' === trim($result, ' ') ? $default : $options[$result];
        }

        return $this->choice($string, $options, $default);
    }

    /**
     * get user input
     *
     * @return string
     */
    private function getCliInput(): string
    {
        $handle = fopen ("php://stdin","r");
        $cliInput = fgets($handle);
        fclose($handle);

        return $cliInput;
    }

    public function getCommand(): string
    {
        global $argv, $argc;

        if ($argc > 1) {
            $parts = explode(':', $argv[1]);
            return isset($parts[0]) ? $parts[0] : '';
        }

        return '';
    }

    public function getAction(): string
    {
        global $argv, $argc;

        if ($argc > 1) {
            $parts = explode(':', $argv[1]);
            return isset($parts[1]) ? $parts[1] : '';
        }

        return '';
    }
}
