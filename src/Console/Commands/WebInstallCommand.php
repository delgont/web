<?php

namespace Web\Console\Commands;

use Illuminate\Console\Command;

class WebInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'web:install
                            {--fresh : Fresh installation or setup}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $fresh = false;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $fresh = ($this->option('fresh')) ? true : false;

        $this->call('vendor:publish', ['--tag' => 'delgont-web-config', '--force' => $fresh]);
        $this->call('vendor:publish', ['--tag' => 'delgont-web-data-config', '--force' => $fresh]);
        $this->call('vendor:publish', ['--tag' => 'delgont-web-images', '--force' => $fresh]);
    }

}
