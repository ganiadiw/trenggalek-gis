<x-app-layout>
    @section('style')
        <style>
            .text-shadow-white {
                text-shadow:
                    1px 1px 0 white,
                    -1px -1px 0 white,
                    1px -1px 0 white,
                    -1px 1px white;
            }
        </style>
    @endsection

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div>
                <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
                    <!-- Card -->
                    @can('view_superadmin_statistic')
                        <x-statistic-card>
                            <x-slot name="svgIcon">
                                <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                                        </path>
                                    </svg>
                                </div>
                            </x-slot>
                            <x-slot name="title">Total WebGIS Administrator</x-slot>
                            <x-slot name="value">{{ $webgisAdministratorsCount }}</x-slot>
                        </x-statistic-card>
                    @endcan
                    <x-statistic-card>
                        <x-slot name="svgIcon">
                            <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="w-5 h-5 bi bi-map-fill" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M16 .5a.5.5 0 0 0-.598-.49L10.5.99 5.598.01a.5.5 0 0 0-.196 0l-5 1A.5.5 0 0 0 0 1.5v14a.5.5 0 0 0 .598.49l4.902-.98 4.902.98a.502.502 0 0 0 .196 0l5-1A.5.5 0 0 0 16 14.5V.5zM5 14.09V1.11l.5-.1.5.1v12.98l-.402-.08a.498.498 0 0 0-.196 0L5 14.09zm5 .8V1.91l.402.08a.5.5 0 0 0 .196 0L11 1.91v12.98l-.5.1-.5-.1z" />
                                </svg>
                            </div>
                        </x-slot>
                        <x-slot name="title">Total Kecamatan</x-slot>
                        <x-slot name="value">{{ count($subDistricts) }}</x-slot>
                    </x-statistic-card>
                    <x-statistic-card>
                        <x-slot name="svgIcon">
                            <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-category-2"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M14 4h6v6h-6z"></path>
                                    <path d="M4 14h6v6h-6z"></path>
                                    <path d="M17 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                    <path d="M7 7m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                </svg>
                            </div>
                        </x-slot>
                        <x-slot name="title">Total Kategori Wisata</x-slot>
                        <x-slot name="value">{{ count($categories) }}</x-slot>
                    </x-statistic-card>
                    <x-statistic-card>
                        <x-slot name="svgIcon">
                            <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                                </svg>
                            </div>
                        </x-slot>
                        <x-slot name="title">Total Destinasi Wisata</x-slot>
                        <x-slot name="value">{{ count($touristDestinations) }}</x-slot>
                    </x-statistic-card>
                </div>
            </div>
            <div x-data="searchLocation"
                x-init="$watch('searchInput', () => selectedTouristDestinationIndex = '')"
                class="relative">
                <x-head.leaflet-init class="w-full rounded-lg h-[40rem]" />
                <div class="absolute z-20 w-52 sm:w-80 md:w-96 right-2 top-2">
                    <div class="absolute left-0 flex items-center pl-3 pointer-events-none top-3">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                    </div>
                    <input type="text"
                        x-ref="input"
                        x-model="searchInput"
                        x-on:focus="modalResult = true"
                        x-on:click.outside="modalResult = false"
                        x-on:keyup.escape="modalResult = false"
                        x-on:keyup.down="selectNextList()"
                        x-on:keyup.up="selectPreviousList()"
                        x-on:keyup.enter="goToMarker()"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" placeholder="Telusuri di sini">
                    <div x-cloak x-show="searchInput !== ''" class="absolute flex items-center pl-3 right-3 top-[6px]">
                        <button x-on:click="reset()" type="button" class="p-1 rounded-md hover:bg-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M18 6l-12 12"></path>
                                <path d="M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div x-cloak
                        x-transition
                        x-show="modalResult && filteredTouristDestinations.length > 0"
                        x-ref="touristDestinations"
                        class="mt-1 overflow-y-auto text-sm bg-white border-[1.5px] border-gray-300 rounded-md shadow-lg max-h-64">
                        <template x-for="(touristDestination, index) in filteredTouristDestinations">
                            <button type="button"
                                x-on:click="goToMarker(touristDestination.latitude, touristDestination.longitude, touristDestination.name)"
                                class="w-full p-2 text-left border-b-[1.5px] border-b-gray-300 hover:bg-gray-200"
                                x-bind:class="{ 'bg-gray-200': index === selectedTouristDestinationIndex }">
                                <p class="font-medium text-gray-800" x-text="touristDestination.name"></p>
                                <p class="text-xs text-gray-500 truncate" x-text="touristDestination.address"></p>
                            </button>
                        </template>
                    </div>
                    <div x-cloak x-transition x-show="searchInput !== '' && filteredTouristDestinations.length === 0"
                        class="mt-1 overflow-y-auto text-sm bg-white border-[1.5px] border-gray-300 rounded-md shadow-lg h-fit">
                        <p class="w-full px-2 py-4 text-left text-gray-800">Hasil Tidak Ditemukan</p>
                    </div>
                </div>
            </div>
            <div class="grid w-full gap-4 p-4 pb-10 mt-5 bg-white rounded-md lg:grid-cols-2">
                <div>
                    <h2 class="p-2 mb-5 text-base font-semibold">Statistik Destinasi Wisata Per Kecamatan</h2>
                    <div class="overflow-x-scroll h-[28rem]">
                        <div class="h-[28rem]">
                            <canvas class="p-2" id="subDistrictChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="mt-10 lg:mt-0">
                    <h2 class="p-2 mb-5 text-base font-semibold">Statistik Destinasi Wisata Per Kategori</h2>
                    <div class="overflow-x-scroll h-[28rem]">
                        <div class="h-[28rem]">
                            <canvas class="p-2" id="categoryChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('cdn-script')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush

    @section('script')
        <script src="{{ asset('assets/js/leaflet/leaflet.awesome-markers.js') }}"></script>
        @include('js.search-destination')
        <script>
            let geojsonLayer = L.featureGroup().addTo(map);
            let markerLayer = L.featureGroup().addTo(map);
            let labelMarkerLayer = L.featureGroup().addTo(map);
            let label;

            @foreach ($subDistricts as $subDistrict)
                new L.GeoJSON.AJAX(['{{ asset('storage/geojson/' . $subDistrict->geojson_name) }}'], {
                    style: {
                        'color': '{{ $subDistrict->fill_color }}',
                        'weight': 2,
                        'opacity': 0.4,
                    },
                    onEachFeature(feature, layer) {
                        layer.on('mouseover', function (e) {
                            layer.getElement().style.cursor = 'grab';
                        });
                        layer.on('mousedown', function (e) {
                            layer.getElement().style.cursor = 'grabbing';
                        });
                        layer.on('mouseup', function (e) {
                            layer.getElement().style.cursor = 'grab';
                        });
                    }
                }).addTo(map);

                label = L.divIcon({
                    className: 'font-semibold text-gray-400 whitespace-pre-wrap text-center text-xs cursor-grab',
                    html: '<div class="absolute -mt-2 -ml-9">' + '{{ $subDistrict->name }}' + '</div>'
                });

                L.marker(['{{ $subDistrict->latitude }}', '{{ $subDistrict->longitude }}'], {
                    icon: label
                }).addTo(labelMarkerLayer);
            @endforeach

            let icon, marker, popUp, style, className;

            @foreach ($touristDestinations as $key => $touristDestination)
                popUp = `<div>
                            <h1 class="mb-5 text-lg font-bold">{{ $touristDestination->name }}</h1>
                            <div>
                                <ul>
                                    <li>
                                        <p id="address" class="flex w-full text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="w-5 text-red-700"
                                                fill="currentColor" class="mr-2 bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                                            </svg>
                                            <span class="ml-2">{{ $touristDestination->address }} </span>
                                        </p>
                                    </li>
                                    <li>
                                        <p id="category" class="flex items-center text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-5 text-orange-400 icon icon-tabler icon-tabler-category" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M4 4h6v6h-6z"></path>
                                                <path d="M14 4h6v6h-6z"></path>
                                                <path d="M4 14h6v6h-6z"></path>
                                                <path d="M17 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                            </svg>
                                            <span class="ml-2">{{ $touristDestination->category->name ?? 'Belum Berkategori' }}</span>
                                        </p>
                                    </li>
                                    <li>
                                        <p id="distance" class="flex items-center text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="w-5 text-green-700"
                                                fill="currentColor" class="bi bi-geo-fill" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M4 4a4 4 0 1 1 4.5 3.969V13.5a.5.5 0 0 1-1 0V7.97A4 4 0 0 1 4 3.999zm2.493 8.574a.5.5 0 0 1-.411.575c-.712.118-1.28.295-1.655.493a1.319 1.319 0 0 0-.37.265.301.301 0 0 0-.057.09V14l.002.008a.147.147 0 0 0 .016.033.617.617 0 0 0 .145.15c.165.13.435.27.813.395.751.25 1.82.414 3.024.414s2.273-.163 3.024-.414c.378-.126.648-.265.813-.395a.619.619 0 0 0 .146-.15.148.148 0 0 0 .015-.033L12 14v-.004a.301.301 0 0 0-.057-.09 1.318 1.318 0 0 0-.37-.264c-.376-.198-.943-.375-1.655-.493a.5.5 0 1 1 .164-.986c.77.127 1.452.328 1.957.594C12.5 13 13 13.4 13 14c0 .426-.26.752-.544.977-.29.228-.68.413-1.116.558-.878.293-2.059.465-3.34.465-1.281 0-2.462-.172-3.34-.465-.436-.145-.826-.33-1.116-.558C3.26 14.752 3 14.426 3 14c0-.599.5-1 .961-1.243.505-.266 1.187-.467 1.957-.594a.5.5 0 0 1 .575.411z" />
                                            </svg>
                                            <span class="ml-2">Berjarak {{ $touristDestination->distance_from_city_center }} dari pusat kota</span>
                                        </p>
                                    </li>
                                </ul>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('guest.tourist-destinations.show', ['tourist_destination' => $touristDestination]) }}"
                                    class="inline-flex items-center px-5 py-2 text-sm font-medium bg-green-700 rounded-md hover:bg-green-800 focus:ring-1 focus:ring-green-300">
                                    <span class="text-white">Lihat detail</span>
                                </a>
                                <a href="{{ route('dashboard.tourist-destinations.edit', ['tourist_destination' => $touristDestination]) }}"
                                    class="px-5 py-2 text-sm font-medium bg-yellow-500 rounded-md hover:bg-yellow-600 focus:ring-1 focus:ring-yellow-300">
                                    <span class="text-white">Ubah data</span>
                                </a>
                            </div>
                            <a href="https://www.google.com/maps/search/?api=1&query={{ $touristDestination->latitude }}%2C{{ $touristDestination->longitude }}"
                                target="_blank"
                                class="text-white h-10 mt-3 bg-[#4285F4] hover:bg-[#4285F4]/90 focus:ring-1 focus:outline-none focus:ring-[#4285F4]/50 font-medium rounded-md text-sm px-2.5 py-2 text-center inline-flex items-center mr-2 mb-2">
                                <div class="p-1 bg-white rounded-full">
                                    <img src="{{ asset('assets/icon/Google-Maps-Platform.svg') }}" class="w-5"
                                        alt="Google Maps Icon">
                                </div>
                                <span class="ml-2 text-white">Buka di Google Maps</span>
                            </a>
                        </div>`

                @if ($touristDestination->category && $touristDestination->category->svg_name)
                    className = '.tooltip-text-color-' + '{{ $key }}' + ' ' + '{ color: {{ $touristDestination->category->hex_code }}; }';
                    style = document.createElement('style');
                    style.appendChild(document.createTextNode(className));
                    document.head.appendChild(style);

                    icon = L.AwesomeMarkers.icon({
                                icon: '{{ $touristDestination->category->svg_name }}',
                                markerColor: '{{ $touristDestination->category->color }}'
                            });
                    marker = L.marker([{{ $touristDestination->latitude }}, {{ $touristDestination->longitude }}], {
                                icon: icon,
                            })
                            .addTo(markerLayer)
                            .bindPopup(popUp)
                            .bindTooltip('{{ $touristDestination->name }}', {
                                offset: [19, -23],
                                permanent: true,
                                direction: 'right',
                                className: 'bg-transparent z-10 w-32 whitespace-pre-wrap text-shadow-white border-0 shadow-none font-semibold' + ' ' + 'tooltip-text-color-' + '{{ $key }}'
                            });
                @else
                    marker = L.marker([{{ $touristDestination->latitude }}, {{ $touristDestination->longitude }}])
                            .addTo(markerLayer)
                            .bindPopup(popUp)
                            .bindTooltip('{{ $touristDestination->name }}', {
                                offset: [0, 2],
                                permanent: true,
                                direction: 'right',
                                className: 'bg-transparent z-10 w-32 whitespace-pre-wrap text-shadow-white border-0 shadow-none text-[#277fc9] font-semibold'
                            });
                @endif

                marker.on('click', function(e) {
                    this.openPopup();
                });
            @endforeach

            let jsonSubDistricts = @json($subDistricts);
            let subDistricts = jsonSubDistricts.map((item, index) => ({
                name: item.name,
                count: item.tourist_destinations_count,
                color: item.fill_color + "BF"
            }));

            new Chart(document.getElementById('subDistrictChart'), {
                type: 'bar',
                data: {
                    labels: subDistricts.map(row => row.name),
                    datasets: [{
                        label: 'Jumlah Destinasi Wisata',
                        data: subDistricts.map(row => row.count),
                        borderWidth: 1,
                        backgroundColor: subDistricts.map(row => row.color),
                    }]
                },
                options: {
                    indexAxis: 'y',
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                color: '#000000',
                                callback: (label, index, labels) => {
                                    if (Math.floor(label) === label) {
                                        return label;
                                    }
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: '#000000'
                            }
                        }
                    },
                    maintainAspectRatio: false,
                }
            });

            let jsonCategories = @json($categories);
            let categories = jsonCategories.map((item, index) => ({
                name: item.name,
                count: item.tourist_destinations_count,
            }));
            const autocolors = window['chartjs-plugin-autocolors'];

            const categoryChart = new Chart(document.getElementById('categoryChart'), {
                type: 'bar',
                data: {
                    labels: categories.map(row => row.name),
                    datasets: [{
                        label: 'Jumlah Destinasi Wisata',
                        data: categories.map(row => row.count),
                        borderWidth: 1,
                        backgroundColor: ['#475569BF', '#EF4444BF', '#16A34ABF', '#0284C7BF', '#DB2777BF']
                    }]
                },
                options: {
                    indexAxis: 'y',
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                color: '#000000',
                                callback: (label, index, labels) => {
                                    if (Math.floor(label) === label) {
                                        return label;
                                    }
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: '#000000'
                            },
                        },

                    },
                    maintainAspectRatio: false,
                }
            });
        </script>
    @endsection
</x-app-layout>
