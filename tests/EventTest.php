<?php

namespace MarcReichel\LaravelFathom\Tests;

use Carbon\Carbon;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use MarcReichel\LaravelFathom\Exceptions\EntityIdIsMissingException;
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
        Fathom::site('CDBUGS')->events()->create(['name' => 'Registered for early access']);

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

    /**
     * @test
     * @throws EntityIdIsMissingException
     */
    public function it_should_request_event_aggregation(): void
    {
        $query = http_build_query(collect([
            'entity' => 'event',
            'entity_id' => 'signed-up-for-newsletter',
            'aggregates' => 'visits',
        ])->filter()->toArray());

        Fathom::site('CDBUGS')
            ->event('signed-up-for-newsletter')
            ->aggregate(['visits'])
            ->get();

        Http::assertSent(function (Request $request) use ($query) {
            return Str::of($request->url())->startsWith('https://api.usefathom.com/v1/aggregations') &&
                Str::of($request->url())->contains($query);
        });
    }

    /**
     * @test
     * @throws EntityIdIsMissingException
     */
    public function it_should_request_pageviews_aggregation_grouped_by_hour(): void
    {
        $query = http_build_query(collect([
            'entity' => 'event',
            'entity_id' => 'signed-up-for-newsletter',
            'aggregates' => 'visits',
            'date_grouping' => 'hour',
        ])->filter()->toArray());

        Fathom::site('CDBUGS')
            ->event('signed-up-for-newsletter')
            ->aggregate(['visits'])
            ->groupByHour()
            ->get();

        Http::assertSent(function (Request $request) use ($query) {
            return Str::of($request->url())->startsWith('https://api.usefathom.com/v1/aggregations') &&
                Str::of($request->url())->contains($query);
        });
    }

    /**
     * @test
     * @throws EntityIdIsMissingException
     */
    public function it_should_request_pageviews_aggregation_grouped_by_day(): void
    {
        $query = http_build_query(collect([
            'entity' => 'event',
            'entity_id' => 'signed-up-for-newsletter',
            'aggregates' => 'visits',
            'date_grouping' => 'day',
        ])->filter()->toArray());

        Fathom::site('CDBUGS')
            ->event('signed-up-for-newsletter')
            ->aggregate(['visits'])
            ->groupByDay()
            ->get();

        Http::assertSent(function (Request $request) use ($query) {
            return Str::of($request->url())->startsWith('https://api.usefathom.com/v1/aggregations') &&
                Str::of($request->url())->contains($query);
        });
    }

    /**
     * @test
     * @throws EntityIdIsMissingException
     */
    public function it_should_request_pageviews_aggregation_grouped_by_month(): void
    {
        $query = http_build_query(collect([
            'entity' => 'event',
            'entity_id' => 'signed-up-for-newsletter',
            'aggregates' => 'visits',
            'date_grouping' => 'month',
        ])->filter()->toArray());

        Fathom::site('CDBUGS')
            ->event('signed-up-for-newsletter')
            ->aggregate(['visits'])
            ->groupByMonth()
            ->get();

        Http::assertSent(function (Request $request) use ($query) {
            return Str::of($request->url())->startsWith('https://api.usefathom.com/v1/aggregations') &&
                Str::of($request->url())->contains($query);
        });
    }

    /**
     * @test
     * @throws EntityIdIsMissingException
     */
    public function it_should_request_pageviews_aggregation_grouped_by_year(): void
    {
        $query = http_build_query(collect([
            'entity' => 'event',
            'entity_id' => 'signed-up-for-newsletter',
            'aggregates' => 'visits',
            'date_grouping' => 'year',
        ])->filter()->toArray());

        Fathom::site('CDBUGS')
            ->event('signed-up-for-newsletter')
            ->aggregate(['visits'])
            ->groupByYear()
            ->get();

        Http::assertSent(function (Request $request) use ($query) {
            return Str::of($request->url())->startsWith('https://api.usefathom.com/v1/aggregations') &&
                Str::of($request->url())->contains($query);
        });
    }

    /**
     * @test
     * @throws EntityIdIsMissingException
     */
    public function it_should_request_pageviews_aggregation_grouped_by_field(): void
    {
        $query = http_build_query(collect([
            'entity' => 'event',
            'entity_id' => 'signed-up-for-newsletter',
            'aggregates' => 'visits',
            'field_grouping' => 'referrer_hostname',
        ])->filter()->toArray());

        Fathom::site('CDBUGS')
            ->event('signed-up-for-newsletter')
            ->aggregate(['visits'])
            ->groupByField('referrer_hostname')
            ->get();

        Http::assertSent(function (Request $request) use ($query) {
            return Str::of($request->url())->startsWith('https://api.usefathom.com/v1/aggregations') &&
                Str::of($request->url())->contains($query);
        });
    }

    /**
     * @test
     * @throws EntityIdIsMissingException
     */
    public function it_should_request_pageviews_aggregation_ordered_by_pageviews(): void
    {
        $query = http_build_query(collect([
            'entity' => 'event',
            'entity_id' => 'signed-up-for-newsletter',
            'aggregates' => 'pageviews',
            'sort_by' => 'pageviews'
        ])->filter()->toArray());

        Fathom::site('CDBUGS')
            ->event('signed-up-for-newsletter')
            ->aggregate(['pageviews'])
            ->orderBy('pageviews')
            ->get();

        Http::assertSent(function (Request $request) use ($query) {
            return Str::of($request->url())->startsWith('https://api.usefathom.com/v1/aggregations') &&
                Str::of($request->url())->contains($query);
        });
    }

    /**
     * @test
     * @throws EntityIdIsMissingException
     */
    public function it_should_request_pageviews_aggregation_with_other_timezone(): void
    {
        $query = http_build_query(collect([
            'entity' => 'event',
            'entity_id' => 'signed-up-for-newsletter',
            'aggregates' => 'visits',
            'timezone' => 'Europe/Berlin',
        ])->filter()->toArray());

        Fathom::site('CDBUGS')
            ->event('signed-up-for-newsletter')
            ->aggregate(['visits'])
            ->timezone('Europe/Berlin')
            ->get();

        Http::assertSent(function (Request $request) use ($query) {
            return Str::of($request->url())->startsWith('https://api.usefathom.com/v1/aggregations') &&
                Str::of($request->url())->contains($query);
        });
    }

    /**
     * @test
     * @throws EntityIdIsMissingException
     */
    public function it_should_request_pageviews_aggregation_from_date(): void
    {
        $timestamp = Carbon::now()->timestamp;
        $query = http_build_query(collect([
            'entity' => 'event',
            'entity_id' => 'signed-up-for-newsletter',
            'aggregates' => 'visits',
            'date_from' => $timestamp,
        ])->filter()->toArray());

        Fathom::site('CDBUGS')
            ->event('signed-up-for-newsletter')
            ->aggregate(['visits'])
            ->fromDate((string) $timestamp)
            ->get();

        Http::assertSent(function (Request $request) use ($query) {
            return Str::of($request->url())->startsWith('https://api.usefathom.com/v1/aggregations') &&
                Str::of($request->url())->contains($query);
        });
    }

    /**
     * @test
     * @throws EntityIdIsMissingException
     */
    public function it_should_request_pageviews_aggregation_to_date(): void
    {
        $timestamp = Carbon::now()->timestamp;
        $query = http_build_query(collect([
            'entity' => 'event',
            'entity_id' => 'signed-up-for-newsletter',
            'aggregates' => 'visits',
            'date_to' => $timestamp,
        ])->filter()->toArray());

        Fathom::site('CDBUGS')
            ->event('signed-up-for-newsletter')
            ->aggregate(['visits'])
            ->toDate((string) $timestamp)
            ->get();

        Http::assertSent(function (Request $request) use ($query) {
            return Str::of($request->url())->startsWith('https://api.usefathom.com/v1/aggregations') &&
                Str::of($request->url())->contains($query);
        });
    }

    /**
     * @test
     * @throws EntityIdIsMissingException
     */
    public function it_should_request_pageviews_aggregation_with_limit(): void
    {
        $query = http_build_query(collect([
            'entity' => 'event',
            'entity_id' => 'signed-up-for-newsletter',
            'aggregates' => 'visits',
            'limit' => 200,
        ])->filter()->toArray());

        Fathom::site('CDBUGS')
            ->event('signed-up-for-newsletter')
            ->aggregate(['visits'])
            ->limit(200)
            ->get();

        Http::assertSent(function (Request $request) use ($query) {
            return Str::of($request->url())->startsWith('https://api.usefathom.com/v1/aggregations') &&
                Str::of($request->url())->contains($query);
        });
    }

    /**
     * @test
     * @throws EntityIdIsMissingException
     */
    public function it_should_request_pageviews_aggregation_with_filter(): void
    {
        $query = http_build_query(collect([
            'entity' => 'event',
            'entity_id' => 'signed-up-for-newsletter',
            'aggregates' => 'visits',
            'filters' => collect([
                [
                    'property' => 'pathname',
                    'operator' => 'is',
                    'value' => '/pricing',
                ],
            ])->toJson()
        ])->filter()->toArray());

        Fathom::site('CDBUGS')
            ->event('signed-up-for-newsletter')
            ->aggregate(['visits'])
            ->where('pathname', 'is', '/pricing')
            ->get();

        Http::assertSent(function (Request $request) use ($query) {
            return Str::of($request->url())->startsWith('https://api.usefathom.com/v1/aggregations') &&
                Str::of($request->url())->contains($query);
        });
    }

    /**
     * @test
     * @throws EntityIdIsMissingException
     */
    public function it_should_request_pageviews_aggregation_with_multiple_filters(): void
    {
        $query = http_build_query(collect([
            'entity' => 'event',
            'entity_id' => 'signed-up-for-newsletter',
            'aggregates' => 'visits',
            'filters' => collect([
                [
                    'property' => 'pathname',
                    'operator' => 'is',
                    'value' => '/pricing',
                ],
                [
                    'property' => 'pathname',
                    'operator' => 'is not',
                    'value' => '/login',
                ],
            ])->toJson()
        ])->filter()->toArray());

        Fathom::site('CDBUGS')
            ->event('signed-up-for-newsletter')
            ->aggregate(['visits'])
            ->where('pathname', 'is', '/pricing')
            ->where('pathname', 'is not', '/login')
            ->get();

        Http::assertSent(function (Request $request) use ($query) {
            return Str::of($request->url())->startsWith('https://api.usefathom.com/v1/aggregations') &&
                Str::of($request->url())->contains($query);
        });
    }

    /** @test */
    public function it_should_throw_exception_when_id_is_missing(): void
    {
        $this->expectException(EntityIdIsMissingException::class);

        Fathom::site('CDBUGS')->events()->aggregate(['visits'])->get();
    }
}
