<?php

namespace MarcReichel\LaravelFathom;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use MarcReichel\LaravelFathom\Console\InstallCommand;
use MarcReichel\LaravelFathom\Views\Components\FathomScript;

class LaravelFathomServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/fathom.php' => config_path('fathom.php'),
        ], 'fathom:config');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-fathom');

        Blade::component('fathom-script', FathomScript::class);

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/fathom.php', 'fathom'
        );
    }
}
