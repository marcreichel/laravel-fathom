<?php

namespace MarcReichel\LaravelFathom\Models;

class Account extends Model
{
    public function get(): array|null
    {
        return $this->resolveResponse($this->client->get('account'), 'account');
    }
}
