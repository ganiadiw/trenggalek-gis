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
        </style>
    @endsection

    <div class="relative h-fit bg-slate-950">
        <div class="pt-14 md:pt-20 pb-14 md:pb-20 px-7 md:px-14 lg:px-28">
            {{-- Mobile Swipper --}}
            <div class="h-[200px] md:h-[350px] w-full mb-10 xl:hidden">
                @if ($heroImagesCount > 0)
                    <div class="swiper mySwiper2">
                        <div class="rounded-lg swiper-wrapper">
                            @foreach ($heroImages->value as $key => $heroImage)
                                @if ($heroImage && Storage::exists('public/page-settings/hero_image/' . $heroImage))
                                    <div class="swiper-slide">
                                        <img class="rounded-lg"
                                            src="{{ asset('storage/page-settings/hero_image/' . $heroImage) }}"
                                            alt="{{ $heroImage }}">
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            <div class="xl:max-w-xl">
                <h1 class="text-4xl font-bold leading-[3rem] text-gray-100">{{ $welcomeMessage->value[0] }}</h1>
                <p class="pr-10 mt-5 text-gray-200 right">{{ $shortDescription->value[0] }}</p>
            </div>
            {{-- XL Swipper --}}
            <div class="2xl:w-[600px] xl:h-[300px] xl:w-[520px] absolute xl:-bottom-14 xl:right-24 hidden xl:block">
                @if ($heroImagesCount > 0)
                    <div class="swiper mySwiper1">
                        <div class="rounded-lg swiper-wrapper">
                            @foreach ($heroImages->value as $key => $heroImage)
                                @if ($heroImage && Storage::exists('public/page-settings/hero_image/' . $heroImage))
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
                @endif
            </div>
        </div>
    </div>
    <div class="px-7 md:px-14 lg:px-28 mt-14">
        <div class="w-full">
            <h2 class="mb-5 text-2xl font-bold ">Peta Destinasi Wisata</h2>
            <x-head.leaflet-init class="w-full border-2 border-gray-300 rounded-lg shadow-xl h-128" />
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
            <div
                class="grid content-center grid-cols-2 gap-3 md:pt-[300px] xl:pt-[156px] md:h-[300px] px-5 md:overflow-y-auto md:w-3/5 sm:grid-cols-3 md:grid-cols-2 xl:grid-cols-3">
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
    <div class="py-10 bg-gray-600 px-7 md:px-14 lg:px-28">
        <h2 class="mb-5 text-xl font-bold text-gray-100">Sekilas Tentang Sistem Informasi Ini</h2>
        <div class="text-gray-100">
            <p>{!! $aboutPage->value[0] !!}</p>
            <a href=""></a>
        </div>
    </div>

    @section('script')
        <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
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

            @foreach ($subDistricts as $subDistrict)
                new L.GeoJSON.AJAX(['{{ asset('storage/geojson/' . $subDistrict->geojson_name) }}'], {
                    style: {
                        'color': '{{ $subDistrict->fill_color }}',
                        'weight': 2,
                        'opacity': 0.4,
                    }
                }).addTo(map);
            @endforeach

            let icon, marker;
            @foreach ($touristDestinations as $key => $touristDestination)
                @if ($touristDestination->category->icon_name)
                    icon = L.icon({
                        iconUrl: '{{ asset('storage/categories/icon/' . $touristDestination->category->icon_name) }}',
                        iconSize: [45, 45],
                        iconAnchor: [23.5, 47],
                        popupAnchor: [0, 0],
                    });
                    marker = L.marker([{{ $touristDestination->latitude }}, {{ $touristDestination->longitude }}], {
                            icon: icon
                        })
                        .addTo(map)
                        .bindPopup(
                            `<b>{{ $touristDestination->name }}</b>
                                        <br />
                                        Kategori: {{ $touristDestination->category->name }}
                                        <br />
                                        Alamat: {{ $touristDestination->address }}
                                        <br />
                                        Jarak dari pusat kota: {{ $touristDestination->distance_from_city_center }}
                                        <br />
                                        <a href="{{ route('dashboard.tourist-destinations.show', ['tourist_destination' => $touristDestination]) }}"><b>Lihat detail</b></a>
                                        <br />
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ $touristDestination->latitude }}%2C{{ $touristDestination->longitude }}"><b>Buka di Google Maps</b></a>`
                        );
                @else
                    marker = L.marker([{{ $touristDestination->latitude }}, {{ $touristDestination->longitude }}])
                        .addTo(map)
                        .bindPopup(
                            `<b>{{ $touristDestination->name }}</b>
                                        <br />
                                        Kategori: {{ $touristDestination->category->name }}
                                        <br />
                                        Alamat: {{ $touristDestination->address }}
                                        <br />
                                        Jarak dari pusat kota: {{ $touristDestination->distance_from_city_center }}
                                        <br />
                                        <a href="{{ route('dashboard.tourist-destinations.show', ['tourist_destination' => $touristDestination]) }}"><b>Lihat detail</b></a>
                                        <br />
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ $touristDestination->latitude }}%2C{{ $touristDestination->longitude }}"><b>Buka di Google Maps</b></a>`
                        );
                @endif
                marker.on('click', function(e) {
                    this.openPopup();
                });
            @endforeach
        </script>
    @endsection
</x-guest-layout>
