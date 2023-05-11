<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" href="{{ asset('assets/icon/Paomedia-Small-N-Flat-Map.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/@geoman-io/leaflet-geoman-free@latest/dist/leaflet-geoman.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-linedtextarea.css') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <script src="https://unpkg.com/@geoman-io/leaflet-geoman-free@latest/dist/leaflet-geoman.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <div class="max-h-screen font-sans antialiased text-gray-900 bg-gray-100 content">
        <div>
            <nav class="bg-gray-600 border-gray-200 px-2 sm:px-4 py-2.5 w-full">
                <div class="container flex items-center justify-between w-full">
                    <div class="flex items-center space-x-5">
                        <a href="{{ route('dashboard.map-drawer') }}" class="flex items-center text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-2"
                                width="30" height="30" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7.5"></path>
                                <path d="M9 4v13"></path>
                                <path d="M15 7v5.5"></path>
                                <path
                                    d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z">
                                </path>
                                <path d="M19 18v.01"></path>
                            </svg>
                            <span class="self-center ml-3 text-xl font-semibold whitespace-nowrap">Map Drawer</span>
                        </a>
                        <div class="hidden lg:block">
                            <p class="text-sm text-yellow-400">Saat ini hanya bisa untuk membuat peta baru, belum bisa
                                untuk mengubah dari peta yang sudah ada</p>
                        </div>
                    </div>
                    <div class="py-1 my-2 sm:my-0" id="navbar-default">
                        <a href="{{ route('dashboard') }}"
                            class="px-3 py-2 mb-2 mr-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-500 focus:ring-2 focus:ring-blue-300">Dashboard</a>
                    </div>
                </div>
                <div class="lg:hidden">
                    <p class="text-sm text-yellow-400">Saat ini hanya bisa untuk membuat peta baru, belum bisa untuk
                        mengubah dari peta yang sudah ada</p>
                </div>
            </nav>
        </div>
        <div x-data="{ open: true }">
            <div class="relative flex">
                <div class="z-0 w-full min-h-screen" id="map"></div>
                <div class="relative">
                    <div class="absolute top-[40%] right-[15.3rem] sm:right-[20.3rem] md:right-[26.3rem] z-10">
                        <button x-show="open" @click="open = ! open" type="button"
                            x-transition:enter="transform duration-200"
                            x-transition:enter-start="opacity-0 translate-x-6"
                            x-transition:enter-end="opacity-100 translate-x-0"
                            x-transition:leave="transition duration-200"
                            x-transition:leave-start="opacity-100 translate-x-0"
                            x-transition:leave-end="opacity-0 translate-x-6"
                            class="flex items-center justify-center px-1 py-2 text-xs text-center text-gray-700 bg-white border border-gray-300 rounded-sm hover:border-gray-400 hover:bg-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-arrow-badge-right-filled"
                                :class="{ 'rotate-180 duration-200': !open, 'duration-400': open }" width="24"
                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path
                                    d="M7 6l-.112 .006a1 1 0 0 0 -.669 1.619l3.501 4.375l-3.5 4.375a1 1 0 0 0 .78 1.625h6a1 1 0 0 0 .78 -.375l4 -5a1 1 0 0 0 0 -1.25l-4 -5a1 1 0 0 0 -.78 -.375h-6z"
                                    stroke-width="0" fill="currentColor"></path>
                            </svg>
                        </button>
                    </div>
                    <div x-show="open" x-transition:enter="transform duration-200"
                        x-transition:enter-start="opacity-0 translate-x-6"
                        x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition duration-200"
                        x-transition:leave-start="opacity-100 translate-x-0"
                        x-transition:leave-end="opacity-0 translate-x-6"
                        class="absolute right-0 w-[15rem] sm:w-[20rem] md:w-[26rem] bg-gray-100 h-screen border-1 z-20">
                        <div>
                            <textarea class="w-full h-[92vh] overflow-y-scroll text-blue-600 resize-none linedtextarea lined linedwrap"
                                name="result" id="result" wrap="off"></textarea>
                        </div>
                        <div class="ml-3">
                            <button type="button" id="download-button"
                                class="flex items-center justify-center px-2 py-1 mt-3 mr-2 text-xs text-center text-gray-600 border border-gray-300 rounded-sm hover:border-gray-400 hover:bg-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="mr-2 icon icon-tabler icon-tabler-file-download" width="20"
                                    height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z">
                                    </path>
                                    <path d="M12 17v-6"></path>
                                    <path d="M9.5 14.5l2.5 2.5l2.5 -2.5"></path>
                                </svg>
                                Download GeoJSON
                            </button>
                        </div>
                    </div>
                    <div x-cloak x-show="!open" x-transition:enter="transform duration-200"
                        x-transition:enter-start="opacity-0 translate-x-6"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        x-transition:leave="transition duration-200"
                        x-transition:leave-start="opacity-100 translate-x-0"
                        x-transition:leave-end="opacity-0 translate-x-6" class="absolute top-[40%] right-[10px] z-10">
                        <button @click="open = ! open" type="button"
                            class="flex items-center justify-center px-1 py-2 text-xs text-center text-gray-700 bg-white border border-gray-300 rounded-sm hover:border-gray-400 hover:bg-gray-200"
                            :class="{ '-rotate-180 duration-200': open, 'duration-400': !open }">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-arrow-badge-left-filled" width="24"
                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path
                                    d="M17 6h-6a1 1 0 0 0 -.78 .375l-4 5a1 1 0 0 0 0 1.25l4 5a1 1 0 0 0 .78 .375h6l.112 -.006a1 1 0 0 0 .669 -1.619l-3.501 -4.375l3.5 -4.375a1 1 0 0 0 -.78 -1.625z"
                                    stroke-width="0" fill="currentColor"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery-linedtextarea.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(".lined").linedtextarea();
        });

        window.addEventListener('beforeunload', (e) => {
            e.preventDefault();
            e.returnValue = '';
            return;
        });


        let textarea = document.getElementById('result');
        let defaultValue = {
            "type": "FeatureCollection",
            "features": []
        }

        textarea.value = JSON.stringify(defaultValue, undefined, 2);

        let map = L.map('map').setView([-8.13593475, 111.64019829777817], 11);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            minZoom: 10,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        L.PM.setOptIn(true);

        map.pm.addControls({
            position: 'topleft',
            drawText: false,
            dragMode: false,
        });

        map.on('pm:create', function(e) {
            e.layer.options.pmIgnore = false;
            L.PM.reInitLayer(e.layer);
        });

        const getDrawnLayers = () => {
            let geomanLayers = map.pm.getGeomanLayers(true).toGeoJSON();
            textarea.value = JSON.stringify(geomanLayers, undefined, 2);
        }

        map.on('layeradd', (e) => {
            getDrawnLayers();
        });
        map.on('layerremove', (e) => {
            getDrawnLayers();
        });

        const downloadGeoJSON = () => {
            const geojsonData = textarea.value;
            const blob = new Blob([geojsonData], {
                type: "application/json"
            });
            const link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.download = "layer-data.geojson";

            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        const downloadButton = document.getElementById("download-button");
        downloadButton.addEventListener("click", downloadGeoJSON);
    </script>
</body>

</html>
