<x-app-layout>
    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div>
                <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
                    <!-- Card -->
                    @can('view_superadmin_statistic')
                        <x-statistic-card>
                            <x-slot name="svgIcon">
                                <div
                                    class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-blue-500">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                                        </path>
                                    </svg>
                                </div>
                            </x-slot>
                            <x-slot name="title">Total WebGIS Administrator</x-slot>
                            <x-slot name="value">10</x-slot>
                        </x-statistic-card>
                    @endcan
                    <x-statistic-card>
                        <x-slot name="svgIcon">
                            <div
                                class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-green-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="w-5 h-5 bi bi-map-fill" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M16 .5a.5.5 0 0 0-.598-.49L10.5.99 5.598.01a.5.5 0 0 0-.196 0l-5 1A.5.5 0 0 0 0 1.5v14a.5.5 0 0 0 .598.49l4.902-.98 4.902.98a.502.502 0 0 0 .196 0l5-1A.5.5 0 0 0 16 14.5V.5zM5 14.09V1.11l.5-.1.5.1v12.98l-.402-.08a.498.498 0 0 0-.196 0L5 14.09zm5 .8V1.91l.402.08a.5.5 0 0 0 .196 0L11 1.91v12.98l-.5.1-.5-.1z" />
                                </svg>
                            </div>
                        </x-slot>
                        <x-slot name="title">Total Kecamatan</x-slot>
                        <x-slot name="value">17</x-slot>
                    </x-statistic-card>
                    <x-statistic-card>
                        <x-slot name="svgIcon">
                            <div
                                class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-green-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                                </svg>
                            </div>
                        </x-slot>
                        <x-slot name="title">Total Destinasi Wisata</x-slot>
                        <x-slot name="value">17</x-slot>
                    </x-statistic-card>
                    <x-statistic-card>
                        <x-slot name="svgIcon">
                            <div
                                class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-green-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                                </svg>
                            </div>
                        </x-slot>
                        <x-slot name="title">Total Desa Wisata</x-slot>
                        <x-slot name="value">17</x-slot>
                    </x-statistic-card>
                </div>
            </div>
            <div x-data="{ current: $persist(1) }" class="p-3 bg-white border-2 rounded-md shadow-lg border-slate-300">
                <div>
                    <ul class="flex space-x-5 text-sm text-center text-gray-400 border-b">
                        <li>
                            <button @click="current = 1" class="inline-flex items-center px-6 py-2 hover:text-gray-600"
                                x-bind:class="{
                                    'active text-black border-b-[1px] border-black transition-none hover:text-black': current ===
                                        1
                                }">
                                Peta Destinasi Wisata
                            </button>
                        </li>
                        <li>
                            <button @click="current = 2" class="px-6 py-2 hover:text-gray-600"
                                x-bind:class="{
                                    'active text-black border-b-[1px] border-black transition-none hover:text-black': current ===
                                        2
                                }">
                                Peta Desa Wisata
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="mt-3 text-black">
                    <div x-show="current == 1" x-transition:enter="transform duration-500"
                        x-transition:enter-start="opacity-0 translate-y-6"
                        x-transition:enter-end="opacity-100 translate-y-0" class="static block xl:flex">
                        <div id="touristMap" class="w-full rounded-lg xl:w-3/4 h-128"></div>
                        <div class="w-full mt-5 ml-4 space-y-4 overflow-y-auto xl:mt-0 xl:w-1/4 scrollbar h-128">
                            @for ($i = 0; $i < 5; $i++)
                                <div class="items-center block h-16">
                                    <h3 class="text-lg font-semibold text-gray-500">{{ $i }}</h3>
                                    <p class="mt-1 text-sm font-medium text-gray-500">Statistik Destinasi Wisata</p>
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div x-show="current == 2" x-transition:enter="transform duration-500"
                        x-transition:enter-start="opacity-0 translate-y-6"
                        x-transition:enter-end="opacity-100 translate-y-0" class="block xl:flex">
                        <div id="villageMap" class="w-full rounded-lg xl:w-3/4 h-128"></div>
                        <div class="w-full ml-4 space-y-4 overflow-y-auto xl:mt-0 sm:mt-5 xl:w-1/4 scrollbar h-128">
                            @for ($i = 0; $i < 10; $i++)
                                <div class="items-center block h-16">
                                    <h3 class="text-lg font-semibold text-gray-500">{{ $i }}</h3>
                                    <p class="mt-1 text-sm font-medium text-gray-500">Statistik Desa Wisata</p>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('script')
        <script>
            let touristMap = L.map('touristMap').setView([-8.13593475, 111.64019829777817], 11);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 15,
                minZoom: 10,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(touristMap);

            function popUp(f, l) {
                var out = [];
                if (f.properties) {
                    for (key in f.properties) {
                        out.push(key + ": " + f.properties[key]);
                    }
                    l.bindPopup(out.join("<br />"));
                }
            }

            @foreach ($subDistricts as $subDistrict)
                new L.GeoJSON.AJAX(['{{ asset('storage/geojson/' . $subDistrict->geojson_name) }}'], {
                    onEachFeature: popUp,
                    style: {
                        'color': '{{ $subDistrict->fill_color }}',
                        'weight': 2,
                        'opacity': 0.4,
                    }
                }).addTo(touristMap);
            @endforeach

            let villageMap = L.map('villageMap').setView([-8.13593475, 111.64019829777817], 13);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(villageMap);
        </script>
    @endsection
</x-app-layout>
