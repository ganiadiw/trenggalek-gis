<x-app-layout>
    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="h-screen py-5 bg-white rounded-md shadow-lg px-7 sm:px-10 border-1 border-slate-300">
                <div id="subDistrictMap" class="w-full border h-128"></div>
            </div>
        </div>
    </div>

    @section('script')
        <script>
            let subDistrictMap = L.map('subDistrictMap').setView([{{ $subDistrict->latitude }}, {{ $subDistrict->longitude }}], 12);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 15,
                minZoom: 12,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(subDistrictMap);

            let mapStyle = {
                'color': '{{ $subDistrict->fill_color }}',
                'weight': 3,
                'opacity': 0.65,
            }

            function popUp(f,l){
                var out = [];
                if (f.properties){
                    for(key in f.properties){
                        out.push(key+": "+f.properties[key]);
                    }
                    l.bindPopup(out.join("<br />"));
                }
            }
            var jsonTest = new L.GeoJSON.AJAX(['{{ asset('storage/geojson/' . $subDistrict->geojson_name) }}'],{onEachFeature:popUp, style:mapStyle}).addTo(subDistrictMap);
        </script>
    @endsection
</x-app-layout>
