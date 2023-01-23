<aside class="min-h-screen border-r">
    <div class="relative flex items-center w-full h-16 ml-3 border-b">
        <img class="w-11 h-11" src="{{ asset('assets/images/trenggalek.png') }}" alt="Trenggalek">
        <h1 class="absolute mr-3 text-sm font-bold text-black ml-14">Sistem Informasi Geografis Wisata Trenggalek</h1>
    </div>
    <div class="mt-6 text-sm text-gray-800 ">
        <ul>
            <li class="flex">
                <x-side-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    <x-slot name="svgIcon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="1" stroke="#0ea5e9" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <polyline points="5 12 3 12 12 3 21 12 19 12"></polyline>
                            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path>
                            <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"></path>
                        </svg>
                    </x-slot>
                    <x-slot name="title">Dashboard</x-slot>
                </x-side-link>
            </li>
            @can('view_superadmin_menu')
                <li class="flex">
                    <x-side-link :href="route('users.index')" :active="request()->routeIs('users*')">
                        <x-slot name="svgIcon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="1" stroke="#18181b"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                            </svg>
                        </x-slot>
                        <x-slot name="title">Administrator WebGIS</x-slot>
                    </x-side-link>
                </li>
                <li class="flex">
                    <x-side-link :href="route('sub-districts.index')" :active="request()->routeIs('sub-districts*')">
                        <x-slot name="svgIcon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map" width="24"
                                height="24" viewBox="0 0 24 24" stroke-width="1" stroke="#16a34a" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <polyline points="3 7 9 4 15 7 21 4 21 17 15 20 9 17 3 20 3 7"></polyline>
                                <line x1="9" y1="4" x2="9" y2="17"></line>
                                <line x1="15" y1="7" x2="15" y2="20"></line>
                            </svg>
                        </x-slot>
                        <x-slot name="title">Data Kecamatan</x-slot>
                    </x-side-link>
                </li>
            @endcan
            <li x-data="{
                toggleDropdown: '{{ request()->routeIs('tourist-destination-categories*') || request()->routeIs('tourist-destinations*') }}',
                get isDropdownOpen() { return this.toggleDropdown },
                toggleTheDropdown() { this.toggleDropdown = !this.toggleDropdown },
            }" class="mr-2">
                <button @click="toggleTheDropdown()"
                    class="flex items-center w-full h-12 pl-4 my-1 ml-1 hover:bg-gray-300 hover:rounded-md hover:text-gray-900"
                    :class="{ ' rounded-lg bg-gray-300 text-gray-900': toggleDropdown }">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-category-2"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="1" stroke="#d97706"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M14 4h6v6h-6z"></path>
                            <path d="M4 14h6v6h-6z"></path>
                            <circle cx="17" cy="17" r="3"></circle>
                            <circle cx="7" cy="7" r="3"></circle>
                        </svg>
                    </div>
                    <div class="flex items-center justify-between w-full pr-2 ml-4">
                        Kelola Destinasi Wisata
                        @if (request()->routeIs('tourist-destination-categories*') || request()->routeIs('tourist-destinations*'))
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                :class="{ '-rotate-90 duration-200': !toggleDropdown, 'duration-200': toggleDropdown }">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                :class="{ 'rotate-90 duration-200': toggleDropdown, 'duration-200': !toggleDropdown }">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <polyline points="9 6 15 12 9 18"></polyline>
                            </svg>
                        @endif
                    </div>
                </button>

                <div x-cloak x-show="isDropdownOpen" x-transition:enter="transform duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-6"
                    x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transform duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2"
                    class="w-full my-1 ml-1 mr-1 bg-gray-200 rounded-md">
                    <ul>
                        <li class="flex mt-1">
                            <x-side-link :href="route('tourist-destination-categories.index')" class="pl-9" :active="request()->routeIs('tourist-destination-categories*')"
                                spanClasses="-ml-9 mr-1 bg-blue-500 rounded-tr-lg rounded-br-lg" titleClasses="-ml-5">
                                <x-slot name="title">Kategori Destinasi Wisata</x-slot>
                            </x-side-link>
                        </li>
                        <li class="flex">
                            <x-side-link :href="route('tourist-destinations.index')" class="pl-9" :active="request()->routeIs('tourist-destinations*')"
                                spanClasses="-ml-9 mr-1 bg-blue-500 rounded-tr-lg rounded-br-lg" titleClasses="-ml-5">
                                <x-slot name="title">Destinasi Wisata</x-slot>
                            </x-side-link>
                        </li>
                    </ul>
                </div>
            </li>
            <li x-data="{ toggleDropdown: false }" class="mr-2">
                <button @click="toggleDropdown = ! toggleDropdown"
                    class="flex items-center w-full h-12 pl-4 my-1 ml-1 hover:bg-gray-300 hover:rounded-md hover:text-gray-900"
                    :class="{ ' rounded-lg bg-gray-300 text-gray-900': toggleDropdown }">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-category-2"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="1" stroke="#d97706"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M14 4h6v6h-6z"></path>
                            <path d="M4 14h6v6h-6z"></path>
                            <circle cx="17" cy="17" r="3"></circle>
                            <circle cx="7" cy="7" r="3"></circle>
                        </svg>
                    </div>
                    <div class="flex items-center justify-between w-full pr-2 ml-4">
                        Kelola Desa Wisata
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"
                            :class="{ 'rotate-90 duration-200': toggleDropdown, ' duration-200': !toggleDropdown }">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <polyline points="9 6 15 12 9 18"></polyline>
                        </svg>
                    </div>
                </button>

                <div x-cloak x-show="toggleDropdown" x-transition:enter="transform duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-6"
                    x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transform duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2"
                    class="w-full my-1 ml-1 mr-1 bg-gray-200 rounded-md">
                    <ul>
                        <li class="flex mt-1">
                            <x-side-link class="pl-9">
                                <x-slot name="title">Kategori Desa Wisata</x-slot>
                            </x-side-link>
                        </li>
                        <li class="flex">
                            <x-side-link class="pl-9 hover:ml-1">
                                <x-slot name="title">Desa Wisata</x-slot>
                            </x-side-link>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="flex">
                <x-side-link>
                    <x-slot name="svgIcon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brush"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="#292524"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M3 21v-4a4 4 0 1 1 4 4h-4"></path>
                            <path d="M21 3a16 16 0 0 0 -12.8 10.2"></path>
                            <path d="M21 3a16 16 0 0 1 -10.2 12.8"></path>
                            <path d="M10.6 9a9 9 0 0 1 4.4 4.4"></path>
                        </svg>
                    </x-slot>
                    <x-slot name="title">Map Drawer</x-slot>
                </x-side-link>
            </li>
        </ul>
    </div>
</aside>
