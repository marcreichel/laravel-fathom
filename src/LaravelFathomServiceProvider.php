<?php

namespace MarcReichel\LaravelFathom;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use MarcReichel\LaravelFathom\Views\Components\FathomTrackingCode;

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
        ], 'fathom-config');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-fathom');


        Blade::component('fathom-tracking-code', FathomTrackingCode::class);
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
