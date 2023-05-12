<x-app-layout>
    <div>
        <div class="px-4 py-4 mx-auto text-gray-900 max-w-7xl sm:px-6 lg:px-8">
            <div class="px-8 py-6 mt-5 bg-white border-2 rounded-md shadow-lg">
                <h1 class="w-full text-lg font-bold">Ubah Data Kategori Destinasi Wisata</h1>
                <div class="w-full mt-5">
                    <form method="POST" enctype="multipart/form-data"
                        action="{{ route('dashboard.categories.update', ['category' => $category]) }}">
                        @csrf
                        @method('PUT')
                        <div class="grid">
                            <div>
                                <h2 class="text-base font-semibold text-gray-800">Data Kategori</h2>
                                <div
                                    class="grid gap-5 p-5 mt-3 border-2 border-gray-200 rounded-md shadow-md lg:grid-cols-2">
                                    <x-input-default-form type="text" name="name" :value="old('name', $category->name)" id="name"
                                        labelTitle="Nama Kategori*" error='name'
                                        placeholder="{{ $category->name ?? 'Kategori Destinasi Wisata' }}" required />
                                    <div>
                                        <x-input-default-form type="file" name="icon" id="icon"
                                            labelTitle="Icon Kategori" error='icon' />
                                        @if ($category->icon_name)
                                            <div class="flex items-center mt-8">
                                                <div class="p-3 bg-gray-100 border border-gray-300 rounded-lg w-fit">
                                                    <div class="flex items-center">
                                                        <h3 class="text-sm">Icon saat ini:</h3>
                                                        <div class="px-5">
                                                            <img class="flex items-center w-7 h-7"
                                                                src="{{ asset('storage/categories/icon/' . $category->icon_name) }}"
                                                                alt="icon">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div x-data="handleDeleteImage()" class="flex items-center px-5">
                                                    <button x-cloak x-show="deleteButton" type="button" x-data
                                                        x-tooltip.raw="Hapus icon saat ini"
                                                        x-on:click="deleteImage('{{ $category->slug }}')"
                                                        class="font-medium text-red-600 rounded hover:underline disabled:opacity-50">
                                                        Hapus
                                                    </button>
                                                    <div x-cloak x-show="loading" role="status">
                                                        <svg aria-hidden="true"
                                                            class="w-6 h-6 mr-2 text-gray-200 animate-spin fill-green-600"
                                                            viewBox="0 0 100 101" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                                fill="currentColor" />
                                                            <path
                                                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                                fill="currentFill" />
                                                        </svg>
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <blockquote
                                            class="p-2 mt-5 bg-gray-100 border-l-4 border-yellow-300 rounded-sm">
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

            function handleDeleteImage() {
                return {
                    deleteButton: true,
                    loading: false,
                    deleteImage(slug) {
                        if (confirm('Apakah Anda yakin akan menghapusnya?')) {
                            this.deleteButton = false,
                            this.loading = true,
                            fetch('/dashboard/categories/delete-icon/' + slug, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                location.reload();
                            })
                        }
                    }
                }
            }
        </script>
    @endsection
</x-app-layout>
