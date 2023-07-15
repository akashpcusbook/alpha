<?php

namespace Tusker\Framework\Cli\Command;

use Tusker\Framework\Cli\Command;
use Tusker\Framework\Cli\CommandInput;
use Tusker\Framework\Cli\CommandOutput;

class AppCommand extends Command
{
    public function __construct()
    {
        self::setup('app:version', self::class, 'shows Tusker app version');
        self::setup('app:generate-secret-key', self::class, 'Generate sectret key for api authentication');
    }

    public function run(CommandInput $input, CommandOutput $output): void
    {
        $action = $input->getAction();

        match ($action) {
            'version' => $this->version($output),
            'generate-secret-key' => $this->generateSecretKey($output),
            default => '',
        };
    }

    /**
     * serve as version action for app command
     *
     * @param CommandOutput $output
     * @return void
     */
    private function version(CommandOutput $output): void
    {
        $output->text('Version: ');
        $output->textSuccess(env('APP_VERSION', '0.0.0'));
        $output->newLine();
    }

    private function generateSecretKey(CommandOutput $output): void
    {
        $secret = bin2hex(random_bytes(32));
        $output->text('Secret Key: ');
        $output->textSuccess($secret);
        $output->newLine();
        $output->success('Secret key generated successfully');
        $output->newLine();
    }
}