<?php

namespace MarcReichel\LaravelFathom;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http as LaravelHttp;

class Http
{
    public static function client(): PendingRequest
    {
        return LaravelHttp::withOptions([
            'base_uri' => 'https://api.usefathom.com/v1/',
        ])->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . config('fathom.api_token'),
        ]);
    }
}
