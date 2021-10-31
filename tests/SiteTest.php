<?php

namespace MarcReichel\LaravelFathom\Tests;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use MarcReichel\LaravelFathom\Fathom;

class SiteTest extends TestCase
{
    /** @test */
    public function it_should_request_all_sites(): void
    {
        Fathom::sites()->get();

        Http::assertSent(function (Request $request) {
            return $request->url() === 'https://api.usefathom.com/v1/sites' && $request->method() === 'GET';
        });
    }

    /** @test */
    public function it_should_request_sites_with_limit(): void
    {
        Fathom::sites()->limit(20)->get();

        Http::assertSent(function (Request $request) {
            return $request->url() === 'https://api.usefathom.com/v1/sites?limit=20' && $request->method() === 'GET';
        });
    }

    /** @test */
    public function it_should_request_sites_after_a_specific_cursor(): void
    {
        Fathom::sites()->after('CDBUGS')->get();

        Http::assertSent(function (Request $request) {
            return $request->url() === 'https://api.usefathom.com/v1/sites?starting_after=CDBUGS' && $request->method() === 'GET';
        });
    }

    /** @test */
    public function it_should_request_sites_before_a_specific_cursor(): void
    {
        Fathom::sites()->before('CDBUGS')->get();

        Http::assertSent(function (Request $request) {
            return $request->url() === 'https://api.usefathom.com/v1/sites?ending_before=CDBUGS' && $request->method() === 'GET';
        });
    }

    /** @test */
    public function it_should_request_a_specific_site(): void
    {
        Fathom::site('CDBUGS')->get();

        Http::assertSent(function (Request $request) {
            return $request->url() === 'https://api.usefathom.com/v1/sites/CDBUGS' && $request->method() === 'GET';
        });

        Fathom::site('ABCDEF')->get();

        Http::assertSent(function (Request $request) {
            return $request->url() === 'https://api.usefathom.com/v1/sites/ABCDEF' && $request->method() === 'GET';
        });
    }

    /** @test */
    public function it_should_request_to_create_a_new_site(): void
    {
        Fathom::sites()->create('Laravel Fathom Test');

        Http::assertSent(function (Request $request) {
            return $request->url() === 'https://api.usefathom.com/v1/sites' &&
                $request->method() === 'POST' &&
                Str::of($request->body())->contains('name=Laravel+Fathom+Test');
        });

        Fathom::sites()->create('Laravel Fathom Test', 'private', 'test');

        Http::assertSent(function (Request $request) {
            return $request->url() === 'https://api.usefathom.com/v1/sites' &&
                $request->method() === 'POST' &&
                Str::of($request->body())->contains('name=Laravel+Fathom+Test') &&
                Str::of($request->body())->contains('sharing=private') &&
                Str::of($request->body())->contains('share_password=test');
        });
    }

    /** @test */
    public function it_should_request_site_update(): void
    {
        Fathom::site('CDBUGS')->update([
            'name' => 'Acme Holding Inc',
        ]);

        Http::assertSent(function (Request $request) {
            return $request->url() === 'https://api.usefathom.com/v1/sites/CDBUGS' &&
                $request->method() === 'POST' &&
                Str::of($request->body())->contains('name=Acme+Holding+Inc');
        });

        Fathom::site('CDBUGS')->update([
            'sharing' => 'private',
            'share_password' => 'secret',
        ]);

        Http::assertSent(function (Request $request) {
            return $request->url() === 'https://api.usefathom.com/v1/sites/CDBUGS' &&
                $request->method() === 'POST' &&
                Str::of($request->body())->contains('sharing=private') &&
                Str::of($request->body())->contains('share_password=secret');
        });
    }

    /** @test */
    public function it_should_request_site_wipe(): void
    {
        Fathom::site('CDBUGS')->wipe();

        Http::assertSent(function (Request $request) {
            return $request->url() === 'https://api.usefathom.com/v1/sites/CDBUGS/data' &&
                $request->method() === 'DELETE';
        });
    }

    /** @test */
    public function it_should_request_to_delete_a_site(): void
    {
        Fathom::site('CDBUGS')->delete();

        Http::assertSent(function (Request $request) {
            return $request->url() === 'https://api.usefathom.com/v1/sites/CDBUGS' &&
                $request->method() === 'DELETE';
        });
    }

    /** @test */
    public function it_should_request_current_visitors_of_a_site(): void
    {
        Fathom::site('CDBUGS')->currentVisitors();

        Http::assertSent(function (Request $request) {
            return $request->url() === 'https://api.usefathom.com/v1/current_visitors?site_id=CDBUGS' &&
                $request->method() === 'GET';
        });
    }
}
