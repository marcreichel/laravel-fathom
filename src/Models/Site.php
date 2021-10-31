<?php

namespace MarcReichel\LaravelFathom\Models;

use MarcReichel\LaravelFathom\Exceptions\EntityIdIsMissingException;
use MarcReichel\LaravelFathom\Traits\HasPagination;

class Site extends Model
{
    use HasPagination;

    public string|null $id;

    public array $fillable = [
        'name',
        'sharing',
        'share_password',
    ];

    public function __construct(string $id = null)
    {
        parent::__construct();

        $this->id = $id;
    }

    public function create(array $data): array|null
    {
        return $this->resolveResponse($this->client->asForm()->post('sites',
            collect($data)->only($this->fillable)->filter()->toArray()));
    }

    public function get(): array|null
    {
        if (isset($this->id)) {
            $id = $this->id;
            return $this->resolveResponse($this->client->get("sites/$id"), "sites/$id");
        }

        $query = $this->paginationQuery();
        $key = 'sites.' . sha1($query);
        return $this->resolveResponse($this->client->get('sites?' . $query), $key);
    }

    public function update(array $data): array|null
    {
        $id = $this->id;
        return $this->resolveResponse($this->client->asForm()->post("sites/$id",
            collect($data)->only($this->fillable)->filter()->toArray()));
    }

    public function wipe(): array|null
    {
        $id = $this->id;
        return $this->resolveResponse($this->client->delete("sites/$id/data"));
    }

    public function delete(): array|null
    {
        $id = $this->id;
        return $this->resolveResponse($this->client->delete("sites/$id"));
    }

    public function currentVisitors(bool $detailed = false): array|null
    {
        $query = http_build_query(collect([
            'site_id' => $this->id,
            'detailed' => $detailed ? 'true' : null,
        ])->filter()->toArray());
        return $this->resolveResponse($this->client->asForm()->get('current_visitors?' . $query));
    }

    public function events(): Event
    {
        return new Event($this->id);
    }

    public function event(string $id): Event
    {
        return new Event($this->id, $id);
    }

    /**
     * @throws EntityIdIsMissingException
     */
    public function aggregate(array $aggregates): Aggregation
    {
        if (!isset($this->id)) {
            throw new EntityIdIsMissingException();
        }
        return new Aggregation('pageviews', $this->id, $aggregates);
    }
}
