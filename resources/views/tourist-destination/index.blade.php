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
            <div class="relative rounded-md shadow-md">
                <div class="px-5 pt-5 pb-1 text-lg text-left text-gray-900 bg-white rounded-md">
                    <h1 class="font-bold">Kelola Data Destinasi Wisata</h1>
                    <div class="w-full mt-10 md:flex md:justify-between">
                        <div class="h-full mt-[3px] mb-5 md:mb-0">
                            <a href="{{ route('dashboard.tourist-destinations.create') }}"
                                class="h-full px-5 mt-2 py-2.5 mr-2 text-sm font-medium text-white bg-green-700 rounded-lg focus:outline-none hover:bg-green-800 focus:ring-4 focus:ring-green-500">
                                Tambah Data
                            </a>
                        </div>
                        <div class="lg:w-2/5">
                            <form action="{{ route('dashboard.tourist-destinations.search') }}" method="GET">
                                <div class="flex">
                                    <select required name="column_name"
                                        class="px-4 text-sm font-medium bg-gray-100 border border-gray-300 rounded-l-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100">
                                        <option value="" selected disabled>Cari</option>
                                        <option value="name">Nama Wisata</option>
                                        <option value="address">Alamat</option>
                                        <option value="manager">Pengelola</option>
                                    </select>
                                    <div class="relative w-full">
                                        <input type="search" name="search_value" @keyup.enter="submit"
                                            value="{{ request('search_value') }}"
                                            class="z-20 block w-full text-sm font-medium text-gray-900 border border-l-2 border-gray-300 rounded-r-lg bg-gray-50 border-l-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="Cari" required autocomplete="off">
                                        <button type="submit"
                                            class="absolute top-0 right-0 p-2 text-sm font-medium text-white bg-blue-700 border border-blue-700 rounded-r-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                            <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                            <span class="sr-only">Search</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <a href="{{ route('dashboard.tourist-destinations.index') }}"
                                class="flex justify-end mt-3 text-sm text-blue-500 hover:underline">
                                Reset pencarian
                            </a>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    @if (!$touristDestinations->count())
                        <div class="flex justify-center pt-10 font-semibold text-gray-500">
                            Data tidak tersedia
                        </div>
                    @else
                        <table class="relative w-full text-sm text-left text-gray-500">
                            <caption class="px-5 py-4 text-left bg-white">
                                <blockquote class="p-2 mt-8 bg-gray-100 border-l-4 border-yellow-300 rounded-sm">
                                    <p class="text-sm font-normal text-gray-700">Berisi daftar destinasi wisata di Kabupaten Trenggalek. Anda dapat melakukan
                                    penelusuran dan melakukan tindakan terhadapnya</p>
                                </blockquote>
                            </caption>
                            <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        No
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nama
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Alamat
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Pengelola
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Jarak Dari Pusat Kota
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Koordinat (Latitude, Longitude)
                                    </th>
                                    <th scope="col" class="flex justify-center px-6 py-3">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($touristDestinationsDataTable as $key => $touristDestination)
                                    <tr class="bg-white border-b hover:bg-gray-100">
                                        <td class="px-6 py-4">
                                            {{ $key + $touristDestinationsDataTable->firstItem() }}
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-900">
                                            {{ $touristDestination->name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $touristDestination->address }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $touristDestination->manager }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $touristDestination->distance_from_city_center }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $touristDestination->coordinate }}
                                        </td>
                                        <div>
                                            <td class="px-6 py-4">
                                                <x-action-button
                                                    :value="$touristDestination->name"
                                                    :showURL="route('dashboard.tourist-destinations.show', ['tourist_destination' => $touristDestination])"
                                                    :editURL="route('dashboard.tourist-destinations.edit', ['tourist_destination' => $touristDestination])"
                                                    :deleteURL="route('dashboard.tourist-destinations.destroy', ['tourist_destination' => $touristDestination])"
                                                />
                                            </td>
                                        </div>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <div class="py-5 mx-10 mt-1">
                    {{ $touristDestinationsDataTable->links() }}
                </div>
            </div>
            <div class="px-5 py-5 mt-5 bg-white rounded-lg">
                <div class="font-semibold text-gray-700">
                    <h1>Peta Sebaran Destinasi Wisata Kabupaten Trenggalek</h1>
                </div>
                <div class="w-full mt-5">
                    <div x-data="searchLocation"
                        x-init="$watch('searchInput', () => selectedTouristDestinationIndex = '')"
                        class="relative">
                        <x-head.leaflet-init class="w-full border-2 border-gray-300 rounded-lg shadow-xl h-[40rem]" />
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
                                        x-on:click.prevent="goToMarker(touristDestination.latitude, touristDestination.longitude, touristDestination.name)"
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
                </div>
            </div>
        </div>
    </div>

    @section('script')
        <script src="{{ asset('assets/js/leaflet/leaflet.awesome-markers.js') }}"></script>
        @include('js.search-destination')
        <script>
            @foreach ($subDistricts as $subDistrict)
                new L.GeoJSON.AJAX(['{{ asset('storage/geojson/' . $subDistrict->geojson_name) }}'], {
                    style: {
                        'color': '{{ $subDistrict->fill_color }}',
                        'weight': 2,
                        'opacity': 0.4,
                    },
                    onEachFeature(feature, layer) {
                        layer.bindTooltip('{{ $subDistrict->name }}', {
                            permanent: true,
                            direction: 'center',
                            className: 'bg-inherit border-0 shadow-none z-0 text-gray-400 font-semibold whitespace-pre-wrap text-center text-xs'
                        });
                    }
                }).addTo(map);
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
                            .addTo(map)
                            .bindPopup(popUp)
                            .bindTooltip('{{ $touristDestination->name }}', {
                                offset: [19, -23],
                                permanent: true,
                                direction: 'right',
                                className: 'bg-transparent z-10 w-32 whitespace-pre-wrap text-shadow-white border-0 shadow-none font-extrabold' + ' ' + 'tooltip-text-color-' + '{{ $key }}'
                            });
                @else
                    marker = L.marker([{{ $touristDestination->latitude }}, {{ $touristDestination->longitude }}])
                            .addTo(map)
                            .bindPopup(popUp)
                            .bindTooltip('{{ $touristDestination->name }}', {
                                offset: [0, 2],
                                permanent: true,
                                direction: 'right',
                                className: 'bg-transparent z-10 w-32 whitespace-pre-wrap text-shadow-white border-0 shadow-none text-[#277fc9] font-extrabold'
                            });
                @endif

                marker.on('click', function(e) {
                    this.openPopup();
                });
            @endforeach
        </script>
    @endsection
</x-app-layout>
