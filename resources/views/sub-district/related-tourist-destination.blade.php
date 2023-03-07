<x-app-layout>
    <div class="py-8">
        <div class="static mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="relative shadow-md sm:rounded-lg">
                <div class="px-5 pt-5 pb-5 text-lg font-semibold text-left text-gray-900 bg-white">
                    <h1 class="font-bold">Kelola Data Destinasi Wisata</h1>
                    <div class="block mt-5 md:justify-between md:flex">
                        <div>
                            <h2 class="text-base font-semibold">Data Destinasi Wisata yang Berada di {{ $subDistrict->name }}</h2>
                        </div>
                        <div class="h-10 mt-3 mb-5 md:w-4/12">
                            <form action="{{ route('dashboard.tourist-destinations.search') }}" method="GET">
                                <label for="default-search"
                                    class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                                <div class="relative w-full">
                                    <input type="search" name="search" id="search-dropdown"
                                        value="{{ request('search') }}" @keyup.enter="submit"
                                        class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                        required placeholder="Cari nama atau alamat" autocomplete="off">
                                    <button type="submit"
                                        class="absolute top-0 right-0 p-2.5 text-sm font-medium text-white bg-blue-700 rounded-r-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                        <span class="sr-only">Search</span>
                                    </button>
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
                            <caption class="p-5 text-lg font-semibold text-left text-gray-800 bg-white">
                                <p class="w-5/6 mt-1 text-sm font-normal text-gray-700">Berisi daftar destinasi wisata di {{ $subDistrict->name }}. Anda dapat melakukan
                                    penelusuran dan melakukan tindakan terhadapnya</p>
                                <blockquote class="p-2 my-2 border-l-4 border-yellow-300 rounded-sm bg-gray-50">
                                    <p class="text-[13px] font-medium italic leading-relaxed text-yellow-500">Silihakan <span class="font-bold">Refresh Browser</span> jika data yang telah diubah masih ada</p>
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
                                @foreach ($touristDestinations as $key => $touristDestination)
                                    <tr class="bg-white border-b hover:bg-gray-100">
                                        <td class="px-6 py-4">
                                            {{ $key + $touristDestinations->firstItem() }}
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
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
                    {{ $touristDestinations->links() }}
                </div>
            </div>
            <div class="px-5 py-5 mt-5 bg-white rounded-lg">
                <div class="font-semibold text-gray-700">
                    <h1>Peta Sebaran Destinasi Wisata Kabupaten Trenggalek</h1>
                </div>
                <div class="w-full mt-5 border rounded-lg h-120">
                    <x-head.leaflet-init :latitude="$subDistrict->latitude" :longitude="$subDistrict->longitude" :zoomLevel=12/>
                </div>
            </div>
        </div>
    </div>

    @section('script')
        <script>
            new L.GeoJSON.AJAX(['{{ asset('storage/geojson/' . $subDistrict->geojson_name) }}'], {
                style: {
                    'color': '{{ $subDistrict->fill_color }}',
                    'weight': 2,
                    'opacity': 0.4,
                }
            }).addTo(map);

            @foreach ($touristDestinationMapping as $item)
                L.marker([{{ $item->latitude }}, {{ $item->longitude }}]).addTo(map);
            @endforeach
        </script>
    @endsection
</x-app-layout>