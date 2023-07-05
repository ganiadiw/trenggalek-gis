<x-app-layout>
    <div>
        <div class="px-4 py-4 mx-auto text-gray-900 max-w-7xl sm:px-6 lg:px-8">
            <div class="px-8 py-6 mt-5 bg-white border-2 rounded-md shadow-lg">
                <h1 class="w-full text-lg font-bold">Edit Data Kategori Destinasi Wisata</h1>
                <div class="w-full mt-5">
                    <form method="POST" action="{{ route('dashboard.categories.update', ['category' => $category]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid">
                            <div>
                                <h2 class="text-base font-semibold text-gray-800">Data Kategori</h2>
                                <div
                                    class="grid gap-5 p-5 mt-3 border-2 border-gray-200 rounded-md shadow-md lg:grid-cols-2">
                                    <x-input-default-form type="text" name="name" :value="old('name', $category->name)" id="name"
                                        labelTitle="Nama Kategori*" error='name'
                                        placeholder="Kategori Destinasi Wisata"/>
                                    <div>
                                        <p class="block mb-2 text-sm font-medium">Kustom Marker</p>
                                        <div class="p-5 mt-1 border-2 border-gray-200 rounded-md shadow-md">
                                            <blockquote
                                                class="p-2 bg-gray-100 border-l-4 border-yellow-300 rounded-sm">
                                                <p class="text-[13px] font-medium italic leading-relaxed text-yellow-500">
                                                    Bersifat opsional. Jika tidak menambahkan icon, maka icon default akan digunakan atau menggunakan icon yang sebelumnya sudah didaftarkan. Warna teks nama destinasi wisata yang ditampilkan pada peta juga akan sesuai dengan warna marker yang dipilih.
                                                </p>
                                            </blockquote>
                                            <div class="mt-3">
                                                <div class="mb-3">
                                                    <label for="markerTextColor" class="block mb-2 text-sm">Warna Teks Marker</label>
                                                    <div class="flex items-center">
                                                        <div class="color-picker"></div>
                                                        <input type="text" name="marker_text_color" value="{{ old('marker_text_color', $category->marker_text_color) }}"
                                                            id="markerTextColor"
                                                            class="ml-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 px-4"
                                                            placeholder="#06b6d4" autocomplete="off">
                                                    </div>
                                                    <x-input-error-validation error="marker_text_color" />
                                                </div>
                                                <div>
                                                    @if ($category->custom_marker_name != null)
                                                        <div class="mb-3">
                                                            <label for="coverImagePreview"
                                                                class="block mb-2 text-sm italic font-medium text-gray-900">Marker kustom saat ini</label>
                                                            <img class="rounded-[4px] w-10" id="coverImagePreview"
                                                                src="{{ asset('storage/categories/custom-marker/' . $category->custom_marker_name) }}"
                                                                alt="{{ $category->custom_marker_name }}">
                                                        </div>
                                                    @endif
                                                    <x-input-default-form type="file" name="custom_marker" id="customMarker"
                                                        labelTitle="Upload marker kustom (file .png)" error='custom_marker' />
                                                </div>
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

    @push('cdn-script')
        <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
        <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
        <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    @endpush

    @section('script')
        @include('category.js.color-picker')
        <script>
            FilePond.registerPlugin(
                FilePondPluginImagePreview,
                FilePondPluginFileValidateType,
                FilePondPluginFileValidateSize,
            );

            const inputCustomMarker = document.querySelector('input[id="customMarker"]');
            FilePond.create(inputCustomMarker, {
                storeAsFile: true,
                acceptedFileTypes: ['image/png'],
                labelFileTypeNotAllowed: 'Format gambar tidak didukung, gunakan  .png, .jpg atau .jpeg',
                fileValidateTypeLabelExpectedTypes: '',
                labelMaxFileSizeExceeded: 'Ukuran gambar terlalu besar',
                maxFileSize: '2048KB',
                labelMaxFileSize: 'Maksimal berukuran 2048 KB',
            });
        </script>
    @endsection
</x-app-layout>
