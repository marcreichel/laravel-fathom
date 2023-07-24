<?php

declare(strict_types=1);

namespace MarcReichel\LaravelFathom\Models;

use MarcReichel\LaravelFathom\Exceptions\EntityIdIsMissingException;
use MarcReichel\LaravelFathom\Traits\HasPagination;

final class Event extends Model
{
    use HasPagination;

    public ?string $siteId;
    public ?string $id;

    public array $fillable = [
        'name',
    ];

    public function __construct(string|null $siteId, string $id = null)
    {
        parent::__construct();

        $this->siteId = $siteId;
        $this->id = $id;
    }

    public function get(): ?array
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

    public function create(array $data): array|null
    {
        $siteId = $this->siteId;
        return $this->resolveResponse($this->client->asForm()->post("sites/$siteId/events",
            collect($data)->only($this->fillable)->filter()->toArray()));
    }

    public function update(array $data): array|null
    {
        $siteId = $this->siteId;
        $eventId = $this->id;
        return $this->resolveResponse($this->client->asForm()->post("sites/$siteId/events/$eventId",
            collect($data)->only($this->fillable)->filter()->toArray()));
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
