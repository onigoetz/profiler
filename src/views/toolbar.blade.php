<div id="profiler-container" class="hideDetails">
    <div class="profiler-boxes">

        @foreach ($panels as $panel)
        <!-- {{ $panel->getName() }} -->
        <div id="pqp-{{ $panel->getName() }}" class="profiler-box">
            {{ $panel->render()->render() }}
        </div>
        @endforeach

    </div>
    <div class="profiler-tabs">
        <div class="profile-block close">
            <a href="#">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAIhSURBVDjLlZPrThNRFIWJicmJz6BWiYbIkYDEG0JbBiitDQgm0PuFXqSAtKXtpE2hNuoPTXwSnwtExd6w0pl2OtPlrphKLSXhx07OZM769qy19wwAGLhM1ddC184+d18QMzoq3lfsD3LZ7Y3XbE5DL6Atzuyilc5Ciyd7IHVfgNcDYTQ2tvDr5crn6uLSvX+Av2Lk36FFpSVENDe3OxDZu8apO5rROJDLo30+Nlvj5RnTlVNAKs1aCVFr7b4BPn6Cls21AWgEQlz2+Dl1h7IdA+i97A/geP65WhbmrnZZ0GIJpr6OqZqYAd5/gJpKox4Mg7pD2YoC2b0/54rJQuJZdm6Izcgma4TW1WZ0h+y8BfbyJMwBmSxkjw+VObNanp5h/adwGhaTXF4NWbLj9gEONyCmUZmd10pGgf1/vwcgOT3tUQE0DdicwIod2EmSbwsKE1P8QoDkcHPJ5YESjgBJkYQpIEZ2KEB51Y6y3ojvY+P8XEDN7uKS0w0ltA7QGCWHCxSWWpwyaCeLy0BkA7UXyyg8fIzDoWHeBaDN4tQdSvAVdU1Aok+nsNTipIEVnkywo/FHatVkBoIhnFisOBoZxcGtQd4B0GYJNZsDSiAEadUBCkstPtN3Avs2Msa+Dt9XfxoFSNYF/Bh9gP0bOqHLAm2WUF1YQskwrVFYPWkf3h1iXwbvqGfFPSGW9Eah8HSS9fuZDnS32f71m8KFY7xs/QZyu6TH2+2+FAAAAABJRU5ErkJggg==" />
            </a>
        </div>

        @foreach ($panel_titles($panels) as $panel => $title)
        <div class="profile-block {{ $panel }}" data-name="{{ $panel }}">
            <div class="profile-content">
                @if (!empty($title->icon))
                    <img src="{{ $title->icon }}" />
                @endif
                {{ $title->title }}
            </div>
            @if (count($title->popup) > 0)
            <div class="profile-panel">
                @foreach ($title->popup as $key => $value)
                <div><strong>{{ $key }}</strong><var>{{ $value }}</var></div>
                @endforeach
            </div>
            @endif
        </div>
        @endforeach
    </div>
</div>

<script src="{{ asset('packages/onigoetz/profiler/js/script.js') }}"> </script>
<link rel="stylesheet" href="{{ asset('packages/onigoetz/profiler/css/style.css') }}" />
