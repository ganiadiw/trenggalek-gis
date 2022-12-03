<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div>
                <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
                    <!-- Card -->
                    @can('view_superadmin_statistic')
                    <x-statistic-card>
                        <x-slot name="svgIcon">
                            <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-blue-500">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                                    </path>
                                </svg>
                            </div>
                        </x-slot>
                        <x-slot name="title">Total WebGIS Administrator</x-slot>
                        <x-slot name="value">10</x-slot>
                    </x-statistic-card>
                    @endcan
                    <x-statistic-card>
                        <x-slot name="svgIcon">
                            <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-green-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-5 h-5 bi bi-map-fill" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.598-.49L10.5.99 5.598.01a.5.5 0 0 0-.196 0l-5 1A.5.5 0 0 0 0 1.5v14a.5.5 0 0 0 .598.49l4.902-.98 4.902.98a.502.502 0 0 0 .196 0l5-1A.5.5 0 0 0 16 14.5V.5zM5 14.09V1.11l.5-.1.5.1v12.98l-.402-.08a.498.498 0 0 0-.196 0L5 14.09zm5 .8V1.91l.402.08a.5.5 0 0 0 .196 0L11 1.91v12.98l-.5.1-.5-.1z"/>
                                </svg>
                            </div>
                        </x-slot>
                        <x-slot name="title">Total Kecamatan</x-slot>
                        <x-slot name="value">17</x-slot>
                    </x-statistic-card>
                    <x-statistic-card>
                        <x-slot name="svgIcon">
                            <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-green-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                </svg>
                            </div>
                        </x-slot>
                        <x-slot name="title">Total Destinasi Wisata</x-slot>
                        <x-slot name="value">17</x-slot>
                    </x-statistic-card>
                    <x-statistic-card>
                        <x-slot name="svgIcon">
                            <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-green-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                </svg>
                            </div>
                        </x-slot>
                        <x-slot name="title">Total Desa Wisata</x-slot>
                        <x-slot name="value">17</x-slot>
                    </x-statistic-card>
                </div>
            </div>
            <div x-data="openTouristMap">
                <div>
                    <ul class="hidden text-sm font-medium text-center text-gray-500 divide-x divide-gray-200 rounded-lg shadow sm:flex dark:divide-gray-700 dark:text-gray-400">
                        <li class="w-full">
                            <button @click="toggleTouristMap" class="inline-block w-full p-4 text-gray-900 bg-gray-100 rounded-l-lg active focus:outline-none dark:bg-gray-700 dark:text-white" aria-current="page">Peta Destinasi Wisata</button>
                        </li>
                        <li class="w-full">
                            <button class="inline-block w-full p-4 bg-white rounded-r-lg hover:text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-blue-300 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">Peta Desa Wisata</button>
                        </li>
                    </ul>
                </div>
                <div class="flex mt-3">
                    <div x-init="toggleTouristMap" id="touristMap" class="w-3/4 h-128"></div>
                    <div x-show="isTouristMapOpen" class="w-1/4 ml-8">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci delectus animi doloribus alias molestias saepe ratione, tempore, eos minus quo ducimus id cupiditate officiis vel praesentium eveniet qui harum illo.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

    </script>
</x-app-layout>
