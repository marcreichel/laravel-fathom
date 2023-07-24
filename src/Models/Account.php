<?php

declare(strict_types=1);

namespace MarcReichel\LaravelFathom\Models;

final class Account extends Model
{
    public function get(): ?array
    {
        return $this->resolveResponse($this->client->get('account'), 'account');
    }
}
