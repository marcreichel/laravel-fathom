<?php

namespace MarcReichel\LaravelFathom;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Fathom
{
    protected PendingRequest $client;

    public function __construct()
    {
        $this->client = Http::withOptions([
            'base_uri' => 'https://api.usefathom.com/v1/'
        ])->withHeaders([
            'Accept' => 'application/json',
            'Client-ID' => config('fathom.api_token'),
        ]);
    }

    public static function account()
    {
        $self = new static;
        return $self->resolveResponse($self->client->get('account'), 'account');
    }

    public static function sites(int $limit = null, string $starting_after = null, string $ending_before = null)
    {
        // TODO: Implement cursor pagination
        $self = new static;
        return $self->resolveResponse($self->client->get('sites'), 'sites');
    }

    public static function site(string $id)
    {
        $self = new static;
        return $self->resolveResponse($self->client->get("site/$id"), "site/$id");
    }

    public static function createSite(string $name, string $sharing = null, string $sharePassword = null)
    {
        $self = new static;
        return $self->resolveResponse($self->client->asForm()->post('sites', collect([
            'name' => $name,
            'sharing' => $sharing,
            'share_password' => $sharePassword,
        ])->filter()->toArray()));
    }

    public static function updateSite(string $id, array $data)
    {
        $self = new static;
        return $self->resolveResponse($self->client->asForm()->post("sites/$id", $data));
    }

    public static function wipeSite(string $id)
    {
        $self = new static;
        return $self->resolveResponse($self->client->delete("sites/$id/data"));
    }

    public static function deleteSite(string $id)
    {
        $self = new static;
        return $self->resolveResponse($self->client->delete("sites/$id"));
    }

    public static function events(
        string $siteId,
        int $limit = null,
        string $starting_after = null,
        string $ending_before = null
    ) {
        // TODO: Implement cursor pagination
        $self = new static;
        $endpoint = "sites/$siteId/events";
        return $self->resolveResponse($self->client->get($endpoint), $endpoint);
    }

    public static function event(string $siteId, string $eventId)
    {
        $self = new static;
        $endpoint = "sites/$siteId/events/$eventId";
        return $self->resolveResponse($self->client->get($endpoint), $endpoint);
    }

    public static function createEvent(string $siteId, string $name)
    {
        $self = new static;
        return $self->resolveResponse($self->client->asForm()->post("sites/$siteId/events", [
            'name' => $name,
        ]));
    }

    public static function updateEvent(string $siteId, string $eventId, string $name)
    {
        $self = new static;
        return $self->resolveResponse($self->client->asForm()->post("sites/$siteId/events/$eventId", [
            'name' => $name,
        ]));
    }

    public static function wipeEvent(string $siteId, string $eventId)
    {
        $self = new static;
        return $self->resolveResponse($self->client->delete("sites/$siteId/events/$eventId/data"));
    }

    public static function deleteEvent(string $siteId, string $eventId)
    {
        $self = new static;
        return $self->resolveResponse($self->client->delete("sites/$siteId/events/$eventId"));
    }

    // TODO: Implement aggregation endpoint

    public static function currentVisitors(string $siteId, bool $detailed = false)
    {
        $self = new static;
        return $self->resolveResponse($self->client->asForm()->get('current_visitors', [
            'site_id' => $siteId,
            'detailed' => $detailed,
        ]));
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
