<?php

declare(strict_types=1);

namespace MarcReichel\LaravelFathom\Tests;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use MarcReichel\LaravelFathom\Fathom;

final class AccountTest extends TestCase
{
    public function test_it_should_request_account_data(): void
    {
        Fathom::account()->get();

        Http::assertSent(static function (Request $request) {
            return $request->url() === 'https://api.usefathom.com/v1/account';
        });
    }
}
