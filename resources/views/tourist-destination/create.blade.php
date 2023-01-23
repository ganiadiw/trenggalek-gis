<x-app-layout>
    <div class="py-4">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <form class="px-8 py-6 mt-5 bg-white border-2 rounded-md shadow-lg" method="POST"
                action="{{ route('tourist-destinations.store') }}" enctype="multipart/form-data">
                @csrf
                <h1 class="mb-5 text-lg font-bold text-gray-700">
                    Tambah Data Destinasi Wisata</h1>
                <div class="grid gap-x-5 md:grid-cols-2">
                    <x-input-default-form type="text" name="name" :value="old('name')" id="name"
                        labelTitle="Nama Destinasi Wisata*" error="name" placeholder="Pantai Prigi">
                    </x-input-default-form>
                    <x-input-select-option labelTitle="Pilih Kategori*" id="category" name="tourist_destination_category_id" disabledSelected="Pilih Kategori" error="category">
                        <x-slot name="options">
                            @foreach ($categories as $key => $category)
                                <option value="{{ $category->id }}" @selected(old('category') == $category->id) class="text-sm font-normal text-gray-900">
                                    {{ $category->name }}</option>
                            @endforeach
                        </x-slot>
                    </x-input-select-option>
                    <x-input-select-option labelTitle="Pilih Kecamatan*" id="sub_district" name="sub_district_id" disabledSelected="Pilih Kecamatan" error="sub_district">
                        <x-slot name="options">
                            @foreach ($subDistricts as $key => $subDistrict)
                                <option value="{{ $subDistrict->id }}" @selected(old('sub_district') == $subDistrict->id) class="text-sm font-normal text-gray-900">
                                    {{ $subDistrict->name }}</option>
                            @endforeach
                        </x-slot>
                    </x-input-select-option>
                    <x-input-default-form type="text" name="address" :value="old('address')" id="address"
                        labelTitle="Alamat Lengkap*" error="address"
                        placeholder="Jl. Raya Pantai Tasikmadu, Ketawang, Tasikmadu, Kec. Watulimo, Kabupaten Trenggalek, Jawa Timur 66382">
                    </x-input-default-form>
                    <x-input-default-form type="text" name="manager" :value="old('manager')" id="manager"
                        labelTitle="Pengelola*" error="manager" placeholder="DISPARBUD"></x-input-default-form>
                    <x-input-default-form type="text" name="distance_from_city_center" :value="old('distance_from_city_center')"
                        id="distance_from_city_center" labelTitle="Jarak dari Pusat Kota*"
                        error="distance_from_city_center" placeholder="42 KM"></x-input-default-form>
                    <x-input-default-form type="text" name="transportation_access" :value="old('transportation_access')"
                        id="transportation_access" labelTitle="Akses Transportasi*" error="transportation_access"
                        placeholder="Bisa diakses dengan Bus Besar, Mobil, dan Sepeda Motor"></x-input-default-form>
                    <x-input-default-form type="text" name="facility" :value="old('facility')" id="facility"
                        labelTitle="Fasilitas*" error="facility"
                        placeholder="Food Court, Kios Cindera Mata, Mushola, MCK, Spot Selfie, Akses Jalan Bagus">
                    </x-input-default-form>
                </div>
                <div class="mb-3 lg:flex lg:gap-x-5">
                    <div class="p-3 bg-gray-200 rounded-md shadow-lg lg:w-2/4 lg:h-fit">
                        <h2 class="font-semibold text-black ">Koordinat Destinasi Wisata</h2>
                        <blockquote class="p-2 my-2 border-l-4 border-yellow-300 rounded-sm bg-gray-50">
                            <p class="text-[13px] italic font-medium leading-relaxed text-yellow-500">Titik koordinat destinasi wisata dapat ditentukan
                            dengan mengisi form latitude dan longitude, atau juga
                            dapat ditentukan dengan klik pada peta</p>
                        </blockquote>
                        <x-input-default-form type="text" name="latitude" :value="old('latitude')" id="latitude"
                            labelTitle="Latitude*" error="latitude" placeholder="-8.2402961"></x-input-default-form>
                        <x-input-default-form type="text" name="longitude" :value="old('longitude')" id="longitude"
                            labelTitle="Longitude*" error="longitude" placeholder="111.4484781"></x-input-default-form>
                        <button type="button" id="buttonFindOnMap"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-3 py-2.5 text-center">Cari
                            pada peta</button>
                    </div>
                    <div id="touristDestinationMap" class="mt-5 border rounded-lg lg:w-2/4 lg:mt-0 h-120"></div>
                </div>

                <div class="mb-3 text-black">
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi
                        Destinasi Wisata*</label>
                    <blockquote class="p-2 my-2 bg-gray-100 border-l-4 border-yellow-300 rounded-sm">
                        <p class="text-[13px] font-medium italic leading-relaxed text-yellow-500">Tambahkan deskripsi dari destinasi wisata dan informasi lengkap seputar desinasi wisata tersebut, seperti atraksi wisata yang tersedia</p>
                    </blockquote>
                    <div>
                        <div id="spinner" class="mt-5 -mb-10 text-center">
                            <div role="status">
                                <svg aria-hidden="true" class="inline w-8 h-8 mr-2 text-gray-200 animate-spin fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                </svg>
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <div>
                            <div class="prose-xl ">
                                <textarea name="description" id="description" placeholder="Deskripsi destinasi wisata">{!! old('description') !!}</textarea>
                            </div>
                            <x-input-error-validation error="description"></x-input-error-validation>
                        </div>
                    </div>
                </div>

                <div class="flex gap-x-2">
                    <a href="{{ route('tourist-destinations.index') }}"
                        class="text-white bg-gray-600 hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Kembali</a>
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    @section('script')
        <script>
            $(window).on('load', function () {
                $("#spinner").fadeOut(1000);
            })

            let touristDestinationMap = L.map('touristDestinationMap').setView([-8.13593475, 111.64019829777817], 11);
            let buttonFindOnMap = document.getElementById('buttonFindOnMap')
            let layer

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 15,
                minZoom: 10,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(touristDestinationMap);

            touristDestinationMap.on('click', onMapClick)

            let marker
            let latitudeInput = document.getElementById('latitude')
            let longitudeInput = document.getElementById('longitude')

            function onMapClick(event) {
                let latitude = event.latlng.lat
                let longitude = event.latlng.lng

                if (!marker) {
                    marker = L.marker(event.latlng).addTo(touristDestinationMap)
                } else {
                    marker.setLatLng(event.latlng)
                }

                latitudeInput.value = latitude
                longitudeInput.value = longitude
            }

            buttonFindOnMap.addEventListener('click', function() {
                if (!marker) {
                    marker = L.marker([latitudeInput.value, longitudeInput.value]).addTo(touristDestinationMap)
                } else {
                    marker.setLatLng([latitudeInput.value, longitudeInput.value])
                }
            })

            const image_upload_handler = (blobInfo, progress) => new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', 'postAcceptor.php');

                xhr.upload.onprogress = (e) => {
                    progress(e.loaded / e.total * 100);
                };

                xhr.onload = () => {
                    if (xhr.status === 403) {
                    reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
                    return;
                    }

                    if (xhr.status < 200 || xhr.status >= 300) {
                    reject('HTTP Error: ' + xhr.status);
                    return;
                    }

                    const json = JSON.parse(xhr.responseText);

                    if (!json || typeof json.location != 'string') {
                    reject('Invalid JSON: ' + xhr.responseText);
                    return;
                    }

                    resolve(json.location);
                };

                xhr.onerror = () => {
                    reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
                };

                const formData = new FormData();
                formData.append('image', blobInfo.blob(), blobInfo.filename());

                xhr.send(formData);
            });

            tinymce.init({
                selector: 'textarea#description',
                plugins: 'autosave anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount fullscreen preview save',
                toolbar: 'save cancel undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap visualblocks | removeformat fullscreen preview',
                referrer_policy: 'origin',
                promotion: false,
                image_title: true,
                automatic_uploads: true,
                file_picker_types: 'image',
                images_upload_handler: image_upload_handler,
                image_advtab: true,
                image_description: false,
                image_uploadtab: false,
                automatic_uploads: true,
                file_picker_callback: (cb, value, meta) => {
                    const input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');

                    input.addEventListener('change', (e) => {
                        const file = e.target.files[0];

                        const reader = new FileReader();
                        reader.addEventListener('load', () => {
                            /*
                            Note: Now we need to register the blob in TinyMCEs image blob
                            registry. In the next release this part hopefully won't be
                            necessary, as we are looking to handle it internally.
                            */
                            const id = 'blobid' + (new Date()).getTime();
                            const blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                            const base64 = reader.result.split(',')[1];
                            const blobInfo = blobCache.create(id, file, base64);
                            blobCache.add(blobInfo);

                            /* call the callback and populate the Title field with the file name */
                            cb(blobInfo.blobUri(), { title: file.name });
                        });
                        reader.readAsDataURL(file);
                    });

                    input.click();
                },
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }',
                save_oncancelcallback: () => {
                    console.log('Save canceled');
                },
                save_onsavecallback: () => {
                    console.log('Saved');
                }
            });
        </script>
    @endsection
</x-app-layout>