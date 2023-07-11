<x-app-layout>
    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="relative rounded-md shadow-md">
                <div class="px-5 pt-5 pb-1 text-lg text-left text-gray-900 bg-white rounded-md">
                    <h1 class="font-bold">Kelola Data Kategori Destinasi Wisata</h1>
                    <div class="w-full mt-10 md:flex md:justify-between">
                        <div class="h-full mt-[3px] mb-5 md:mb-0">
                            <a href="{{ route('dashboard.categories.create') }}"
                                class="h-full px-5 mt-2 py-2.5 mr-2 text-sm font-medium text-white bg-green-700 rounded-lg focus:outline-none hover:bg-green-800 focus:ring-4 focus:ring-green-500">
                                Tambah Data
                            </a>
                        </div>
                        <div class="lg:w-2/5">
                            <form action="{{ route('dashboard.categories.search') }}" method="GET">
                                <div class="flex">
                                    <select required name="column_name"
                                        class="px-4 text-sm font-medium bg-gray-100 border border-gray-300 rounded-l-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100">
                                        <option value="" selected disabled>Cari</option>
                                        <option value="name">Nama Kategori</option>
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
                            <a href="{{ route('dashboard.categories.index') }}"
                                class="flex justify-end mt-3 text-sm text-blue-500 hover:underline">
                                Reset pencarian
                            </a>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    @if (!$categories->count())
                        <div class="flex justify-center pt-10 font-semibold text-gray-500">
                            Data tidak tersedia
                        </div>
                    @else
                        <table class="relative w-full text-sm text-left text-gray-500">
                            <caption class="px-5 py-4 text-left bg-white">
                                <blockquote class="p-2 mt-8 bg-gray-100 border-l-4 border-yellow-300 rounded-sm">
                                    <p class="text-sm font-normal text-gray-700">Berisi daftar kategori destinasi
                                        wisata di Kabupaten Trenggalek. Anda dapat melakukan penelusuran dan melakukan
                                        tindakan terhadapnya</p>
                                </blockquote>
                            </caption>
                            <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        No
                                    </th>
                                    <th scope="col" class="px-3 py-3">
                                        Nama Kategori
                                    </th>
                                    <th scope="col" class="px-3 py-3">
                                        Jumlah Destinasi Wisata
                                    </th>
                                    <th scope="col" class="px-3 py-3">
                                        Warna Teks Marker
                                    </th>
                                    <th scope="col" class="px-3 py-3">
                                        Marker Kustom Icon
                                    </th>
                                    <th scope="col" class="flex justify-center px-3 py-3">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $key => $category)
                                    <tr class="bg-white border-b hover:bg-gray-100">
                                        <td class="px-6 py-4">
                                            {{ $key + $categories->firstItem() }}
                                        </td>
                                        <td class="px-3 py-4 font-medium text-gray-900">
                                            {{ $category->name }}
                                        </td>
                                        <td class="px-3 py-4">
                                            {{ $category->tourist_destinations_count }}
                                        </td>
                                        @if ($category->marker_text_color)
                                            <td class="px-3 py-4"><span style="background-color: {{ $category->marker_text_color }};" class="px-2"></span> <span class="mx-2">|</span> <span>{{ $category->marker_text_color }}</span></td>
                                        @else
                                            <td class="px-3 py-4">Tidak ada custom marker</td>
                                        @endif

                                        @if ($category->custom_marker_name)
                                            <td class="px-3 py-4"><img class="w-8 h-8" src="{{ asset('storage/categories/custom-marker/' . $category->custom_marker_name) }}" alt="{{ $category->custom_marker_name }}"></td>
                                        @else
                                            <td class="px-3 py-4">Tidak ada custom marker</td>
                                        @endif
                                        <td class="px-3 py-4">
                                            <x-action-button
                                                :value="$category->name"
                                                :relationshipCountOnDelete="$category->tourist_destinations_count"
                                                relationshipMessageOnDelete="Menghapus {{ $category->name }} membuat {{ $category->tourist_destinations_count }} data destinasi wisata menjadi Tidak Berkategori"
                                                :showURL="route('dashboard.categories.show', ['category' => $category])"
                                                :editURL="route('dashboard.categories.edit', ['category' => $category])"
                                                :deleteURL="route('dashboard.categories.destroy', ['category' => $category])"
                                            />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <div class="py-5 mx-10 mt-1">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
