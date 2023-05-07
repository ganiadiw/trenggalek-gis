<x-app-layout>
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
                            <x-slot name="value">{{ count($webgisAdministrators) }}</x-slot>
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
            <x-head.leaflet-init class="w-full rounded-lg h-128" />
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

    @section('script')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            @foreach ($subDistricts as $subDistrict)
                new L.GeoJSON.AJAX(['{{ asset('storage/geojson/' . $subDistrict->geojson_name) }}'], {
                    style: {
                        'color': '{{ $subDistrict->fill_color }}',
                        'weight': 2,
                        'opacity': 0.4,
                    }
                }).addTo(map);
            @endforeach

            let icon, marker;
            @foreach ($touristDestinations as $key => $touristDestination)
                @if ($touristDestination->category->icon_name)
                    icon = L.icon({
                        iconUrl: '{{ asset('storage/categories/icon/' . $touristDestination->category->icon_name) }}',
                        iconSize: [45, 45],
                        iconAnchor: [23.5, 47],
                        popupAnchor: [0, 0],
                    });
                    marker = L.marker([{{ $touristDestination->latitude }}, {{ $touristDestination->longitude }}], {icon: icon})
                            .addTo(map)
                            .bindPopup(`<b>{{ $touristDestination->name }}</b>
                                        <br />
                                        Kategori: {{ $touristDestination->category->name }}
                                        <br />
                                        Alamat: {{ $touristDestination->address }}
                                        <br />
                                        Jarak dari pusat kota: {{ $touristDestination->distance_from_city_center }}
                                        <br />
                                        <a href="{{ route('dashboard.tourist-destinations.show', ['tourist_destination' => $touristDestination]) }}"><b>Lihat detail</b></a>
                                        <br />
                                        <a href="{{ route('dashboard.tourist-destinations.edit', ['tourist_destination' => $touristDestination]) }}"><b>Ubah data</b></a>
                                        <br />
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ $touristDestination->latitude }}%2C{{ $touristDestination->longitude }}"><b>Buka di Google Maps</b></a>`);
                @else
                    marker = L.marker([{{ $touristDestination->latitude }}, {{ $touristDestination->longitude }}])
                            .addTo(map)
                            .bindPopup(`<b>{{ $touristDestination->name }}</b>
                                        <br />
                                        Kategori: {{ $touristDestination->category->name }}
                                        <br />
                                        Alamat: {{ $touristDestination->address }}
                                        <br />
                                        Jarak dari pusat kota: {{ $touristDestination->distance_from_city_center }}
                                        <br />
                                        <a href="{{ route('dashboard.tourist-destinations.show', ['tourist_destination' => $touristDestination]) }}"><b>Lihat detail</b></a>
                                        <br />
                                        <a href="{{ route('dashboard.tourist-destinations.edit', ['tourist_destination' => $touristDestination]) }}"><b>Ubah data</b></a>
                                        <br />
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ $touristDestination->latitude }}%2C{{ $touristDestination->longitude }}"><b>Buka di Google Maps</b></a>`);
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
