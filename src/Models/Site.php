<?php

namespace MarcReichel\LaravelFathom\Models;

class Site extends Model
{
    public string|null $id;

    public function __construct(string $id = null)
    {
        parent::__construct();

        $this->id = $id;
    }

    public function all(int $limit = null, string $starting_after = null, string $ending_before = null): array|null
    {
        // TODO: Implement cursor pagination
        return $this->resolveResponse($this->client->get('sites'), 'sites');
    }

    public function create(string $name, string $sharing = null, string $sharePassword = null): array|null
    {
        return $this->resolveResponse($this->client->asForm()->post('sites', collect([
            'name' => $name,
            'sharing' => $sharing,
            'share_password' => $sharePassword,
        ])->filter()->toArray()));
    }

    public function get(): array|null
    {
        $id = $this->id;
        return $this->resolveResponse($this->client->get("sites/$id"), "sites/$id");
    }

    public function update(array $data): array|null
    {
        $id = $this->id;
        return $this->resolveResponse($this->client->asForm()->post("sites/$id", $data));
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
}
