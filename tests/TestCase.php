<?php

declare(strict_types=1);

namespace MarcReichel\LaravelFathom\Tests;

use Illuminate\Support\Facades\Http;
use MarcReichel\LaravelFathom\LaravelFathomServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Http::fake([
            '*' => Http::response(),
        ]);
    }

    protected function getPackageProviders($app): array
    {
        return [
            LaravelFathomServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        // perform environment setup
    }
}
