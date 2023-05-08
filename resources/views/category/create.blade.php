<x-app-layout>
    <div>
        <div class="px-4 py-4 mx-auto text-gray-900 max-w-7xl sm:px-6 lg:px-8">
            <div class="px-8 py-6 mt-5 bg-white border-2 rounded-md shadow-lg">
                <h1 class="w-full text-lg font-bold">Tambah Data Kategori Destinasi Wisata</h1>
                <div class="w-full mt-5">
                    <form method="POST" enctype="multipart/form-data" action="{{ route('dashboard.categories.store') }}">
                        @csrf
                        <div class="grid">
                            <div>
                                <h2 class="text-base font-semibold text-gray-800">Data Kategori</h2>
                                <div
                                    class="grid gap-5 p-5 mt-3 border-2 border-gray-200 rounded-md shadow-md lg:grid-cols-2">
                                    <x-input-default-form type="text" name="name" :value="old('name')" id="name"
                                        labelTitle="Nama Kategori*" error='name'
                                        placeholder="Kategori Destinasi Wisata" required />
                                    <div>
                                        <x-input-default-form type="file" name="icon" id="icon"
                                            labelTitle="Icon Kategori" error='icon' />
                                        <blockquote
                                            class="p-2 mt-8 bg-gray-100 border-l-4 border-yellow-300 rounded-sm">
                                            <p class="text-[13px] font-medium italic leading-relaxed text-yellow-500">
                                                Format gambar harus berformat .png dengan latar belakang transparan,
                                                icon
                                                ini akan
                                                digunakan sebagai marker dari destinasi wisata yang berkategori ini.
                                                Jika
                                                tidak
                                                menambahkan icon, maka icon default akan digunakan
                                            </p>
                                        </blockquote>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end mt-8 gap-x-2">
                            <button onclick="history.back()"
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
        <script>
            FilePond.registerPlugin(
                FilePondPluginImagePreview,
                FilePondPluginFileValidateType,
                FilePondPluginFileValidateSize,
            );

            const inputIcon = document.querySelector('input[id="icon"]');
            FilePond.create(inputIcon, {
                storeAsFile: true,
                acceptedFileTypes: ['image/png'],
                labelFileTypeNotAllowed: 'Format gambar tidak didukung, gunakan  .png',
                fileValidateTypeLabelExpectedTypes: '',
                labelMaxFileSizeExceeded: 'Ukuran gambar terlalu besar',
                maxFileSize: '2048KB',
                labelMaxFileSize: 'Maksimal berukuran 2048 KB',
            });
        </script>
    @endsection
</x-app-layout>
