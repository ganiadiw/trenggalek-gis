<x-app-layout>
    <div class="py-4">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <form class="px-8 py-6 mt-5 bg-white border-2 rounded-md shadow-lg" method="POST"
                action="{{ route('dashboard.tourist-destinations.store') }}" enctype="multipart/form-data">
                @csrf
                <h1 class="mb-5 text-lg font-bold text-gray-700">
                    Tambah Data Destinasi Wisata</h1>
                <div class="grid gap-x-5 md:grid-cols-2">
                    <x-input-default-form type="text" name="name" :value="old('name')" id="name"
                        labelTitle="Nama Destinasi Wisata*" error="name" placeholder="Pantai Prigi" />
                    <x-input-select-option labelTitle="Pilih Kecamatan*" id="sub_district" name="sub_district_id"
                        error="sub_district">
                        <x-slot name="options">
                            <option value="" disabled selected>Pilih Kecamatan</option>
                            @foreach ($subDistricts as $key => $subDistrict)
                                <option value="{{ $subDistrict }}" @selected(old('sub_district_id') == $subDistrict)
                                    class="text-sm font-normal text-gray-900">
                                    {{ $subDistrict->name }}</option>
                            @endforeach
                        </x-slot>
                    </x-input-select-option>
                    <x-input-select-option labelTitle="Pilih Kategori*" id="categoryId"
                        name="category_id" error="category_id">
                        <x-slot name="options">
                            <option value="" disabled selected>Pilih Kategori</option>
                            @foreach ($categories as $key => $category)
                                <option value="{{ $category->id }}" @selected(old('category') == $category->id)
                                    class="text-sm font-normal text-gray-900">
                                    {{ $category->name }}</option>
                            @endforeach
                        </x-slot>
                    </x-input-select-option>
                    <x-input-default-form type="text" name="address" :value="old('address')" id="address"
                        labelTitle="Alamat Lengkap*" error="address"
                        placeholder="Jl. Raya Pantai Tasikmadu, Ketawang, Tasikmadu, Kec. Watulimo, Kabupaten Trenggalek, Jawa Timur 66382" />
                    <x-input-default-form type="text" name="manager" :value="old('manager')" id="manager"
                        labelTitle="Pengelola*" error="manager" placeholder="DISPARBUD" />
                    <x-input-default-form type="text" name="distance_from_city_center" :value="old('distance_from_city_center')"
                        id="distance_from_city_center" labelTitle="Jarak dari Pusat Kota*"
                        error="distance_from_city_center" placeholder="42 KM" />
                    <x-input-default-form type="text" name="transportation_access" :value="old('transportation_access')"
                        id="transportation_access" labelTitle="Akses Transportasi*" error="transportation_access"
                        placeholder="Bisa diakses dengan Bus Besar, Mobil, dan Sepeda Motor" />
                    <x-input-default-form type="text" name="facility" :value="old('facility')" id="facility"
                        labelTitle="Fasilitas*" error="facility"
                        placeholder="Food Court, Kios Cindera Mata, Mushola, MCK, Spot Selfie, Akses Jalan Bagus" />
                    <x-input-default-form type="file" name="cover_image" id="coverImage"
                        labelTitle="Foto Sampul*" error='cover_image' />
                </div>
                <div class="mb-3 lg:flex lg:gap-x-5">
                    <div class="p-3 bg-gray-200 rounded-md shadow-lg lg:w-2/4 lg:h-fit">
                        <h2 class="font-semibold text-black ">Koordinat Destinasi Wisata</h2>
                        <blockquote class="p-2 my-2 border-l-4 border-yellow-300 rounded-sm bg-gray-50">
                            <p class="text-[13px] italic font-medium leading-relaxed text-yellow-500">Titik koordinat
                                destinasi wisata dapat ditentukan
                                dengan mengisi form latitude dan longitude, atau juga
                                dapat ditentukan dengan klik pada peta</p>
                        </blockquote>
                        <x-input-default-form type="text" name="latitude" :value="old('latitude')" id="latitude"
                            labelTitle="Latitude*" error="latitude" placeholder="-8.2402961" />
                        <x-input-default-form type="text" name="longitude" :value="old('longitude')" id="longitude"
                            labelTitle="Longitude*" error="longitude" placeholder="111.4484781" />
                        <button type="button" id="buttonFindOnMap"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-3 py-2.5 text-center">Cari
                            pada peta</button>
                    </div>
                    <div class="mt-5 lg:w-2/4 lg:mt-0 h-120">
                        <x-head.leaflet-init />
                    </div>
                </div>

                <div class="mb-3 text-black">
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi
                        Destinasi Wisata*</label>
                    <blockquote class="p-2 my-2 bg-gray-100 border-l-4 border-yellow-300 rounded-sm">
                        <p class="text-[13px] font-medium italic leading-relaxed text-yellow-500">Tambahkan deskripsi
                            dari destinasi wisata dan informasi lengkap seputar desinasi wisata tersebut, seperti
                            atraksi wisata yang tersedia</p>
                    </blockquote>
                    <div>
                        <div id="spinner" class="mt-5 -mb-10 text-center">
                            <div role="status">
                                <svg aria-hidden="true"
                                    class="inline w-8 h-8 mr-2 text-gray-200 animate-spin fill-blue-600"
                                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                        <div>
                            <div class="prose-xl">
                                <textarea name="description" id="description" placeholder="Deskripsi destinasi wisata">{!! old('description') !!}</textarea>
                            </div>
                            <x-input-error-validation error="description" />
                        </div>
                    </div>
                </div>

                <div>
                    <input type="hidden" name="media_files" id="mediaFiles">
                </div>

                <div class="flex gap-x-2">
                    <a href="{{ route('dashboard.tourist-destinations.index') }}"
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
        @include('js.leaflet-find-marker')
        @include('js.tinymce')
        <script>
            let subDistrict = document.getElementById('sub_district');

            subDistrict.addEventListener('change', function () {
                let geoJSON = JSON.parse(subDistrict.value);

                if (layer) {
                    map.removeLayer(layer)
                }

                layer = new L.GeoJSON.AJAX(['{{ asset('storage/geojson/') }}' + '/' + geoJSON.geojson_name], {
                            style: {
                                'color': geoJSON.fill_color,
                                'weight': 2,
                                'opacity': 0.4,
                            }
                        }).addTo(map);
                map.setView([geoJSON.latitude, geoJSON.longitude], 11);
            })

            FilePond.registerPlugin(
                FilePondPluginImagePreview,
                FilePondPluginFileValidateType,
                FilePondPluginFileValidateSize,
            );

            const inputCoverImage = document.querySelector('input[id="coverImage"]');
            const pond = FilePond.create(inputCoverImage, {
                storeAsFile: true,
                acceptedFileTypes: ['image/png', 'image/jpg', 'image/jpeg'],
                labelFileTypeNotAllowed: 'Format gambar tidak didukung, gunakan  .png, .jpg atau .jpeg',
                fileValidateTypeLabelExpectedTypes: '',
                labelMaxFileSizeExceeded: 'Ukuran gambar terlalu besar',
                maxFileSize: '2048KB',
                labelMaxFileSize: 'Maksimal berukuran 2048 KB',
            });
        </script>
    @endsection
</x-app-layout>
