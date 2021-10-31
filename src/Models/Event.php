<?php

namespace MarcReichel\LaravelFathom\Models;

use MarcReichel\LaravelFathom\Exceptions\EntityIdIsMissingException;
use MarcReichel\LaravelFathom\Traits\HasPagination;

class Event extends Model
{
    use HasPagination;

    public string|null $siteId;
    public string|null $id;

    public function __construct(string|null $siteId, string $id = null)
    {
        parent::__construct();

        $this->siteId = $siteId;
        $this->id = $id;
    }

    public function get(): array|null
    {
        $siteId = $this->siteId;

        if (isset($this->id)) {
            $eventId = $this->id;
            $endpoint = "sites/$siteId/events/$eventId";
            return $this->resolveResponse($this->client->get($endpoint), $endpoint);
        }

        $query = $this->paginationQuery();
        $endpoint = "sites/$siteId/events";
        $key = $endpoint . sha1($query);
        return $this->resolveResponse($this->client->get($endpoint . '?' . $query), $key);
    }

    public function create(string $name): array|null
    {
        $siteId = $this->siteId;
        return $this->resolveResponse($this->client->asForm()->post("sites/$siteId/events", [
            'name' => $name,
        ]));
    }

    public function update(array $data): array|null
    {
        $siteId = $this->siteId;
        $eventId = $this->id;
        return $this->resolveResponse($this->client->asForm()->post("sites/$siteId/events/$eventId",
            collect($data)->only('name')->toArray()));
    }

    public function wipe(): array|null
    {
        $siteId = $this->siteId;
        $eventId = $this->id;
        return $this->resolveResponse($this->client->delete("sites/$siteId/events/$eventId/data"));
    }

    public function delete(): array|null
    {
        $siteId = $this->siteId;
        $eventId = $this->id;
        return $this->resolveResponse($this->client->delete("sites/$siteId/events/$eventId"));
    }

    /**
     * @throws EntityIdIsMissingException
     */
    public function aggregate(array $aggregates): Aggregation
    {
        if (!isset($this->id)) {
            throw new EntityIdIsMissingException();
        }
        return new Aggregation('event', $this->id, $aggregates);
    }
}
