<x-app-layout>
    <div>
        <div class="px-4 py-4 mx-auto text-gray-900 max-w-7xl sm:px-6 lg:px-8">
            <div class="px-8 py-6 mt-5 bg-white border-2 rounded-md shadow-lg">
                <h1 class="w-full text-lg font-bold">Detail Informasi Kategori Destinasi Wisata</h1>
                <div class="w-full mt-5">
                    <div class="grid">
                        <div>
                            <h2 class="text-base font-semibold text-gray-800">Data Kategori</h2>
                            <div
                                class="grid p-5 mt-3 border-2 border-gray-200 rounded-md shadow-md gap-x-5 lg:grid-cols-2">
                                <x-input-default-form type="text" name="name" :value="$category->name" id="name"
                                    labelTitle="Nama Kategori*" error='name'
                                    placeholder="Kategori Destinasi Wisata" :disabled=true />
                                <div>
                                    <h3 class="mb-2 text-sm font-medium text-gray-900">Marker Kustom</h3>
                                    @if ($category->svg_name)
                                        <div class="flex items-center space-x-3 text-sm h-9">
                                            <div class="flex items-center">
                                                <p>Warna Marker:</p>
                                                <div class="flex items-center ml-3 rounded-sm w-7 h-7" style="background-color: {{ $category->hex_code }}"></div>
                                            </div>
                                            <div class="flex items-center">
                                                <div>
                                                    Icon Marker :
                                                </div>
                                                <div class="ml-3">
                                                    <i class="{{ $category->svg_name }}"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <p class="flex items-center text-sm h-9">Tidak ada marker kustom</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end mt-8 gap-x-2">
                        <button onclick="history.back()"
                            class="text-white bg-gray-600 hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Kembali</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
