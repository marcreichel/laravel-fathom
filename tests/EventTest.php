<?php

namespace MarcReichel\LaravelFathom\Tests;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use MarcReichel\LaravelFathom\Fathom;

class EventTest extends TestCase
{
    /** @test */
    public function it_should_request_all_events(): void
    {
        Fathom::site('CDBUGS')->events()->get();

        Http::assertSent(function (Request $request) {
            return $request->url() === 'https://api.usefathom.com/v1/sites/CDBUGS/events' &&
                $request->method() === 'GET';
        });
    }

    /** @test */
    public function it_should_request_events_with_limit(): void
    {
        Fathom::site('CDBUGS')->events()->limit(20)->get();

        Http::assertSent(function (Request $request) {
            return $request->url() === 'https://api.usefathom.com/v1/sites/CDBUGS/events?limit=20' &&
                $request->method() === 'GET';
        });
    }

    /** @test */
    public function it_should_request_events_after_a_specific_cursor(): void
    {
        Fathom::site('CDBUGS')->events()->after('registered-for-early-access')->get();

        Http::assertSent(function (Request $request) {
            return $request->url() === 'https://api.usefathom.com/v1/sites/CDBUGS/events?starting_after=registered-for-early-access' &&
                $request->method() === 'GET';
        });
    }

    /** @test */
    public function it_should_request_events_before_a_specific_cursor(): void
    {
        Fathom::site('CDBUGS')->events()->before('registered-for-early-access')->get();

        Http::assertSent(function (Request $request) {
            return $request->url() === 'https://api.usefathom.com/v1/sites/CDBUGS/events?ending_before=registered-for-early-access' &&
                $request->method() === 'GET';
        });
    }

    /** @test */
    public function it_should_request_to_create_a_new_event(): void
    {
        Fathom::site('CDBUGS')->events()->create('Registered for early access');

        Http::assertSent(function (Request $request) {
            return $request->url() === 'https://api.usefathom.com/v1/sites/CDBUGS/events' &&
                $request->method() === 'POST' &&
                Str::of($request->body())->contains('name=Registered+for+early+access');
        });
    }

    /** @test */
    public function it_should_request_a_specific_event(): void
    {
        Fathom::site('CDBUGS')->event('signed-up-for-newsletter')->get();

        Http::assertSent(function (Request $request) {
            return $request->url() === 'https://api.usefathom.com/v1/sites/CDBUGS/events/signed-up-for-newsletter' &&
                $request->method() === 'GET';
        });
    }

    /** @test */
    public function it_should_request_to_update_an_event(): void
    {
        Fathom::site('CDBUGS')->event('signed-up-for-newsletter')->update([
            'name' => 'Signed up for newsletter',
        ]);

        Http::assertSent(function (Request $request) {
            return $request->url() === 'https://api.usefathom.com/v1/sites/CDBUGS/events/signed-up-for-newsletter' &&
                $request->method() === 'POST' &&
                Str::of($request->body())->contains('name=Signed+up+for+newsletter');
        });
    }

    /** @test */
    public function it_should_request_to_wipe_an_event(): void
    {
        Fathom::site('CDBUGS')->event('signed-up-for-newsletter')->wipe();

        Http::assertSent(function (Request $request) {
            return $request->url() === 'https://api.usefathom.com/v1/sites/CDBUGS/events/signed-up-for-newsletter/data' &&
                $request->method() === 'DELETE';
        });
    }

    /** @test */
    public function it_should_request_to_delete_an_event(): void
    {
        Fathom::site('CDBUGS')->event('signed-up-for-newsletter')->delete();

        Http::assertSent(function (Request $request) {
            return $request->url() === 'https://api.usefathom.com/v1/sites/CDBUGS/events/signed-up-for-newsletter' &&
                $request->method() === 'DELETE';
        });
    }
}