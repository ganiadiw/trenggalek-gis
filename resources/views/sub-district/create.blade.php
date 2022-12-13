<x-app-layout>
    <div class="py-8">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-24">
            <form class="px-8 py-6 mt-5 bg-white border-2 rounded-md shadow-lg" method="POST" action="{{ route('sub-districts.store') }}" enctype="multipart/form-data">
                @csrf
                <h1 class="mb-5 font-bold text-gray-700">Tambah Data Kecamatan</h1>
                <x-input-text-floating-label type="text" name="code" :value="old('code')" labelTitle="Kode Kecamatan*" error='code'/>
                <x-input-text-floating-label type="text" name="name" :value="old('name')" labelTitle="Nama Kecamatan*" error='name'/>
                <x-input-text-floating-label type="text" name="latitude" :value="old('latitude')" labelTitle="Latitude*" error='latitude'/>
                <x-input-text-floating-label type="text" name="longitude" :value="old('longitude')" labelTitle="Longitude*" error='longitude'/>
                <x-input-text-floating-label type="text" name="fill_color" :value="old('fill_color')" labelTitle="Warna Peta (Hex)" error='fill_color'/>
                <div class="mb-3">
                    <label class="block mb-2 text-sm text-gray-700 " for="file_input">Upload Peta (Format .geojson)*</label>
                    <input class="block w-full h-10 px-3 py-2 text-sm text-gray-900 border border-gray-300 rounded-sm cursor-pointer bg-gray-50 focus:outline-none" name="geojson" aria-describedby="file_input_help" id="file_input" type="file">
                    @error('geojson')
                        <p id="standard_error_help" class="flex items-center mt-2 text-xs text-yellow-700">
                            <span class="mr-3 font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-circle" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <circle cx="12" cy="12" r="9"></circle>
                                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                    <polyline points="11 12 12 12 12 16 13 16"></polyline>
                                </svg>
                            </span>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <p class="mb-4 text-sm text-red-500">* Wajib diisi</p>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Simpan</button>
            </form>
        </div>
    </div>
</x-app-layout>
