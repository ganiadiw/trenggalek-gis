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
                width: 600px;
                height: 300px;
                object-fit: cover;
            }
        </style>
    @endsection

    <div>
        <div class="md:h-[22rem] h-fit bg-slate-950 relative">
            <div class="pt-20 md:pb-20 px-7 md:px-14 lg:px-28">
                <div class="relative">
                    <div class="max-w-2xl">
                        <h1 class="text-3xl font-bold text-gray-100">{{ $welcomeMessage->value[0] }}</h1>
                        <p class="mt-5 text-gray-200">{{ $shortDescription->value[0] }}</p>
                    </div>
                </div>
                <div class="max-w-[600px] max-h-[300px] absolute 2xl:-bottom-10 2xl:right-32 hidden 2xl:block">
                    @if ($heroImagesCount > 0)
                        <div class="wiper mySwiper">
                            <div class="rounded-lg swiper-wrapper">
                                @foreach ($heroImages->value as $key => $heroImage)
                                    @if ($heroImage && Storage::exists('public/page-settings/hero_image/' . $heroImage))
                                        <div class="swiper-slide">
                                            <img class="h-10 rounded-lg"
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
        <div class="px-7 md:px-14 lg:px-28">
            <div class="mt-14">
                <div class="mb-10 lg:space-x-5 lg:flex">
                    <div class="w-full lg:w-[70%]">
                        <h2 class="mb-5 text-2xl font-bold ">Peta Destinasi Wisata</h2>
                        <x-head.leaflet-init class="w-full rounded-lg h-128" />
                    </div>
                    <div class="lg:w-[30%] w-full mt-[50px]">
                        <div
                            class="w-full p-4 overflow-scroll bg-white border border-gray-200 rounded-lg shadow sm:p-6 lg:h-128">
                            <h5 class="mb-3 text-base font-bold text-gray-900">
                                Tahukah kamu, apa saja dan berapa jumlah destinasi wisata yang terdapat di Kabupaten
                                Trenggalek?
                            </h5>
                            <ul class="grid w-full gap-3 md:grid-cols-2 lg:grid-cols-1">
                                @foreach ($categories as $category)
                                    @if ($category->tourist_destinations_count > 0)
                                        <li>
                                            <div
                                                class="flex items-center max-w-sm p-3 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                                                <div class="flex items-center justify-center w-10 h-10 mr-5 text-lg font-semibold text-gray-900 bg-gray-300 rounded-full">{{ $category->tourist_destinations_count }}</div>
                                                <div class="text-lg font-semibold tracking-tight text-gray-900">
                                                    {{ $category->name }}
                                                </div>
                                            </div>

                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-3 bg-gray-600">
            <div class="py-10 px-7 md:px-14 lg:px-28">
                <h2 class="mb-5 text-xl font-bold text-gray-100">Sekilas Tentang Sistem Informasi Ini</h2>
                <div class="text-gray-100">
                    <p>{!! $aboutPage->value[0] !!}</p>
                    <a href=""></a>
                </div>
            </div>
        </div>
    </div>

    @section('script')
        <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
        <script>
            let swiper = new Swiper(".mySwiper", {
                cssMode: true,
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
