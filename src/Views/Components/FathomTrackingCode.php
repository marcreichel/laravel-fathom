<?php

namespace MarcReichel\LaravelFathom\Views\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class FathomTrackingCode extends Component
{
    public bool $doTracking = false;

    private Request $request;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->doTracking = $this->shouldTrack();
    }

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

    /**
     * Check if the current environment matches the configured environments.
     *
     * @return bool
     */
    private function environmentMatches(): bool
    {
        return in_array(app()->environment(), config('fathom.environments', ['production']), true);
    }

    /**
     * Check if the user agent matches the configured user agents.
     *
     * @return bool
     */
    private function userAgentMatches(): bool
    {
        $match = false;

        foreach (config('fathom.excluded_user_agents', []) as $userAgentPrefix) {
            if (Str::startsWith($this->request->userAgent() ?? '', $userAgentPrefix)) {
                $match = true;
            }
        }

        return $match;
    }

    /**
     * Check if the ip address matches the configured ip addresses.
     *
     * @return bool
     */
    private function ipAddressMatches(): bool
    {
        $match = false;

        foreach (config('fathom.excluded_ip_addresses', []) as $ipAddress) {
            if (Str::startsWith($this->request->ip() ?? '', $ipAddress)) {
                $match = true;
            }
        }

        return $match;
    }

    /**
     * Check if authenticated users should be tracked.
     */
    private function shouldTrackUser(): bool
    {
        return config('fathom.track_authenticated_users', true) || auth()->guest();
    }

    /**
     * Check if visitor should be tracked.
     */
    private function shouldTrack(): bool
    {
        return $this->environmentMatches() &&
            !$this->userAgentMatches() &&
            !$this->ipAddressMatches() &&
            $this->shouldTrackUser();
    }
}
