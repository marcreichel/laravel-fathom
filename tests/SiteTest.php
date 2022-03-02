<?php

namespace MarcReichel\LaravelFathom\Tests;

use Carbon\Carbon;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use MarcReichel\IGDBLaravel\Exceptions\InvalidParamsException;
use MarcReichel\LaravelFathom\Exceptions\EntityIdIsMissingException;
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
        Fathom::sites()->create(['name' => 'Laravel Fathom Test']);

        Http::assertSent(function (Request $request) {
            return $request->url() === 'https://api.usefathom.com/v1/sites' &&
                $request->method() === 'POST' &&
                Str::of($request->body())->contains('name=Laravel+Fathom+Test');
        });

        Fathom::sites()->create(['name' => 'Laravel Fathom Test', 'sharing' => 'private', 'share_password' => 'test']);

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

    /**
     * @test
     * @throws EntityIdIsMissingException
     */
    public function it_should_request_pageviews_aggregation(): void
    {
        $query = http_build_query(collect([
            'entity' => 'pageview',
            'entity_id' => 'CDBUGS',
            'aggregates' => 'visits',
        ])->filter()->toArray());

        Fathom::site('CDBUGS')
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
            'entity' => 'pageview',
            'entity_id' => 'CDBUGS',
            'aggregates' => 'visits',
            'date_grouping' => 'hour',
        ])->filter()->toArray());

        Fathom::site('CDBUGS')
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
            'entity' => 'pageview',
            'entity_id' => 'CDBUGS',
            'aggregates' => 'visits',
            'date_grouping' => 'day',
        ])->filter()->toArray());

        Fathom::site('CDBUGS')
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
            'entity' => 'pageview',
            'entity_id' => 'CDBUGS',
            'aggregates' => 'visits',
            'date_grouping' => 'month',
        ])->filter()->toArray());

        Fathom::site('CDBUGS')
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
            'entity' => 'pageview',
            'entity_id' => 'CDBUGS',
            'aggregates' => 'visits',
            'date_grouping' => 'year',
        ])->filter()->toArray());

        Fathom::site('CDBUGS')
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
            'entity' => 'pageview',
            'entity_id' => 'CDBUGS',
            'aggregates' => 'visits',
            'field_grouping' => 'referrer_hostname',
        ])->filter()->toArray());

        Fathom::site('CDBUGS')
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
            'entity' => 'pageview',
            'entity_id' => 'CDBUGS',
            'aggregates' => 'pageviews',
            'sort_by' => 'pageviews'
        ])->filter()->toArray());

        Fathom::site('CDBUGS')
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
            'entity' => 'pageview',
            'entity_id' => 'CDBUGS',
            'aggregates' => 'visits',
            'timezone' => 'Europe/Berlin',
        ])->filter()->toArray());

        Fathom::site('CDBUGS')
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
            'entity' => 'pageview',
            'entity_id' => 'CDBUGS',
            'aggregates' => 'visits',
            'date_from' => $timestamp,
        ])->filter()->toArray());

        Fathom::site('CDBUGS')
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
            'entity' => 'pageview',
            'entity_id' => 'CDBUGS',
            'aggregates' => 'visits',
            'date_to' => $timestamp,
        ])->filter()->toArray());

        Fathom::site('CDBUGS')
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
            'entity' => 'pageview',
            'entity_id' => 'CDBUGS',
            'aggregates' => 'visits',
            'limit' => 200,
        ])->filter()->toArray());

        Fathom::site('CDBUGS')
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
            'entity' => 'pageview',
            'entity_id' => 'CDBUGS',
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
            'entity' => 'pageview',
            'entity_id' => 'CDBUGS',
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

        Fathom::sites()->aggregate(['visits'])->get();
    }
}
