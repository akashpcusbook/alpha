<?php

namespace Tusker\Framework;

use Tusker\Framework\Cli\CommandInput;
use Tusker\Framework\Cli\CommandOutput;
use Tusker\Framework\Cli\OutputText;
use Tusker\Framework\Mail\Email;
use Tusker\Framework\Parser\Env;
use Tusker\Framework\Request\HttpRequest;
use Tusker\Framework\Request\Server;
use Tusker\Framework\Router\Route;
use Tusker\Framework\Router\RouteResolver;
use Tusker\Framework\Support\Csrf;
use Tusker\Framework\Support\Language;

class Bootstrap
{
    /**
     * Bootstrap all core functionality
     *
     * @return void
     */
    public function load(): void
    {
        $objectManager = getObjectManager();

        $objectManager->add($this::class);
        $objectManager->add(Env::class);
        $objectManager->add(Language::class);
        $objectManager->add(Server::class);
        $objectManager->add(HttpRequest::class);
        $objectManager->add(Csrf::class);
        $objectManager->add(Email::class);
        $objectManager->add(Route::class);
        $objectManager->add(RouteResolver::class);

        $objectManager->add(OutputText::class);
        $objectManager->add(CommandOutput::class);
        $objectManager->add(CommandInput::class);

        $this->loadCommands();
    }

    /**
     * load all core commands
     *
     * @return void
     */
    private function loadCommands(): void
    {
        $commands = [
            \Tusker\Framework\Cli\Command\HelpCommand::class,
            \Tusker\Framework\Cli\Command\AppCommand::class,
        ];

        $objectManager = getObjectManager();

        foreach ($commands as $command)
        {
            $objectManager->add($command);
        }
    }
    
}
