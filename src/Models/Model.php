<?php

namespace MarcReichel\LaravelFathom\Models;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

abstract class Model
{
    protected PendingRequest $client;

    public function __construct()
    {
        $this->client = Http::withOptions([
            'base_uri' => 'https://api.usefathom.com/v1/',
        ])->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . config('fathom.api_token'),
        ]);
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
