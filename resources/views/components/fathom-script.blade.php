@if($siteId && $doTracking)
<script src="{{ $script }}"
        data-site="{{ $siteId }}"
        defer
        @if($honorDnt)data-honor-dnt="true" @endif
        @if($disableAutoTracking)data-auto="false" @endif
        @if($ignoreCanonicals)data-canonical="false" @endif
        @if($excludedDomains)data-excluded-domains="{{ is_string($excludedDomains) ? $excludedDomains : implode(',', $excludedDomains) }}" @endif
        @if($includedDomains)data-included-domains="{{ is_string($includedDomains) ? $includedDomains : implode(',', $includedDomains) }}" @endif
        @if($spa)data-spa="{{ $spa }}"@endif
></script>
@endif
