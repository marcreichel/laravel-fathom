<?php

namespace MarcReichel\LaravelFathom\Views\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FathomTrackingCode extends Component
{
    /**
     * @inheritDoc
     */
    public function render(): View
    {
        return view('laravel-fathom::components.fathom-tracking-code', [
            'script' => 'https://' . config('fathom.domain') . '/script.js',
            'siteId' => config('fathom.site_id'),
            'honorDnt' => config('fathom.honor_dnt'),
            'disableAutoTracking' => config('fathom.disable_auto_tracking'),
            'ignoreCanonicals' => config('fathom.ignore_canonicals'),
            'excludedDomains' => config('fathom.excluded_domains'),
            'includedDomains' => config('fathom.included_domains'),
            'spa' => config('fathom.spa_mode'),
        ]);
    }
}
