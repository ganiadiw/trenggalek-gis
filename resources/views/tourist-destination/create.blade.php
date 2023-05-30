<x-app-layout>
    <div>
        <div class="px-4 py-4 mx-auto text-gray-900 max-w-7xl sm:px-6 lg:px-8">
            <div class="px-8 py-6 mt-5 bg-white border-2 rounded-md shadow-lg">
                <h1 class="w-full text-lg font-bold">Tambah Data Destinasi Wisata</h1>
                <div class="w-full mt-5">
                    <form method="POST" action="{{ route('dashboard.tourist-destinations.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div>
                            <h2 class="text-base font-semibold text-gray-800">Data Destinasi Wisata</h2>
                            <div
                                class="grid p-5 mt-3 border-2 border-gray-200 rounded-md shadow-md gap-x-5 md:grid-cols-2">
                                <x-input-default-form type="text" name="name" :value="old('name')" id="name"
                                    labelTitle="Nama Destinasi Wisata*" error="name" placeholder="Nama Destinasi Wisata" />
                                <x-input-select-option labelTitle="Pilih Kecamatan*" id="sub_district_id"
                                    name="sub_district_id" error="sub_district_id">
                                    <x-slot name="options">
                                        <option value="" disabled selected>Pilih Kecamatan</option>
                                        @foreach ($subDistricts as $key => $subDistrict)
                                            <option value="{{ $subDistrict->id }}" @selected(old('sub_district_id') == $subDistrict->id)
                                                class="text-sm font-normal text-gray-900">
                                                {{ $subDistrict->name }}</option>
                                        @endforeach
                                    </x-slot>
                                </x-input-select-option>
                                <x-input-select-option labelTitle="Pilih Kategori*" id="categoryId" name="category_id"
                                    error="category_id">
                                    <x-slot name="options">
                                        <option value="" disabled selected>Pilih Kategori</option>
                                        @foreach ($categories as $key => $category)
                                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)
                                                class="text-sm font-normal text-gray-900">
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </x-slot>
                                </x-input-select-option>
                                <x-input-default-form type="text" name="address" :value="old('address')" id="address"
                                    labelTitle="Alamat Lengkap*" error="address"
                                    placeholder="Alamat Lengkap Destinasi Wisata" />
                                <x-input-default-form type="text" name="manager" :value="old('manager')" id="manager"
                                    labelTitle="Pengelola*" error="manager" placeholder="Pengelola Destinasi Wisata" />
                                <x-input-default-form type="text" name="distance_from_city_center" :value="old('distance_from_city_center')"
                                    id="distance_from_city_center" labelTitle="Jarak Destinasi Wisata dari Pusat Kota*"
                                    error="distance_from_city_center" placeholder="42 KM" />
                                <x-input-default-form type="text" name="transportation_access" :value="old('transportation_access')"
                                    id="transportation_access" labelTitle="Akses Transportasi*"
                                    error="transportation_access"
                                    placeholder="Akses Transportasi ke Destinasi Wisata" />
                                <x-input-default-form type="text" name="facility" :value="old('facility')" id="facility"
                                    labelTitle="Fasilitas* (Pisahkan dengan tanda koma dan spasi)" error="facility"
                                    placeholder="Fasilitas Destinasi Wisata" />
                                <x-input-default-form type="file" name="cover_image" id="coverImage"
                                    labelTitle="Foto Sampul*" error='cover_image' />
                            </div>
                        </div>
                        <div class="mt-5">
                            <h2 class="font-semibold">Data Media Sosial (Opsional)</h2>
                            <div
                                class="grid p-5 mt-3 border-2 border-gray-200 rounded-md shadow-md gap-x-5 md:grid-cols-2">
                                <x-input-default-form type="text" name="facebook_url" :value="old('facebook_url')"
                                    id="facebook_url" labelTitle="Alamat URL Facebook" error="facebook_url"
                                    placeholder="URL Facebook Destinasi Wisata" />
                                <x-input-default-form type="text" name="instagram_url" :value="old('instagram_url')"
                                    id="instagram_url" labelTitle="Alamat URL Instagram" error="instagram_url"
                                    placeholder="URL Instagram Destinasi Wisata" />
                                <x-input-default-form type="text" name="twitter_url" :value="old('twitter_url')"
                                    id="twitter_url" labelTitle="Alamat URL Twitter" error="twitter_url"
                                    placeholder="URL Twitter Destinasi Wisata" />
                                <x-input-default-form type="text" name="youtube_url" :value="old('youtube_url')"
                                    id="youtube_url" labelTitle="Alamat URL Youtube" error="youtube_url"
                                    placeholder="URL Youtube Destinasi Wisata" />
                            </div>
                        </div>
                        <div class="mt-5">
                            <h2 class="text-base font-semibold text-gray-800">Data Peta</h2>
                            <div class="p-5 mt-3 border-2 border-gray-200 rounded-md shadow-md">
                                <div>
                                    <p class="block mb-2 text-sm font-semibold">Tentukan Titik Koordinat Destinasi Wisata</p>
                                    <div class="mb-3 rounded-md lg:flex lg:gap-x-3">
                                        <div class="p-3 bg-gray-200 rounded-md shadow-lg lg:w-2/4 lg:h-fit">
                                            <blockquote
                                                class="p-2 mt-4 mb-2 bg-gray-100 border-l-4 border-yellow-300 rounded-sm">
                                                <p
                                                    class="text-[13px] font-medium italic leading-relaxed text-yellow-500">
                                                    Titik koordinat
                                                    destinasi wisata dapat ditentukan
                                                    dengan mengisi form latitude dan longitude, atau juga
                                                    dapat ditentukan dengan klik pada peta</p>
                                            </blockquote>
                                            <x-input-default-form type="text" name="latitude" :value="old('latitude')"
                                                id="latitude" labelTitle="Latitude / Garis Lintang*" error='latitude'
                                                placeholder="-8.2402961">
                                            </x-input-default-form>
                                            <x-input-default-form type="text" name="longitude" :value="old('longitude')"
                                                id="longitude" labelTitle="Longitude / Garis Bujur*" error='longitude'
                                                placeholder="111.4484781">
                                            </x-input-default-form>
                                            <button type="button" id="buttonFindOnMap"
                                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-3 py-2.5 text-center">Cari
                                                pada peta</button>
                                        </div>
                                        <div class="mt-5 lg:w-2/4 lg:mt-0 h-120">
                                            <x-head.leaflet-init />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <h2 class="font-semibold">Data Pendukung</h2>
                            <div class="p-5 mt-3 border-2 border-gray-200 rounded-md shadow-md">
                                <div>
                                    <label for="description" class="block mb-2 text-sm font-semibold">Deskripsi
                                        Destinasi Wisata*</label>
                                    <blockquote class="p-2 my-2 bg-gray-100 border-l-4 border-yellow-300 rounded-sm">
                                        <p class="text-[13px] font-medium italic leading-relaxed text-yellow-500">
                                            Tambahkan
                                            deskripsi
                                            dari destinasi wisata dan informasi lengkap seputar desinasi wisata
                                            tersebut,
                                            seperti
                                            atraksi wisata yang tersedia</p>
                                    </blockquote>
                                    <div>
                                        <div id="spinner" class="mt-5 -mb-10 text-center">
                                            <div role="status">
                                                <svg aria-hidden="true"
                                                    class="inline w-8 h-8 mr-2 text-gray-200 animate-spin fill-blue-600"
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
                                        <div>
                                            <textarea name="description" id="description" placeholder="Deskripsi destinasi wisata">{!! old('description') !!}</textarea>
                                            <x-input-error-validation error="description" />
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-5">
                                    <div class="flex text-sm font-medium text-gray-900">Atraksi Wisata (Opsional)</div>
                                    <div x-cloak x-data="{
                                        inputs: [
                                            @if (old('tourist_attraction_names'))
                                                @foreach (old('tourist_attraction_names') as $key => $value)
                                                    {
                                                        name: '{{ $value }}',
                                                        caption: '{{ old('tourist_attraction_captions')[$key] }}',
                                                        image: '',
                                                    }{{ $loop->last ? '' : ',' }}
                                                @endforeach
                                            @else
                                                { name: '', caption: '', image: '' }
                                            @endif
                                        ]
                                    }">
                                        <template x-for="(input, index) in inputs" :key="index">
                                            <div class="flex p-3 mt-2 mb-5 bg-gray-100 rounded-md md:mb-0" x-data="{ maxCharNameCount: 25, maxLengthInputName: false,  maxCharCaptionCount: 50 }">
                                                <div x-text="index + 1"
                                                    class="flex w-5 mt-2 mr-4 md:mt-0 md:items-center">
                                                </div>
                                                <div
                                                    class="grid w-full sm:grid-cols-2 md:grid-cols-3 gap-y-3 md:gap-y-0 gap-x-3">
                                                    <div>
                                                        <p class="mb-1 text-sm font-semibold">Nama</p>
                                                        <input x-model="input.name" type="text"
                                                            name="tourist_attraction_names[]"
                                                            placeholder="Nama Atraksi Wisata"
                                                            class="bg-gray-50 border h-[39px] border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 px-4"
                                                            autocomplete="off"
                                                            :required="input.image.trim() !== '' || input.caption.trim() !== ''"
                                                            x-init="input.nameCharCount = 0"
                                                            x-on:input="input.nameCharCount = input.name.length; maxLengthInputName = input.name.slice(0, maxCharNameCount)"
                                                            :maxlength="maxCharNameCount">
                                                        <p class="text-[13px]">Maksimal karakter : <span x-text="`${input.nameCharCount}/${maxCharNameCount}`"></span></p>
                                                    </div>
                                                    <div>
                                                        <p class="mb-1 text-sm font-semibold">Keterangan Singkat</p>
                                                        <input x-model="input.caption" type="text"
                                                            name="tourist_attraction_captions[]"
                                                            placeholder="Keterangan Atraksi Wisata"
                                                            class="bg-gray-50 border h-[39px] border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 px-4"
                                                            autocomplete="off"
                                                            :required="input.name.trim() !== '' || input.image.trim() !== ''"
                                                            x-init="input.captionCharCount = 0"
                                                            x-on:input="input.captionCharCount = input.caption.length; maxLengthInputCaption = input.caption.slice(0, maxCharCaptionCount)"
                                                            :maxlength="maxCharCaptionCount">
                                                        <p class="text-[13px]">Maksimal karakter : <span x-text="`${input.captionCharCount}/${maxCharCaptionCount}`"></span></p>
                                                    </div>
                                                    <div>
                                                        <p class="mb-1 text-sm font-semibold">Foto</p>
                                                        <input x-model="input.image" type="file"
                                                            name="tourist_attraction_images[]"
                                                            placeholder="Foto Atraksi Wisata"
                                                            class="bg-gray-50 border h-[39px] border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-4"
                                                            autocomplete="off" accept="image/png, image/jpg, image/jpeg"
                                                            :required="input.name.trim() !== '' || input.caption.trim() !== ''">
                                                    </div>
                                                </div>
                                                <div class="flex mt-[28px] space-x-2 ml-2">
                                                    <button type="button" @click="inputs.splice(index, 1)"
                                                        x-tooltip.raw="Hapus baris"
                                                        class="flex items-center justify-center w-8 h-8 rounded-full hover:bg-red-200">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="text-red-500 icon icon-tabler icon-tabler-x"
                                                            width="24" height="24" viewBox="0 0 24 24"
                                                            stroke-width="2" stroke="currentColor" fill="none"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                            </path>
                                                            <line x1="18" y1="6" x2="6"
                                                                y2="18"></line>
                                                            <line x1="6" y1="6" x2="18"
                                                                y2="18"></line>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </template>
                                        <div class="flex justify-end mt-5">
                                            <button type="button"
                                                @click="inputs.push({ name: '', caption: '', image: '' })"
                                                class="px-4 py-2 text-center text-white bg-green-500 rounded-lg hover:bg-green-600">Tambah
                                                baris</button>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <input type="hidden" name="media_files" id="mediaFiles">
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
        @include('js.leaflet-find-marker')
        @include('js.tinymce')
        @include('tourist-destination.js.find-gejson-layer')
        <script>
            let latitude = document.getElementById('latitude');
            let longitude = document.getElementById('longitude');

            marker = L.marker([latitude.value, longitude.value]).addTo(map);

            FilePond.registerPlugin(
                FilePondPluginImagePreview,
                FilePondPluginFileValidateType,
                FilePondPluginFileValidateSize,
            );

            const inputCoverImage = document.querySelector('input[id="coverImage"]');
            FilePond.create(inputCoverImage, {
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
