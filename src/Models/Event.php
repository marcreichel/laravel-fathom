<?php

namespace MarcReichel\LaravelFathom\Models;

class Event extends Model
{
    public string $siteId;
    public string|null $id;

    public function __construct(string $siteId, string $id = null)
    {
        parent::__construct();

        $this->siteId = $siteId;
        $this->id = $id;
    }

    public function all(int $limit = null, string $starting_after = null, string $ending_before = null)
    {
        // TODO: Implement cursor pagination
        $siteId = $this->siteId;
        $endpoint = "sites/$siteId/events";
        return $this->resolveResponse($this->client->get($endpoint), $endpoint);
    }

    public function get()
    {
        $siteId = $this->siteId;
        $eventId = $this->id;
        $endpoint = "sites/$siteId/events/$eventId";
        return $this->resolveResponse($this->client->get($endpoint), $endpoint);
    }

    public function create(string $name)
    {
        $siteId = $this->siteId;
        return $this->resolveResponse($this->client->asForm()->post("sites/$siteId/events", [
            'name' => $name,
        ]));
    }

    public function update(array $data)
    {
        $siteId = $this->siteId;
        $eventId = $this->id;
        return $this->resolveResponse($this->client->asForm()->post("sites/$siteId/events/$eventId",
            collect($data)->only('name')->toArray()));
    }

    public function wipe()
    {
        $siteId = $this->siteId;
        $eventId = $this->id;
        return $this->resolveResponse($this->client->delete("sites/$siteId/events/$eventId/data"));
    }

    public function delete()
    {
        $siteId = $this->siteId;
        $eventId = $this->id;
        return $this->resolveResponse($this->client->delete("sites/$siteId/events/$eventId"));
    }
}
