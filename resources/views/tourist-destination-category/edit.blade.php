<x-app-layout>
    <div class="py-4">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <form class="px-8 py-6 mt-5 bg-white border-2 rounded-md shadow-lg" method="POST"
                action="{{ route('tourist-destination-categories.update', ['tourist_destination_category' => $touristDestinationCategory]) }}">
                @csrf
                @method('PUT')
                <h1 class="mb-5 text-lg font-bold text-gray-700">Ubah Data Kategori Destinasi Wisata</h1>
                <div class="grid mb-5 gap-x-5 md:grid-cols-2">
                    <x-input-default-form type="text" name="name" :value="old('name', $touristDestinationCategory->name)" id="name"
                        labelTitle="Nama Kategori*" error='name' placeholder="Wisata Pantai"></x-input-default-form>
                </div>
                <div class="flex gap-x-2">
                    <a href="{{ route('tourist-destination-categories.index') }}"
                        class="text-white bg-gray-600 hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Kembali</a>
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
