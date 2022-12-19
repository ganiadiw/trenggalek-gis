<x-app-layout>
    <div class="py-8">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-24">
            <form class="px-8 py-6 mt-5 bg-white border-2 rounded-md shadow-lg" method="POST" action="{{ route('sub-districts.update', ['sub_district' => $subDistrict]) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <h1 class="mb-5 text-lg font-bold text-gray-700">Ubah Data Kecamatan</h1>
                <div>
                    <div>
                        <x-input-default-form type="text" name="code" :value="old('code', $subDistrict->code)" id="code" labelTitle="Kode Kecamatan*" error='code' placeholder="3503010"></x-input-default-form>
                        <x-input-default-form type="text" name="name" :value="old('name', $subDistrict->name)" id="name" labelTitle="Nama Kecamatan*" error='name' placeholder="PANGGUL"></x-input-default-form>
                    </div>
                    <div class="mb-3">
                        <label for="subDistrictFillColor" class="block mb-2 text-sm font-medium text-gray-900">Warna Peta*</label>
                        <div class="flex items-center">
                            <div class="color-picker"></div>
                            <input type="text" name="fill_color" value="{{ old('fill_color', $subDistrict->fill_color) }}" id="subDistrictFillColor" class="ml-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 px-4" placeholder="#06b6d4" autocomplete="off">
                        </div>
                        @error('fill_color')
                            <p id="standard_error_help" class="flex items-center mt-2 text-xs text-yellow-700">
                                <span class="mr-3 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-circle" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <circle cx="12" cy="12" r="9"></circle>
                                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                        <polyline points="11 12 12 12 12 16 13 16"></polyline>
                                    </svg>
                                </span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <x-input-default-form type="file" name="geojson" id="geojsonFile" labelTitle="Upload Peta (Format .geojson, Upload hanya jika ingin mengubahnya)" error='geojson'></x-input-default-form>
                    <div class="mb-3 lg:flex lg:gap-x-2">
                        <div class="p-3 bg-gray-200 rounded-md shadow-lg lg:w-2/4 lg:h-fit">
                            <h2 class="font-semibold text-black ">Pilih koordinat titik tengah peta kecamatan</h2>
                            <p class="mb-3 text-xs text-red-500">Titik tengah koordinat peta akan otomatis ditentukan saat file geojson telah dipilih, atau juga dapat ditentukan dengan klik pada peta</p>
                            <x-input-default-form class="cursor-not-allowed" type="text" name="latitude" :value="old('latitude', $subDistrict->latitude)" id="latitude" labelTitle="Latitude*" error='latitude' placeholder="-8.2402961" readonly="true"></x-input-default-form>
                            <x-input-default-form class="cursor-not-allowed" type="text" name="longitude" :value="old('longitude', $subDistrict->longitude)" id="longitude" labelTitle="Longitude*" error='longitude' placeholder="111.4484781" readonly="true"></x-input-default-form>
                        </div>
                        <div id="subDistrictMap" class="mt-5 border rounded-lg lg:w-2/4 lg:mt-0 h-120"></div>
                    </div>
                </div>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Simpan</button>
            </form>
        </div>
    </div>

    @section('script')
        <script>
            let subDistrictFillColor = document.getElementById('subDistrictFillColor')

            const pickr = Pickr.create({
                el: '.color-picker',
                theme: 'nano',
                default: '{{ $subDistrict->fill_color }}',

                swatches: [
                    '#059669',
                    '#0284c7',
                    '#8b5cf6',
                    '#db2777',
                    '#84cc16',
                    '#fbbf24',
                    '#78716c',
                ],

                components: {
                    preview: true,
                    opacity: false,
                    hue: true,

                    interaction: {
                        hex: false,
                        rgba: false,
                        hsla: false,
                        hsva: false,
                        cmyk: false,
                        input: true,
                        clear: false,
                        save: true,
                    }
                }
            });

            pickr.on('save', (color, instance) => {
                const hexColor = color.toHEXA().toString()
                subDistrictFillColor.value = hexColor
                pickr.hide()
            })

            let subDistrictMap = L.map('subDistrictMap').setView([{{ $subDistrict->latitude }}, {{ $subDistrict->longitude }}], 11);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 15,
                minZoom: 10,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(subDistrictMap);

            let mapStyle = {
                'color': '{{ $subDistrict->fill_color }}',
                'weight': 2,
                'opacity': 0.4,
            }

            new L.GeoJSON.AJAX(['{{ asset('storage/geojson/' . $subDistrict->geojson_name) }}'],{style:mapStyle}).addTo(subDistrictMap);

            subDistrictMap.on('click', onMapClick)

            let marker = L.marker([{{ $subDistrict->latitude }}, {{ $subDistrict->longitude }}]).addTo(subDistrictMap)
            let latitudeInput = document.getElementById('latitude')
            let longitudeInput = document.getElementById('longitude')

            function onMapClick(e) {
                let latitude = e.latlng.lat
                let longitude = e.latlng.lng

                if (!marker) {
                    marker = L.marker(e.latlng).addTo(subDistrictMap)
                } else {
                    marker.setLatLng(e.latlng)
                }

                latitudeInput.value=latitude
                longitudeInput.value=longitude
            }

            let geojsonFile = document.getElementById('geojsonFile')

            geojsonFile.addEventListener('change', function() {
                const file = geojsonFile.files[0]
                const reader = new FileReader()

                reader.onload = function() {
                    const data = JSON.parse(reader.result)
                    let layer = L.geoJSON(data, {
                        style: function(feature) {
                            return {
                                color: subDistrictFillColor.value,
                                weight: 2,
                                opacity: 0.4,
                            }
                        }
                    }).addTo(subDistrictMap)

                    let bounds = layer.getBounds()
                    subDistrictMap.fitBounds(bounds)
                    let center = bounds.getCenter()
                    marker.setLatLng(center)
                    latitudeInput.value=center.lat
                    longitudeInput.value=center.lng
                }
                reader.readAsText(file)
            })
        </script>
    @endsection
</x-app-layout>
