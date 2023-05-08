<x-app-layout>
    <div class="py-4">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <form class="px-8 py-6 mt-5 bg-white border-2 rounded-md shadow-lg" method="POST" enctype="multipart/form-data"
                action="{{ route('dashboard.categories.store') }}">
                @csrf
                <h1 class="mb-5 text-lg font-bold text-gray-700">Tambah Data Kategori Destinasi Wisata</h1>
                <div class="mb-5">
                    <div class="grid gap-x-5 md:grid-cols-2">
                        <x-input-default-form type="text" name="name" :value="old('name')" id="name"
                            labelTitle="Nama Kategori*" error='name' placeholder="Kategori Destinasi Wisata" required />
                        <div>
                            <x-input-default-form type="file" name="icon" id="icon"
                                labelTitle="Icon Kategori" error='icon' />
                            <p class="flex mt-6 text-sm text-yellow-500">
                                <span class="mr-3 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-info-circle" width="20" height="20"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <circle cx="12" cy="12" r="9"></circle>
                                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                        <polyline points="11 12 12 12 12 16 13 16"></polyline>
                                    </svg>
                                </span>
                                Format gambar harus berformat .png dengan latar belakang transparan, icon ini akan
                                digunakan sebagai marker dari destinasi wisata yang berkategori ini. Jika tidak
                                menambahkan icon, maka icon default akan digunakan.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex gap-x-2">
                    <a button onclick="history.back()"
                        class="text-white bg-gray-600 hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Kembali</a>
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Simpan</button>
                </div>
            </form>
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
