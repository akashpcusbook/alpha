<?php

namespace Tusker\Framework\Cli\Command;

use Tusker\Framework\Cli\Command;
use Tusker\Framework\Cli\CommandInput;
use Tusker\Framework\Cli\CommandOutput;

class HelpCommand extends Command
{
    public function __construct()
    {
        self::setup('app:help', self::class, 'shows command line help for commands');
    }

    public function run(CommandInput $input, CommandOutput $output): void
    {
        parent::help();
    }
}
