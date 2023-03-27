<x-app-layout>
    <div class="py-8">
        <div class="static mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="relative shadow-md sm:rounded-lg">
                <div class="px-5 pt-5 pb-10 text-lg font-semibold text-left text-gray-700 bg-white">
                    <h1 class="font-bold">Kelola Data Kategori Destinasi Wisata</h1>
                    <div class="justify-between block mt-5 md:flex">
                        <div class="md:flex">
                            <a x-data x-tooltip.raw="Tambah data kategori dan sub kategori baru"
                                href="{{ route('dashboard.categories.create') }}" type="button"
                                class="flex items-center py-2.5 w-fit px-2 mr-2 mb-2 mt-3 text-sm font-medium text-white focus:outline-none bg-green-600 rounded-lg border border-gray-200 hover:bg-green-500 focus:z-10 focus:ring-2 focus:ring-gray-200">
                                Tambah Data Kategori
                                <span class="flex items-center ml-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus"
                                        width="20" height="20" viewBox="0 0 24 24" stroke-width="3"
                                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>
                                </span>
                            </a>
                        </div>
                        <div class="h-10 mt-3 mb-5 md:w-4/12">
                            <form action="{{ route('dashboard.categories.search') }}" method="GET">
                                <label for="default-search"
                                    class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                                <div class="relative w-full">
                                    <input type="search" name="search" id="search-dropdown"
                                        value="{{ request('search') }}" @keyup.enter="submit"
                                        class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                        required placeholder="Cari nama kategori" autocomplete="off">
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
                            <a href="{{ route('dashboard.categories.index') }}"
                                class="flex justify-end mt-3 text-sm text-blue-500 hover:underline">
                                Reset pencarian
                            </a>
                        </div>
                    </div>
                </div>
                <div>
                    <div>
                        <div class="overflow-x-auto">
                            @if (!$categories->count())
                                <div class="flex justify-center pt-10 font-semibold text-gray-500">
                                    Data tidak tersedia
                                </div>
                            @else
                                <table class="relative w-full text-sm text-left text-gray-500">
                                    <caption class="p-5 text-lg font-semibold text-left text-gray-800 bg-white">
                                        <p class="w-5/6 mt-1 text-sm font-normal text-gray-700">Berisi daftar kategori destinasi
                                            wisata di Kabupaten Trenggalek. Anda dapat melakukan penelusuran dan melakukan
                                            tindakan terhadapnya</p>
                                    </caption>
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                No
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Nama Kategori
                                            </th>
                                            <th scope="col" class="flex justify-center px-6 py-3">
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
                                                <td class="flex px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                    {{ $category->name }}
                                                </td>
                                                <div>
                                                    <td class="px-6 py-4">
                                                    <x-action-button
                                                        :value="$category->name"
                                                        :relationshipCountOnDelete="$category->tourist_destinations_count"
                                                        relationshipMessageOnDelete="Menghapus {{ $category->name }} membuat {{ $category->tourist_destinations_count }} data destinasi wisata menjadi Tidak Berkategori"
                                                        :showURL="route('dashboard.categories.show', ['category' => $category])"
                                                        :editURL="route('dashboard.categories.edit', ['category' => $category])"
                                                        :deleteURL="route('dashboard.categories.destroy', ['category' => $category])"
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
                            {{ $categories->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>