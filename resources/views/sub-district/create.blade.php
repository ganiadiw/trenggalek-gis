<x-app-layout>
    <div>
        <div class="px-4 py-4 mx-auto text-gray-900 max-w-7xl sm:px-6 lg:px-8">
            <div class="px-8 py-6 mt-5 bg-white border-2 rounded-md shadow-lg">
                <h1 class="w-full text-lg font-bold">Tambah Data Kecamatan</h1>
                <div class="w-full mt-5">
                    <form method="POST" action="{{ route('dashboard.sub-districts.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="grid gap-5">
                            <div>
                                <h2 class="text-base font-semibold text-gray-800">Data Administratif</h2>
                                <div class="p-5 mt-3 border-2 border-gray-200 rounded-md shadow-md">
                                    <x-input-default-form type="text" name="code" :value="old('code')" id="code"
                                        labelTitle="Kode Kecamatan*" error='code'
                                        placeholder="Kode Administratif Kecamatan">
                                    </x-input-default-form>
                                    <x-input-default-form type="text" name="name" :value="old('name')" id="name"
                                        labelTitle="Nama Kecamatan*" error='name' placeholder="Nama Kecamatan">
                                    </x-input-default-form>
                                </div>
                            </div>
                            <div>
                                <h2 class="text-base font-semibold text-gray-800">Data Peta</h2>
                                <div class="p-5 mt-3 border-2 border-gray-200 rounded-md shadow-md">
                                    <div class="mb-3">
                                        <label for="subDistrictFillColor" class="block mb-2 text-sm font-semibold">Warna
                                            Peta*</label>
                                        <div class="flex items-center">
                                            <div class="color-picker"></div>
                                            <input type="text" name="fill_color" value="{{ old('fill_color') }}"
                                                id="subDistrictFillColor"
                                                class="ml-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 px-4"
                                                placeholder="#06b6d4" autocomplete="off">
                                        </div>
                                        <x-input-error-validation error="fill_color" />
                                    </div>
                                    <div>
                                        <p class="mb-2 text-sm font-semibold">Unggah Peta Kecamatan*</p>
                                        <div x-data="{ current: $persist(1) }"
                                            class="p-3 mb-3 bg-white border-2 rounded-md border-slate-300">
                                            <div>
                                                <p
                                                    class="flex items-center mt-2 text-sm font-semibold text-red-600 gap-x-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-alert-octagon"
                                                        width="20" height="20" viewBox="0 0 24 24"
                                                        stroke-width="2" stroke="currentColor" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path
                                                            d="M8.7 3h6.6c.3 0 .5 .1 .7 .3l4.7 4.7c.2 .2 .3 .4 .3 .7v6.6c0 .3 -.1 .5 -.3 .7l-4.7 4.7c-.2 .2 -.4 .3 -.7 .3h-6.6c-.3 0 -.5 -.1 -.7 -.3l-4.7 -4.7c-.2 -.2 -.3 -.4 -.3 -.7v-6.6c0 -.3 .1 -.5 .3 -.7l4.7 -4.7c.2 -.2 .4 -.3 .7 -.3z">
                                                        </path>
                                                        <line x1="12" y1="8" x2="12"
                                                            y2="12">
                                                        </line>
                                                        <line x1="12" y1="16" x2="12.01"
                                                            y2="16">
                                                        </line>
                                                    </svg>
                                                    Pilih salah satu dari dua metode unggah peta!
                                                </p>
                                                <p class="my-2 text-sm italic text-yellow-600">
                                                    File atau text geojson dapat diperoleh dari website <a target="_blank" class="font-medium hover:underline text-blue-500 after:content-['↗'] after:font-bold" href="https://geojson.io/#map=2/0/20" rel="noopener">geojson.io</a>
                                                    ,
                                                    <a target="_blank" class="font-medium hover:underline text-blue-500 after:content-['↗'] after:font-bold" href="https://geoman.io/geojson-editor" rel="noopener">geoman.io</a>
                                                    , atau pada menu <a target="_blank" class="font-medium text-blue-500 hover:underline after:content-['↗'] after:font-bold" href="{{ route('dashboard.map-drawer') }}" rel="noopener">Map Drawer</a>
                                                </p>
                                                <div class="text-sm text-center text-black border-b border-gray-400">
                                                    <ul class="flex flex-wrap -mb-px">
                                                        <li class="mr-2">
                                                            <button type="button" @click="current = 1"
                                                                class="inline-flex items-center p-2 py-3 hover:text-gray-700 hover:underline"
                                                                x-bind:class="{
                                                                    'active underline text-blue-500 hover:text-blue-500': current ===
                                                                        1
                                                                }">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="mr-2 icon icon-tabler icon-tabler-file"
                                                                    width="24" height="24" viewBox="0 0 24 24"
                                                                    stroke-width="2" stroke="currentColor"
                                                                    fill="none" stroke-linecap="round"
                                                                    stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                        fill="none">
                                                                    </path>
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
                                                                x-bind:class="{
                                                                    'active underline text-blue-500 hover:text-blue-500': current ===
                                                                        2
                                                                }">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="mr-2 icon icon-tabler icon-tabler-file-text"
                                                                    width="24" height="24" viewBox="0 0 24 24"
                                                                    stroke-width="2" stroke="currentColor"
                                                                    fill="none" stroke-linecap="round"
                                                                    stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                        fill="none">
                                                                    </path>
                                                                    <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                                                    <path
                                                                        d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z">
                                                                    </path>
                                                                    <line x1="9" y1="9"
                                                                        x2="10" y2="9">
                                                                    </line>
                                                                    <line x1="9" y1="13"
                                                                        x2="15" y2="13">
                                                                    </line>
                                                                    <line x1="9" y1="17"
                                                                        x2="15" y2="17">
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
                                                    <x-input-default-form class="py-0" type="file"
                                                        name="geojson" id="geojsonFile"
                                                        labelTitle="Upload Peta (Format .geojson)*" error='geojson'>
                                                    </x-input-default-form>
                                                </div>
                                                <div x-show="current == 2" class="block">
                                                    <div
                                                        class="w-full mb-4 bg-gray-100 border border-gray-200 rounded-lg">
                                                        <div class="px-4 py-2 bg-white rounded-t-lg">
                                                            <textarea id="geoJSONTextArea" name="geojson_text_area" rows="15"
                                                                class="w-full px-0 text-sm text-gray-900 bg-white border-0" placeholder="Masukkan text geojson....">{{ old('geojson_text_area') }}</textarea>
                                                        </div>
                                                        <div
                                                            class="flex items-center justify-between px-3 py-2 border-t">
                                                            <button type="button" id="buttonGeoJSONText"
                                                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Tampilkan
                                                                pada peta</button>
                                                        </div>
                                                    </div>
                                                    <x-input-error-validation error="geojson_text_area" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="block mb-2 text-sm font-semibold">Tentukan Koordinat Titik Tengah
                                            Peta
                                            Kecamatan</p>
                                        <div class="p-3 mb-3 border-2 rounded-md border-slate-300 lg:flex lg:gap-x-2">
                                            <div class="p-3 bg-gray-200 rounded-md shadow-lg lg:w-2/4 lg:h-fit">
                                                <blockquote
                                                    class="p-2 mt-4 mb-2 bg-gray-100 border-l-4 border-yellow-300 rounded-sm">
                                                    <p
                                                        class="text-[13px] font-medium italic leading-relaxed text-yellow-500">
                                                        Titik tengah
                                                        koordinat peta akan otomatis ditentukan
                                                        saat file geojson telah dipilih atau text geosjon telah di
                                                        preview
                                                        pada peta, atau
                                                        juga
                                                        dapat ditentukan dengan klik pada peta</p>
                                                </blockquote>
                                                <x-input-default-form type="text" name="latitude" :value="old('latitude')"
                                                    id="latitude" labelTitle="Latitude / Garis Lintang*" error='latitude'
                                                    placeholder="-8.2402961">
                                                </x-input-default-form>
                                                <x-input-default-form type="text" name="longitude"
                                                    :value="old('longitude')" id="longitude" labelTitle="Longitude / Garis Bujur*"
                                                    error='longitude' placeholder="111.4484781">
                                                </x-input-default-form>
                                                <button type="button" id="buttonFindOnMap"
                                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-3 py-2.5 text-center">Cari
                                                    pada peta</button>
                                            </div>
                                            <div class="mt-5 lg:w-2/4 lg:mt-0 h-120">
                                                <x-head.leaflet-init />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end mt-8 gap-x-2">
                            <button type="button" onclick="history.back()"
                                class="text-white bg-gray-600 hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Kembali</button>
                            <button type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @section('script')
        @include('js.leaflet-find-marker')
        @include('sub-district.js.preview-geojson-to-map')
        @include('sub-district.js.color-picker')
    @endsection
</x-app-layout>
