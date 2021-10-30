<?php

namespace MarcReichel\LaravelFathom\Models;

use MarcReichel\LaravelFathom\Fathom;

class Site extends Model
{
    public string|null $id;

    public function __construct(string $id = null)
    {
        parent::__construct();

        $this->id = $id;
    }

    public function all(int $limit = null, string $starting_after = null, string $ending_before = null)
    {
        // TODO: Implement cursor pagination
        $self = new static;
        return $self->resolveResponse($self->client->get('sites'), 'sites');
    }

    public function create(string $name, string $sharing = null, string $sharePassword = null)
    {
        $self = new static;
        return $self->resolveResponse($self->client->asForm()->post('sites', collect([
            'name' => $name,
            'sharing' => $sharing,
            'share_password' => $sharePassword,
        ])->filter()->toArray()));
    }

    public function get()
    {
        $id = $this->id;
        return $this->resolveResponse($this->client->get("sites/$id"), "sites/$id");
    }

    public function update(array $data)
    {
        $id = $this->id;
        return $this->resolveResponse($this->client->asForm()->post("sites/$id", $data));
    }

    public function wipe()
    {
        $id = $this->id;
        return $this->resolveResponse($this->client->delete("sites/$id/data"));
    }

    public function delete()
    {
        $id = $this->id;
        return $this->resolveResponse($this->client->delete("sites/$id"));
    }

    public function currentVisitors(bool $detailed)
    {
        return $this->resolveResponse($this->client->asForm()->get('current_visitors', [
            'site_id' => $this->id,
            'detailed' => $detailed,
        ]));
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
