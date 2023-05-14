<x-app-layout>
    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="h-full py-5 bg-white rounded-md shadow-lg px-7 sm:px-10 border-1 border-slate-300">
                <h1 class="flex justify-center mt-5 mb-10 font-bold text-gray-700">Detail Informasi Kecamatan
                    {{ $subDistrict->name }}</h1>
                <div class="grid gap-5 mb-8 sm:grid-cols-2">
                    <x-statistic-card>
                        <x-slot name='svgIcon'>
                            <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-category-2"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="#d97706"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M14 4h6v6h-6z"></path>
                                    <path d="M4 14h6v6h-6z"></path>
                                    <circle cx="17" cy="17" r="3"></circle>
                                    <circle cx="7" cy="7" r="3"></circle>
                                </svg>
                            </div>
                        </x-slot>
                        <x-slot name='title'>Jumlah Kategori Destinasi Wisata</x-slot>
                        <x-slot name='value'>{{ $subDistrict->tourist_destination_categories_count }}</x-slot>
                    </x-statistic-card>
                    <x-statistic-card>
                        <x-slot name='svgIcon'>
                            <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                                </svg>
                            </div>
                        </x-slot>
                        <x-slot name='title'>Jumlah Destinasi Wisata</x-slot>
                        <x-slot name='value'>{{ $subDistrict->tourist_destinations_count }}</x-slot>
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
                <div class="w-full mb-5 border rounded-lg">
                    <x-head.leaflet-init :latitude="$subDistrict->latitude" :longitude="$subDistrict->longitude" />
                </div>
                <div class="flex justify-end mt-8 gap-x-2">
                    <button onclick="history.back()"
                        class="text-white bg-gray-600 hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Kembali</button>
                </div>
            </div>
        </div>
    </div>

    @section('script')
        <script>
            L.marker([{{ $subDistrict->latitude }}, {{ $subDistrict->longitude }}]).addTo(map);

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
