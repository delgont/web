<?php

namespace Web\Concerns;

/**
 * Commands
 */
use Web\Console\Commands\WebInstallCommand;

trait RegistersCommands
{
    private function registerCommands() : void
    {
        $this->commands([
            WebInstallCommand::class
        ]);
    }
}