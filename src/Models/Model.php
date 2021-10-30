<?php

namespace MarcReichel\LaravelFathom\Models;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use MarcReichel\LaravelFathom\Http;

abstract class Model
{
    protected PendingRequest $client;

    public function __construct()
    {
        $this->client = Http::client();
    }

    protected function resolveResponse(Response $response, string $cacheKey = null)
    {
        if (!$cacheKey) {
            return $response->json();
        }

        return Cache::remember($cacheKey, 3600, function () use ($response) {
            return $response->json();
        });
    }
}
