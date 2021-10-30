<?php

namespace MarcReichel\LaravelFathom;

use Illuminate\Support\ServiceProvider;

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
        ]);
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
