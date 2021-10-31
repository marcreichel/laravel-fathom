<?php

namespace MarcReichel\LaravelFathom;

use MarcReichel\LaravelFathom\Models\Account;
use MarcReichel\LaravelFathom\Models\Site;

class Fathom
{
    public static function account(): Account
    {
        return new Account();
    }

    public static function sites(): Site
    {
        return new Site();
    }

    public static function site(string $id): Site
    {
        return new Site($id);
    }
}
