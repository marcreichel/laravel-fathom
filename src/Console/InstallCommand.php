<?php

namespace MarcReichel\LaravelFathom\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'fathom:install';

    protected $description = 'Publish the Laravel Fathom configuration.';

    public function handle(): int
    {
        return $this->call('vendor:publish', ['--tag' => 'fathom:config', '--force' => true]);
    }
}
