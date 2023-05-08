<div id="map" {{ $attributes->merge(['class' => 'z-0 border rounded-lg h-120']) }}></div>

@section('component-script')
    <script>
        let map = L.map('map').setView([{{ $latitude }}, {{ $longitude }}], {{ $zoomLevel }});

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            minZoom: 10,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
    </script>
@endsection
