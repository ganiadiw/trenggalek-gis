<x-app-layout>
    <div x-data="{ openModalInstruction: false, selectedColor: '{{ old('color', $category->color) }}' ?? '', svgName: '{{ old('svg_name', $category->svg_name) }}' }">
        <div class="px-4 py-4 mx-auto text-gray-900 max-w-7xl sm:px-6 lg:px-8">
            <div class="px-8 py-6 mt-5 bg-white border-2 rounded-md shadow-lg">
                <h1 class="w-full text-lg font-bold">Edit Data Kategori Destinasi Wisata</h1>
                <div class="w-full mt-5">
                    <form method="POST" action="{{ route('dashboard.categories.update', ['category' => $category]) }}">
                        @csrf
                        @method('PUT')
                        <div class="grid">
                            <div>
                                <h2 class="text-base font-semibold text-gray-800">Data Kategori</h2>
                                <div
                                    class="grid gap-5 p-5 mt-3 border-2 border-gray-200 rounded-md shadow-md lg:grid-cols-2">
                                    <x-input-default-form type="text" name="name" :value="old('name', $category->name)" id="name"
                                        labelTitle="Nama Kategori*" error='name'
                                        placeholder="Kategori Destinasi Wisata"/>
                                    <div>
                                        <p class="block mb-2 text-sm font-medium">Kustom Marker</p>
                                        <div class="p-5 mt-1 border-2 border-gray-200 rounded-md shadow-md">
                                            <blockquote
                                                class="p-2 bg-gray-100 border-l-4 border-yellow-300 rounded-sm">
                                                <p class="text-[13px] font-medium italic leading-relaxed text-yellow-500">
                                                    Bersifat opsional. Jika tidak menambahkan icon, maka icon default akan digunakan atau menggunakan icon yang sebelumnya sudah didaftarkan. Warna teks nama destinasi wisata yang ditampilkan pada peta juga akan sesuai dengan warna marker yang dipilih.
                                                </p>
                                                <div x-data="{ showAlert: false }">
                                                    <button type="button" @click="openModalInstruction = ! openModalInstruction" class="hover:bg-green-600 mb-1 flex items-center text-gray-100 text-[13px] mt-3 font-semibold bg-green-500 px-2.5 py-2 rounded-md">
                                                        Baca Cara Penggunaan
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2 icon icon-tabler icon-tabler-info-circle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                                                            <path d="M12 9h.01"></path>
                                                            <path d="M11 12h1v4h1"></path>
                                                        </svg>
                                                    </button>
                                                    <button type="button" @click="svgName = ''; selectedColor = ''; showAlert = true" class="hover:bg-red-600 mb-1 flex items-center text-gray-100 text-[13px] mt-3 font-semibold bg-red-500 px-2.5 py-2 rounded-md">
                                                        Hapus Kustom Marker Saat Ini
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2 icon icon-tabler icon-tabler-trash-x-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M20 6a1 1 0 0 1 .117 1.993l-.117 .007h-.081l-.919 11a3 3 0 0 1 -2.824 2.995l-.176 .005h-8c-1.598 0 -2.904 -1.249 -2.992 -2.75l-.005 -.167l-.923 -11.083h-.08a1 1 0 0 1 -.117 -1.993l.117 -.007h16zm-9.489 5.14a1 1 0 0 0 -1.218 1.567l1.292 1.293l-1.292 1.293l-.083 .094a1 1 0 0 0 1.497 1.32l1.293 -1.292l1.293 1.292l.094 .083a1 1 0 0 0 1.32 -1.497l-1.292 -1.293l1.292 -1.293l.083 -.094a1 1 0 0 0 -1.497 -1.32l-1.293 1.292l-1.293 -1.292l-.094 -.083z" stroke-width="0" fill="currentColor"></path>
                                                            <path d="M14 2a2 2 0 0 1 2 2a1 1 0 0 1 -1.993 .117l-.007 -.117h-4l-.007 .117a1 1 0 0 1 -1.993 -.117a2 2 0 0 1 1.85 -1.995l.15 -.005h4z" stroke-width="0" fill="currentColor"></path>
                                                        </svg>
                                                    </button>
                                                    <p x-show="showAlert" class="py-1 text-sm text-green-500">Klik simpan untuk menyimpan perubahan</p>
                                                </div>
                                            </blockquote>
                                            <div class="mb-3">
                                                <label for="color" class="block mb-2 text-sm font-medium text-gray-900">Pilih Warna Marker</label>
                                                <select x-model="selectedColor" id="color" name="color" class="w-full px-4 text-sm text-gray-900 border-gray-300 rounded-md bg-gray-50" x-bind:required="svgName !== null && svgName !== ''">
                                                    <option value="" disabled selected>Pilih Warna</option>
                                                    @foreach (\App\Models\Category::COLORS as $key => $color)
                                                        <option value="{{ $color['name'] }}"
                                                            x-bind:selected="selectedColor === '{{ $color['name'] }}'"
                                                            class="text-sm font-normal text-gray-900">
                                                            <span>
                                                                {{ $color['label'] }}
                                                            </span>
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <x-input-error-validation error="color" />
                                            </div>
                                            <div class="w-full">
                                                <label for="svg_name" class="block mb-2 text-sm font-medium text-gray-900">Nama SVG Icon</label>
                                                <input type="text" x-model="svgName" name="svg_name" value="{{ old('svg_name') }}" id="svg_name"
                                                    class="block w-full px-4 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                                    placeholder="fa-solid fa-tree" autocomplete="off">
                                                <x-input-error-validation error="svg_name" />
                                            </div>
                                            <div class="mt-3">
                                                <p class="flex items-center mb-2 text-sm font-medium text-gray-900">
                                                    Live SVG Icon Preview (akan tampil jika nama icon benar) :
                                                    <span class="ml-3">
                                                        <em class="w-10" x-bind:class="svgName"></em>
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
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
        <div x-cloak x-show="openModalInstruction" class="fixed top-0 bottom-0 left-0 right-0 z-50 flex w-screen max-h-screen scale-100">
            <div class="relative flex items-center justify-center w-screen bg-gray-900 bg-opacity-90 md:h-auto">
                <div @click.outside="openModalInstruction = ! openModalInstruction" class="p-10 bg-gray-300 rounded-md h-[40rem] w-[45rem] text-gray-900 overflow-y-auto">
                    <div class="flex justify-end w-full">
                        <button @click="openModalInstruction = ! openModalInstruction" type="button" class="p-1 bg-gray-200 rounded-md -mt-7 -mr-7 hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M18 6l-12 12"></path>
                                <path d="M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">Panduan Pembuatan Custom Marker</h1>
                        <div class="mt-3 text-base text-gray-800">
                            <ol>
                                <li>
                                    <div class="flex">
                                        <p class="w-5">1.</p>
                                        <p class="ml-2">
                                            Buka halaman website <a target="_blank" class="font-semibold hover:underline text-sky-700 after:content-['↗'] after:font-bold" href="https://icons.getbootstrap.com/" rel="noopener">Bootstrap Icon</a>
                                        </p>
                                    </div>
                                    <div class="mt-2 ml-7">
                                        <img class="w-[600px]" src="{{ asset('assets/images/bootstrap-icons-tutorial/step-1.png') }}" alt="Step-1">
                                    </div>
                                </li>
                                <li class="mt-3">
                                    <div  class="flex">
                                        <p class="w-5">2.</p>
                                        <p class="ml-2">Masukkan kata kunci pada kolom pencarian yang disediakan, kemudian akan ditampilkan daftar icon yang sesuai, kemudia klik pada icon yang diiginkan.</p>
                                    </div>
                                    <div class="mt-2 ml-7">
                                        <img class="w-[600px]" src="{{ asset('assets/images/bootstrap-icons-tutorial/step-2.png') }}" alt="Step-2">
                                    </div>
                                </li>
                                <li class="mt-3">
                                    <div class="flex">
                                        <p class="w-5">3.</p>
                                        <p class="ml-2">Salin atau catat nama icon sesuai pada arah panah, sebagai contoh : <span class="font-semibold">bi bi-tree-fill</span> dan masukkan nama tersebut pada kolom <span class="font-semibold">Nama SVG Icon.</span></p>
                                    </div>
                                    <div class="mt-2 ml-7">
                                        <img class="w-[600px]" src="{{ asset('assets/images/bootstrap-icons-tutorial/step-3.png') }}" alt="Step-3">
                                    </div>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
