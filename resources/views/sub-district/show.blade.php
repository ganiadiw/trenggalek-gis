<x-app-layout>
    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="h-full py-5 bg-white rounded-md shadow-lg px-7 sm:px-10 border-1 border-slate-300">
                <h1 class="flex justify-center mt-5 mb-10 font-bold text-gray-700">Detail Informasi Kecamatan
                    {{ $subDistrict->name }}</h1>
                <div class="grid gap-5 mb-8 sm:grid-cols-2">
                    <x-statistic-card>
                        <x-slot name='svgIcon'>
                            <div
                                class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                                </svg>
                            </div>
                        </x-slot>
                        <x-slot name='title'>Jumlah Destinasi Wisata</x-slot>
                        <x-slot name='value'>10</x-slot>
                    </x-statistic-card>
                    <x-statistic-card>
                        <x-slot name='svgIcon'>
                            <div
                                class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-building-cottage" width="16" height="16"
                                    viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <line x1="3" y1="21" x2="21" y2="21"></line>
                                    <path d="M4 21v-11l2.5 -4.5l5.5 -2.5l5.5 2.5l2.5 4.5v11"></path>
                                    <circle cx="12" cy="9" r="2"></circle>
                                    <path d="M9 21v-5a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v5"></path>
                                </svg>
                            </div>
                        </x-slot>
                        <x-slot name='title'>Jumlah Desa Wisata</x-slot>
                        <x-slot name='value'>10</x-slot>
                    </x-statistic-card>
                </div>
                <div class="grid gap-x-5 md:grid-cols-2">
                    <x-input-default-form type="text" value="{{ $subDistrict->code }}" id="code"
                        labelTitle="Kode Kecamatan" disabled="true"></x-input-default-form>
                    <x-input-default-form type="text" value="{{ $subDistrict->name }}" id="name"
                        labelTitle="Nama Kecamatan" disabled="true"></x-input-default-form>
                    <x-input-default-form type="text" value="{{ $subDistrict->latitude }}" id="latitude"
                        labelTitle="Latitude" disabled="true"></x-input-default-form>
                    <x-input-default-form type="text" value="{{ $subDistrict->longitude }}" id="longitude"
                        labelTitle="Longitude" disabled="true"></x-input-default-form>
                </div>
                <h2 class="mb-2 text-sm font-medium text-gray-900">Peta Kecamatan</h2>
                <div class="w-full mb-5 border rounded-lg h-128">
                    <x-head.leaflet-init :latitude="$subDistrict->latitude" :longitude="$subDistrict->longitude" :marker=true />
                </div>
            </div>
        </div>
    </div>

    @section('script')
        <script>
            let mapStyle = {
                'color': '{{ $subDistrict->fill_color }}',
                'weight': 2,
                'opacity': 0.4,
            }

            function popUp(f, l) {
                var out = [];
                if (f.properties) {
                    for (key in f.properties) {
                        out.push(key + ": " + f.properties[key]);
                    }
                    l.bindPopup(out.join("<br />"));
                }
            }

            new L.GeoJSON.AJAX(['{{ asset('storage/geojson/' . $subDistrict->geojson_name) }}'], {
                onEachFeature: popUp,
                style: mapStyle
            }).addTo(map);
        </script>
    @endsection
</x-app-layout>
