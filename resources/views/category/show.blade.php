<x-app-layout>
    <div class="py-4">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <form class="px-8 py-6 mt-5 bg-white border-2 rounded-md shadow-lg" method="POST"
                action="{{ route('dashboard.categories.store') }}">
                @csrf
                <h1 class="mb-5 text-lg font-bold text-gray-700">Informasi Kategori Destinasi Wisata</h1>
                <div class="mb-5">
                    <div class="grid lg:grid-cols-2 lg:gap-x-10">
                        <div class="w-full pr-[42px] lg:pr-0 mb-5">
                            <x-input-default-form type="text" name="category" :value="$category->name" id="category"
                                labelTitle="Nama Kategori*" error='category' placeholder="Destinasi Wisata" :disabled=true />
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
