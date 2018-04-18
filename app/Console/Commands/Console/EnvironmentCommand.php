<?php

namespace App\Console\Commands\Console;

use Illuminate\Console\Command;

class EnvironmentCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'env';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display the current framework environment';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->line('<info>Current application environment:</info> <comment>'.laravelToLumen($this->laravel)['env'].'</comment>');
    }
}
