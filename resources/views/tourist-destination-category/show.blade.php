<x-app-layout>
    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="h-full py-5 bg-white rounded-md shadow-lg px-7 sm:px-10 border-1 border-slate-300">
                <h1 class="flex justify-center mt-5 mb-10 font-bold text-gray-700">Detail Informasi Kategori
                    {{ $touristDestinationCategory->name }}</h1>
                <div class="grid gap-x-5 md:grid-cols-2">
                    <x-input-default-form type="text" value="{{ $touristDestinationCategory->name }}"
                        labelTitle="Nama Kategori" disabled="true"></x-input-default-form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
