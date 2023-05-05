<x-app-layout>
    <div class="py-4">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="px-8 py-6 mt-5 bg-white border-2 rounded-md shadow-lg">
                <h1 class="mb-5 text-lg font-bold text-gray-700">Informasi Kategori Destinasi Wisata</h1>
                <div class="mb-5">
                    <div class="grid lg:grid-cols-2 lg:gap-x-10">
                        <div class="w-full pr-[42px] lg:pr-0 mb-5">
                            <x-input-default-form type="text" name="category" :value="$category->name" id="category"
                                labelTitle="Nama Kategori*" error='category' placeholder="Destinasi Wisata" :disabled=true />
                                <div>
                            @if ($category->icon_name)
                                <div class="flex items-center mt-10">
                                    <div class="p-3 bg-gray-100 border border-gray-300 rounded-lg w-fit">
                                        <div class="flex items-center">
                                            <h3 class="text-sm">Icon saat ini:</h3>
                                            <div class="px-5">
                                                <img class="flex items-center w-7 h-7" src="{{ asset('storage/categories/icon/' . $category->icon_name) }}" alt="icon">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
