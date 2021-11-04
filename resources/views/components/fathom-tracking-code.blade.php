@if($siteId && $doTracking)
<script src="{{ $script }}"
        data-site="{{ $siteId }}"
        defer
        @if($honorDnt)data-honor-dnt="true" @endif
        @if($disableAutoTracking)data-auto="false" @endif
        @if($ignoreCanonicals)data-canonical="false" @endif
        @if($excludedDomains)data-excluded-domains="{{ $excludedDomains }}" @endif
        @if($includedDomains)data-included-domains="{{ $includedDomains }}" @endif
        @if($spa)data-spa="{{ $spa }}"@endif
></script>
@endif
