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
     */
    'domain' => env('FATHOM_DOMAIN', 'cdn.usefathom.com'),

    /**
     * Honor Do Not Track
     */
    'honor_dnt' => env('FATHOM_HONOR_DNT', false),

    /**
     * Disable automatic tracking
     */
    'disable_auto_tracking' => env('FATHOM_DISABLE_AUTO_TRACKING', false),

    /**
     * Ignore canonical links
     */
    'ignore_canonicals' => env('FATHOM_IGNORE_CANONICALS', false),

    /**
     * Excluded domains
     */
    'excluded_domains' => env('FATHOM_EXCLUDED_DOMAINS'),

    /**
     * Included domains
     */
    'included_domains' => env('FATHOM_INCLUDED_DOMAINS'),

    /**
     * Single Page Application Mode
     */
    'spa_mode' => env('FATHOM_SPA_MODE'),
];
