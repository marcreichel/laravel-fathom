<?php

namespace MarcReichel\LaravelFathom\Models;

class Account extends Model
{
    public function get()
    {
        return $this->resolveResponse($this->client->get('account'), 'account');
    }
}
