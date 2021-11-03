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
     * @see https://usefathom.com/docs/script/custom-domains
     */
    'domain' => env('FATHOM_DOMAIN', 'cdn.usefathom.com'),

    /**
     * Honor Do Not Track
     *
     * @see https://usefathom.com/docs/script/script-advanced#dnt
     */
    'honor_dnt' => env('FATHOM_HONOR_DNT', false),

    /**
     * Disable automatic tracking
     *
     * @see https://usefathom.com/docs/script/script-advanced#auto
     */
    'disable_auto_tracking' => env('FATHOM_DISABLE_AUTO_TRACKING', false),

    /**
     * Ignore canonical links
     *
     * @see https://usefathom.com/docs/script/script-advanced#canonicals
     */
    'ignore_canonicals' => env('FATHOM_IGNORE_CANONICALS', false),

    /**
     * Excluded domains
     *
     * @see https://usefathom.com/docs/script/script-advanced#domains
     */
    'excluded_domains' => env('FATHOM_EXCLUDED_DOMAINS'),

    /**
     * Included domains
     *
     * @see https://usefathom.com/docs/script/script-advanced#domains
     */
    'included_domains' => env('FATHOM_INCLUDED_DOMAINS'),

    /**
     * Single Page Application Mode
     *
     * @see https://usefathom.com/docs/script/script-advanced#spa
     */
    'spa_mode' => env('FATHOM_SPA_MODE'),
];
