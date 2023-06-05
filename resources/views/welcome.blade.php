<x-guest-layout>
    @section('css')
        <style>
            .swiper {
                width: 100%;
                height: 100%;
            }

            .swiper-slide {
                text-align: center;
                font-size: 18px;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .swiper-slide img {
                display: block;
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .text-shadow-white {
                text-shadow:
                    1px 1px 0 white,
                    -1px -1px 0 white,
                    1px -1px 0 white,
                    -1px 1px white;
            }
        </style>
    @endsection

    <x-slot name="pageTitle">
        {{ $pageTitle->value[0] }}
    </x-slot>

    <div class="relative h-fit bg-slate-950">
        <div class="pt-14 md:pt-20 pb-14 md:pb-20 px-7 md:px-14 lg:px-28">
            {{-- Mobile Swipper --}}
            @if ($heroImagesCount > 0)
                <div class="h-[200px] md:h-[350px] w-full mb-10 xl:hidden">
                    <div class="swiper mySwiper2">
                        <div class="rounded-lg swiper-wrapper">
                            @foreach ($heroImages->value as $key => $heroImage)
                                @if ($heroImage && Storage::exists('page-settings/hero_image/' . $heroImage))
                                    <div class="swiper-slide">
                                        <img class="rounded-lg"
                                            src="{{ asset('storage/page-settings/hero_image/' . $heroImage) }}"
                                            alt="{{ $heroImage }}">
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            <div class="xl:max-w-xl">
                <h1 class="text-4xl font-bold leading-[3rem] text-gray-100">{{ $welcomeMessage->value[0] }}</h1>
                <p class="pr-10 mt-5 text-gray-200 right">{{ $shortDescription->value[0] }}</p>
            </div>
            {{-- XL Swipper --}}
            @if ($heroImagesCount > 0)
                <div class="2xl:w-[600px] xl:h-[300px] xl:w-[520px] absolute xl:-bottom-14 xl:right-24 hidden xl:block">
                    <div class="swiper mySwiper1">
                        <div class="rounded-lg swiper-wrapper">
                            @foreach ($heroImages->value as $key => $heroImage)
                                @if ($heroImage && Storage::exists('page-settings/hero_image/' . $heroImage))
                                    <div class="swiper-slide">
                                        <img class="rounded-lg"
                                            src="{{ asset('storage/page-settings/hero_image/' . $heroImage) }}"
                                            alt="{{ $heroImage }}">
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="px-7 md:px-14 lg:px-28 mt-14">
        <div class="w-full">
            <h2 class="mb-5 text-2xl font-bold ">Peta Destinasi Wisata</h2>
            <div x-data="searchLocation"
                x-init="$watch('searchInput', () => selectedTouristDestinationIndex = '')"
                class="relative">
                <x-head.leaflet-init class="w-full border-2 border-gray-300 rounded-lg shadow-xl h-[40rem]" />
                <div x-data="{ focusInput: true }" class="absolute z-20 w-52 sm:w-80 md:w-96 right-2 top-2">
                    <div class="absolute left-0 flex items-center pl-3 pointer-events-none top-3">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                    </div>
                    <input type="text"
                        x-ref="input"
                        x-model="searchInput"
                        x-on:focus="modalResult = true"
                        x-on:click.outside="modalResult = false"
                        x-on:keyup.escape="modalResult = false"
                        x-on:keyup.down="selectNextList()"
                        x-on:keyup.up="selectPreviousList()"
                        x-on:keyup.enter="goToMarker()"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-10 p-2.5" placeholder="Telusuri di sini">
                    <div x-cloak x-show="searchInput !== ''" class="absolute flex items-center pl-3 right-3 top-[6px]">
                        <button x-on:click="reset()" type="button" class="p-1 rounded-md hover:bg-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M18 6l-12 12"></path>
                                <path d="M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div x-cloak
                        x-transition
                        x-show="modalResult && filteredTouristDestinations.length > 0"
                        x-ref="touristDestinations"
                        class="mt-1 overflow-y-auto text-sm bg-white border-[1.5px] border-gray-300 rounded-md shadow-lg max-h-64">
                        <template x-for="(touristDestination, index) in filteredTouristDestinations">
                            <button type="button"
                                x-on:click.prevent="goToMarker(touristDestination.latitude, touristDestination.longitude, touristDestination.name)"
                                class="w-full p-2 text-left border-b-[1.5px] border-b-gray-300 hover:bg-gray-200"
                                x-bind:class="{ 'bg-gray-200': index === selectedTouristDestinationIndex }">
                                <p class="font-medium text-gray-800" x-text="touristDestination.name"></p>
                                <p class="text-xs text-gray-500 truncate" x-text="touristDestination.address"></p>
                            </button>
                        </template>
                    </div>
                    <div x-cloak x-transition x-show="searchInput !== '' && filteredTouristDestinations.length === 0"
                        class="mt-1 overflow-y-auto text-sm bg-white border-[1.5px] border-gray-300 rounded-md shadow-lg h-fit">
                        <p class="w-full px-2 py-4 text-left text-gray-800">Hasil Tidak Ditemukan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full mt-[50px] px-7 md:px-14 lg:px-28 bg-black py-16">
        <div class="items-center w-full space-y-10 md:space-y-0 md:space-x-10 md:flex">
            <div class="md:w-2/5">
                <h5 class="mb-3 text-xl font-bold text-center text-gray-200 md:text-2xl xl:text-3xl">
                    Tahukah kamu, apa saja dan berapa jumlah destinasi wisata yang terdapat di Kabupaten
                    Trenggalek?
                </h5>
            </div>
            <div class="md:h-[300px] md:overflow-y-auto md:w-3/5">
                <div class="grid content-center grid-cols-2 gap-3 px-5 sm:grid-cols-3 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($categories as $category)
                        @if ($category->tourist_destinations_count > 0)
                            <div class="content-center py-3 md:py-6 text-center bg-[#404040] rounded-sm">
                                <div x-data="{ current: 0, target: {{ $category->tourist_destinations_count }}, time: 300 }" x-init="() => {
                                    start = current;
                                    const interval = Math.max(time / (target - start), 5);
                                    const step = (target - start) / (time / interval);
                                    const handle = setInterval(() => {
                                        if (current < target)
                                            current += step
                                        else {
                                            clearInterval(handle);
                                            current = target
                                        }
                                    }, interval);
                                }"
                                    class="w-full mb-2 md:mb-4 text-5xl md:text-6xl h-14 font-bold text-[#26c772]">
                                    <p x-cloak x-text="Math.round(current)"></p>
                                </div>
                                <p class="text-gray-200">{{ $category->name }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="py-10 bg-gray-600 px-7 md:px-14 lg:px-28">
        <h2 class="mb-5 text-xl font-bold text-gray-100">Sekilas Tentang Sistem Informasi Ini</h2>
        <div class="text-gray-100">
            <p>{!! $aboutPage->value[0] !!}</p>
            <a href=""></a>
        </div>
    </div>

    @push('cdn-script')
        <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    @endpush

    @section('script')
        @include('js.search-destination')
        <script>
            let swiper = new Swiper(".mySwiper1", {
                cssMode: true,
                loop: true,
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: ".swiper-pagination",
                },
                mousewheel: true,
                keyboard: true,
            });

            let swiper2 = new Swiper(".mySwiper2", {
                cssMode: true,
                loop: true,
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                },
            });

            let geojsonLayer = L.featureGroup().addTo(map);
            let markerLayer = L.featureGroup().addTo(map);
            let labelMarkerLayer = L.featureGroup().addTo(map);
            let label;

            @foreach ($subDistricts as $subDistrict)
                new L.GeoJSON.AJAX(['{{ asset('storage/geojson/' . $subDistrict->geojson_name) }}'], {
                    style: {
                        color: '{{ $subDistrict->fill_color }}',
                        weight: 2,
                        opacity: 0.4,
                    },
                    onEachFeature(feature, layer) {
                        layer.on('mouseover', function (e) {
                            layer.getElement().style.cursor = 'grab';
                        });
                        layer.on('mousedown', function (e) {
                            layer.getElement().style.cursor = 'grabbing';
                        });
                        layer.on('mouseup', function (e) {
                            layer.getElement().style.cursor = 'grab';
                        });
                    }
                }).addTo(geojsonLayer);

                label = L.divIcon({
                    className: 'font-semibold text-gray-400 whitespace-pre-wrap text-center text-xs cursor-grab',
                    html: '<div class="absolute -left-7 -top-2">' + '{{ $subDistrict->name }}' + '</div>'
                });

                L.marker(['{{ $subDistrict->latitude }}', '{{ $subDistrict->longitude }}'], {
                    icon: label
                }).addTo(labelMarkerLayer);
            @endforeach

            let icon, marker, popUp, style, className;
            @foreach ($touristDestinations as $key => $touristDestination)
                popUp = `<div>
                        <h1 class="mb-5 text-lg font-bold">{{ $touristDestination->name }}</h1>
                        <div>
                            <ul>
                                <li>
                                    <p id="address" class="flex w-full text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="w-5 text-red-700"
                                            fill="currentColor" class="mr-2 bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                                        </svg>
                                        <span class="ml-2">{{ $touristDestination->address }} </span>
                                    </p>
                                </li>
                                <li>
                                    <p id="category" class="flex items-center text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="w-5 text-orange-400 icon icon-tabler icon-tabler-category" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M4 4h6v6h-6z"></path>
                                            <path d="M14 4h6v6h-6z"></path>
                                            <path d="M4 14h6v6h-6z"></path>
                                            <path d="M17 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                        </svg>
                                        <span class="ml-2">{{ $touristDestination->category->name ?? 'Belum Berkategori' }}</span>
                                    </p>
                                </li>
                                <li>
                                    <p id="distance" class="flex items-center text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="w-5 text-green-700"
                                            fill="currentColor" class="bi bi-geo-fill" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M4 4a4 4 0 1 1 4.5 3.969V13.5a.5.5 0 0 1-1 0V7.97A4 4 0 0 1 4 3.999zm2.493 8.574a.5.5 0 0 1-.411.575c-.712.118-1.28.295-1.655.493a1.319 1.319 0 0 0-.37.265.301.301 0 0 0-.057.09V14l.002.008a.147.147 0 0 0 .016.033.617.617 0 0 0 .145.15c.165.13.435.27.813.395.751.25 1.82.414 3.024.414s2.273-.163 3.024-.414c.378-.126.648-.265.813-.395a.619.619 0 0 0 .146-.15.148.148 0 0 0 .015-.033L12 14v-.004a.301.301 0 0 0-.057-.09 1.318 1.318 0 0 0-.37-.264c-.376-.198-.943-.375-1.655-.493a.5.5 0 1 1 .164-.986c.77.127 1.452.328 1.957.594C12.5 13 13 13.4 13 14c0 .426-.26.752-.544.977-.29.228-.68.413-1.116.558-.878.293-2.059.465-3.34.465-1.281 0-2.462-.172-3.34-.465-.436-.145-.826-.33-1.116-.558C3.26 14.752 3 14.426 3 14c0-.599.5-1 .961-1.243.505-.266 1.187-.467 1.957-.594a.5.5 0 0 1 .575.411z" />
                                        </svg>
                                        <span class="ml-2">Berjarak {{ $touristDestination->distance_from_city_center }} dari pusat kota</span>
                                    </p>
                                </li>
                            </ul>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('guest.tourist-destinations.show', ['tourist_destination' => $touristDestination]) }}"
                                class="inline-flex items-center px-5 py-2 text-sm font-medium bg-green-700 rounded-md hover:bg-green-800 focus:ring-1 focus:ring-green-300">
                                <span class="text-white">Lihat detail</span>
                            </a>
                        </div>
                        <a href="https://www.google.com/maps/search/?api=1&query={{ $touristDestination->latitude }}%2C{{ $touristDestination->longitude }}"
                            target="_blank"
                            class="text-white h-10 mt-3 bg-[#4285F4] hover:bg-[#4285F4]/90 focus:ring-1 focus:outline-none focus:ring-[#4285F4]/50 font-medium rounded-md text-sm px-2.5 py-2 text-center inline-flex items-center mr-2 mb-2">
                            <div class="p-1 bg-white rounded-full">
                                <img src="{{ asset('assets/icon/Google-Maps-Platform.svg') }}" class="w-5"
                                    alt="Google Maps Icon">
                            </div>
                            <span class="ml-2 text-white">Buka di Google Maps</span>
                        </a>
                    </div>`

                @if ($touristDestination->category && $touristDestination->category->svg_name)
                    className = '.tooltip-text-color-' + '{{ $key }}' + ' ' + '{ color: {{ $touristDestination->category->hex_code }}; }';
                    style = document.createElement('style');
                    style.appendChild(document.createTextNode(className));
                    document.head.appendChild(style);

                    icon = L.AwesomeMarkers.icon({
                                icon: '{{ $touristDestination->category->svg_name }}',
                                markerColor: '{{ $touristDestination->category->color }}'
                            });
                    marker = L.marker([{{ $touristDestination->latitude }}, {{ $touristDestination->longitude }}], {
                                icon: icon,
                            })
                            .addTo(markerLayer)
                            .bindPopup(popUp)
                            .bindTooltip('{{ $touristDestination->name }}', {
                                offset: [19, -23],
                                permanent: true,
                                direction: 'right',
                                className: 'bg-transparent z-10 w-32 whitespace-pre-wrap text-shadow-white border-0 shadow-none font-semibold' + ' ' + 'tooltip-text-color-' + '{{ $key }}'
                            });
                @else
                    marker = L.marker([{{ $touristDestination->latitude }}, {{ $touristDestination->longitude }}])
                            .addTo(markerLayer)
                            .bindPopup(popUp)
                            .bindTooltip('{{ $touristDestination->name }}', {
                                offset: [0, 2],
                                permanent: true,
                                direction: 'right',
                                className: 'bg-transparent z-10 w-32 whitespace-pre-wrap text-shadow-white border-0 shadow-none text-[#277fc9] font-semibold'
                            });
                @endif

                marker.on('click', function(e) {
                    this.openPopup();
                });
            @endforeach
        </script>
    @endsection
</x-guest-layout>
