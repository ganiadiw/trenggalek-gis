<x-app-layout>
    <div class="py-8">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-24">
            <form class="px-8 py-6 mt-5 bg-white border-2 rounded-md shadow-lg" method="POST"
                action="{{ route('dashboard.sub-districts.update', ['sub_district' => $subDistrict]) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <h1 class="mb-5 text-lg font-bold text-gray-700">Ubah Data Kecamatan</h1>
                <div>
                    <div>
                        <x-input-default-form type="text" name="code" :value="old('code', $subDistrict->code)" id="code"
                            labelTitle="Kode Kecamatan*" error='code' placeholder="3503010"></x-input-default-form>
                        <x-input-default-form type="text" name="name" :value="old('name', $subDistrict->name)" id="name"
                            labelTitle="Nama Kecamatan*" error='name' placeholder="PANGGUL"></x-input-default-form>
                    </div>
                    <div class="mb-3">
                        <label for="subDistrictFillColor" class="block mb-2 text-sm font-medium text-gray-900">Warna
                            Peta*</label>
                        <div class="flex items-center">
                            <div class="color-picker"></div>
                            <input type="text" name="fill_color"
                                value="{{ old('fill_color', $subDistrict->fill_color) }}" id="subDistrictFillColor"
                                class="ml-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 px-4"
                                placeholder="#06b6d4" autocomplete="off">
                        </div>
                        @error('fill_color')
                            <p id="standard_error_help" class="flex items-center mt-2 text-xs text-yellow-700">
                                <span class="mr-3 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-circle"
                                        width="20" height="20" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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

                    <div x-data="{ current: $persist(1) }"
                        class="p-3 mb-3 bg-white border-2 rounded-md shadow-lg border-slate-300">
                        <div>
                            <p class="text-sm font-semibold text-black">Unggah Peta Kecamatan*</p>
                            <p class="flex mt-2 text-sm font-semibold text-red-600 gap-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-alert-octagon" width="20" height="20"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M8.7 3h6.6c.3 0 .5 .1 .7 .3l4.7 4.7c.2 .2 .3 .4 .3 .7v6.6c0 .3 -.1 .5 -.3 .7l-4.7 4.7c-.2 .2 -.4 .3 -.7 .3h-6.6c-.3 0 -.5 -.1 -.7 -.3l-4.7 -4.7c-.2 -.2 -.3 -.4 -.3 -.7v-6.6c0 -.3 .1 -.5 .3 -.7l4.7 -4.7c.2 -.2 .4 -.3 .7 -.3z">
                                    </path>
                                    <line x1="12" y1="8" x2="12" y2="12"></line>
                                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                </svg>
                                Unggah hanya jika ingin mengubahnya, dan pilih salah satu dari dua metode unggah peta!
                            </p>
                            <p class="my-2 text-sm italic text-yellow-600">File atau text geojson dapat diperoleh dari
                                website
                                <a class="inline-flex items-center text-blue-500 underline" target="_blank"
                                    href="https://geojson.io/#map=2/0/20">
                                    geojson.io
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-arrow-up-right" width="18"
                                        height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <line x1="17" y1="7" x2="7" y2="17"></line>
                                        <polyline points="8 7 17 7 17 16"></polyline>
                                    </svg>
                                </a>,
                                <a class="inline-flex items-center text-blue-500 underline" target="_blank"
                                    href="https://geoman.io/geojson-editor">
                                    geoman.io
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-arrow-up-right" width="18"
                                        height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <line x1="17" y1="7" x2="7" y2="17"></line>
                                        <polyline points="8 7 17 7 17 16"></polyline>
                                    </svg>
                                </a>
                                atau pada menu
                                <a class="text-blue-500 underline" href="#">Map Drawer</a>
                            </p>
                            <div class="text-sm text-center text-black border-b border-gray-400">
                                <ul class="flex flex-wrap -mb-px">
                                    <li class="mr-2">
                                        <button type="button" @click="current = 1"
                                            class="inline-flex items-center p-2 py-3 hover:text-gray-700 hover:underline"
                                            x-bind:class="{ 'active underline text-blue-500 hover:text-blue-500': current === 1 }">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="mr-2 icon icon-tabler icon-tabler-file" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                                <path
                                                    d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z">
                                                </path>
                                            </svg>
                                            Upload File
                                        </button>
                                    </li>
                                    <li class="mr-2">
                                        <button type="button" @click="current = 2"
                                            class="inline-flex items-center p-2 py-3 hover:text-gray-700 hover:underline"
                                            x-bind:class="{ 'active underline text-blue-500 hover:text-blue-500': current === 2 }">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="mr-2 icon icon-tabler icon-tabler-file-text" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                                <path
                                                    d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z">
                                                </path>
                                                <line x1="9" y1="9" x2="10" y2="9">
                                                </line>
                                                <line x1="9" y1="13" x2="15" y2="13">
                                                </line>
                                                <line x1="9" y1="17" x2="15" y2="17">
                                                </line>
                                            </svg>
                                            Upload Text
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="mt-3 text-black">
                            <div x-cloak x-show="current == 1" class="static block">
                                <x-input-default-form class="py-0" type="file" name="geojson" id="geojsonFile"
                                    labelTitle="Upload Peta (Format .geojson)*" error='geojson'>
                                </x-input-default-form>
                            </div>
                            <div x-show="current == 2" class="block">
                                <div class="w-full mb-4 bg-gray-100 border border-gray-200 rounded-lg">
                                    <div class="px-4 py-2 bg-white rounded-t-lg">
                                        <textarea id="geoJSONTextArea" name="geojson_text_area" rows="15"
                                            class="w-full px-0 text-sm text-gray-900 bg-white border-0" placeholder="Masukkan text geojson....">{{ old('geojson_text_area') }}</textarea>
                                    </div>
                                    <div class="flex items-center justify-between px-3 py-2 border-t">
                                        <button type="button" id="buttonGeoJSONText"
                                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Tampilkan
                                            pada peta</button>
                                    </div>
                                </div>
                                @error('geojson_text_area')
                                    <p id="standard_error_help" class="flex items-center mt-2 text-xs text-yellow-700">
                                        <span class="mr-3 font-medium">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-info-circle" width="20"
                                                height="20" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <circle cx="12" cy="12" r="9"></circle>
                                                <line x1="12" y1="8" x2="12.01" y2="8">
                                                </line>
                                                <polyline points="11 12 12 12 12 16 13 16"></polyline>
                                            </svg>
                                        </span>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 lg:flex lg:gap-x-2">
                        <div class="p-3 bg-gray-200 rounded-md shadow-lg lg:w-2/4 lg:h-fit">
                            <h2 class="font-semibold text-black ">Tentukan koordinat titik tengah peta kecamatan</h2>
                            <blockquote class="p-2 my-2 border-l-4 border-yellow-300 rounded-sm bg-gray-50">
                                <p class="text-[13px] font-medium italic leading-relaxed text-yellow-500">Titik tengah koordinat peta akan otomatis ditentukan
                                saat file geojson telah dipilih atau text geosjon telah di preview pada peta, atau juga
                                dapat ditentukan dengan klik pada peta</p>
                            </blockquote>
                            <x-input-default-form type="text" name="latitude"
                                :value="old('latitude', $subDistrict->latitude)" id="latitude" labelTitle="Latitude*" error='latitude'
                                placeholder="-8.2402961"></x-input-default-form>
                            <x-input-default-form type="text" name="longitude"
                                :value="old('longitude', $subDistrict->longitude)" id="longitude" labelTitle="Longitude*" error='longitude'
                                placeholder="111.4484781"></x-input-default-form>
                            <button type="button" id="buttonFindOnMap"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-3 py-2.5 text-center">Cari
                                pada peta</button>
                        </div>
                        <div class="mt-5 lg:w-2/4 lg:mt-0 h-120">
                            <x-head.leaflet-init :latitude="$subDistrict->latitude" :longitude="$subDistrict->longitude" />
                        </div>
                    </div>
                </div>
                <div class="flex gap-x-2">
                    <a href="{{ route('dashboard.sub-districts.index') }}"
                        class="text-white bg-gray-600 hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Kembali</a>
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    @section('script')
        @include('js.leaflet-find-marker')
        <script>
            let subDistrictFillColor = document.getElementById('subDistrictFillColor')
            layer = new L.GeoJSON.AJAX(['{{ asset('storage/geojson/' . $subDistrict->geojson_name) }}'], {
                style: {
                    'color': '{{ $subDistrict->fill_color }}',
                    'weight': 2,
                    'opacity': 0.4,
                }
            }).addTo(map);
            marker = L.marker([{{ $subDistrict->latitude }}, {{ $subDistrict->longitude }}]).addTo(map)

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
                layer.setStyle({
                    'color': hexColor,
                    'weight': 2,
                    'opacity': 0.4,
                })
                pickr.hide()
            })

            function previewGeoJSONToMap(geoJSON) {
                const data = JSON.parse(geoJSON)

                if (layer) {
                    map.removeLayer(layer)
                    map.removeLayer(marker)
                }

                layer = L.geoJSON(data, {
                    style: function(feature) {
                        return {
                            color: subDistrictFillColor.value,
                            weight: 2,
                            opacity: 0.4,
                        }
                    }
                }).addTo(map)

                let bounds = layer.getBounds()
                map.fitBounds(bounds)
                let center = bounds.getCenter()
                marker = L.marker(center).addTo(map)
                latitudeInput.value = center.lat
                longitudeInput.value = center.lng
            }

            let geojsonFile = document.getElementById('geojsonFile')

            geojsonFile.addEventListener('change', function() {
                const file = geojsonFile.files[0]
                const reader = new FileReader()

                reader.onload = function() {
                    previewGeoJSONToMap(reader.result)
                    document.getElementById('geoJSONTextArea').value = ''
                }
                reader.readAsText(file)
            })

            let buttonGeoJSONText = document.getElementById('buttonGeoJSONText')

            buttonGeoJSONText.addEventListener('click', function() {
                let geoJSONTextArea = document.getElementById('geoJSONTextArea')
                let badGeoJSON = geoJSONTextArea.value
                let parseGeoJSON = JSON.parse(badGeoJSON)
                let geoJSONPrettyFormat = JSON.stringify(parseGeoJSON, undefined, 2)
                geoJSONTextArea.value = geoJSONPrettyFormat

                geojsonFile.value = ''
                previewGeoJSONToMap(geoJSONPrettyFormat)
            })
        </script>
    @endsection
</x-app-layout>
