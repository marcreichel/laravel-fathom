# Installation

> **Please note**: This package is still a work in progress and the Fathom API is also only in early access. Do not use this package in your production environment (yet).

You can install this package via composer:

```bash
// torchlight! {"lineNumbers": false}
composer require marcreichel/laravel-fathom
```

The package will automatically register its service provider.

To publish the config file to `config/fathom.php` run:

```bash
// torchlight! {"lineNumbers": false}
php artisan fathom:install
```

Default content of `config/fathom.php`:

```php
// torchlight! {"lineNumbers": false}
<?php

return [
    /**
     * Your Fathom API token
     */
    'api_token' => env('FATHOM_API_TOKEN'),

    /**
     * The site ID to use for tracking
     */
    'site_id' => env('FATHOM_SITE_ID'),

    /**
     * Tracking code domain
     *
     * @see https://usefathom.com/docs/script/custom-domains [tl! autolink]
     */
    'domain' => env('FATHOM_DOMAIN', 'cdn.usefathom.com'),

    /**
     * Honor Do Not Track
     *
     * @see https://usefathom.com/docs/script/script-advanced#dnt [tl! autolink]
     */
    'honor_dnt' => env('FATHOM_HONOR_DNT', false),

    /**
     * Disable automatic tracking
     *
     * @see https://usefathom.com/docs/script/script-advanced#auto [tl! autolink]
     */
    'disable_auto_tracking' => env('FATHOM_DISABLE_AUTO_TRACKING', false),

    /**
     * Ignore canonical links
     *
     * @see https://usefathom.com/docs/script/script-advanced#canonicals [tl! autolink]
     */
    'ignore_canonicals' => env('FATHOM_IGNORE_CANONICALS', false),

    /**
     * Excluded domains
     *
     * @see https://usefathom.com/docs/script/script-advanced#domains [tl! autolink]
     */
    'excluded_domains' => env('FATHOM_EXCLUDED_DOMAINS'),

    /**
     * Included domains
     *
     * @see https://usefathom.com/docs/script/script-advanced#domains [tl! autolink]
     */
    'included_domains' => env('FATHOM_INCLUDED_DOMAINS'),

    /**
     * Single Page Application Mode
     *
     * @see https://usefathom.com/docs/script/script-advanced#spa [tl! autolink]
     */
    'spa_mode' => env('FATHOM_SPA_MODE'),
];
```
