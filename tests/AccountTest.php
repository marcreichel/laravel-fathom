<?php

namespace MarcReichel\LaravelFathom\Tests;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use MarcReichel\LaravelFathom\Fathom;

class AccountTest extends TestCase
{
    /** @test */
    public function it_should_request_account_data(): void
    {
        Fathom::account()->get();

        Http::assertSent(function (Request $request) {
            return $request->url() === 'https://api.usefathom.com/v1/account';
        });
    }
}
