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
                background: #fff;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .swiper-slide img {
                display: block;
                width: 500px;
                height: 200px;
                object-fit: cover;
                border-radius: 5px;
            }
        </style>
    @endsection

    <div class="py-4">
        <div class="px-4 mx-auto mt-4 text-gray-600 sm:px-6 lg:px-8">
            <div>
                <h1 class="text-3xl font-medium text-gray-700">{{ $touristDestination->name }}</h1>
            </div>
            <div class="grid grid-cols-8 mt-5 mb-20 gap-x-4">
                <div class="col-span-6">
                    <div class="max-w-[69rem] max-h-[40rem]">
                        <img class="rounded-md"
                            src="{{ asset('storage/cover-images/' . $touristDestination->cover_image_name) }}"
                            alt="{{ $touristDestination->cover_image_name }}">
                    </div>
                    <div class="mt-6 text-base leading-7">
                        <p>{!! $touristDestination->description !!}</p>
                    </div>
                    <div class="mt-5 text-xl">
                        <h2 class="mb-4">Fasilitas</h2>
                        <div class="grid grid-cols-4">
                            @foreach ($touristDestination->facility as $facility)
                                <div class="flex items-center text-base">
                                    <svg class="w-4 h-4 mr-1.5 text-green-500 flex-shrink-0" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $facility }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @if (count($touristDestination->touristAttractions) != 0)
                        <div class="mt-5 text-xl">
                            <h2 class="mb-4">Attraksi Wisata</h2>
                            <div class="swiper mySwiper">
                                <div class="swiper-wrapper">
                                    @foreach ($touristDestination->touristAttractions as $key => $value)
                                        <div class="swiper-slide">
                                            <div class="relative">
                                                <img class="bg-gray-100"
                                                    src="{{ asset('storage/tourist-attractions/' . $value->image_name) }}"
                                                    alt="{{ $value->image_name }}">
                                                <p
                                                    class="absolute flex items-center w-full h-20 px-2 mt-2 text-xl pt-8 font-semibold text-white bottom-[28px] rounded-b-md bg-gradient-to-t from-gray-900">
                                                    {{ $value->name }}</p>
                                                <p class="flex items-start mx-2 mt-2 text-sm">{{ $value->caption }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-span-2 px-4 py-2 bg-gray-100 rounded-md h-fit">
                    <ul class="space-y-5">
                        <li>
                            <label class="font-semibold text-gray-900" for="address">Alamat Destinasi Wisata</label>
                            <p id="address" class="flex items-center mt-2 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="w-5"
                                    fill="currentColor" class="mr-2 bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                                </svg>
                                <span class="ml-2">{{ $touristDestination->address }}</span>
                            </p>
                        </li>
                        <li>
                            <label class="font-semibold text-gray-900" for="category">Kategori Destinasi Wisata</label>
                            <p id="category" class="flex items-center mt-2 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 icon icon-tabler icon-tabler-category" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M4 4h6v6h-6z"></path>
                                    <path d="M14 4h6v6h-6z"></path>
                                    <path d="M4 14h6v6h-6z"></path>
                                    <path d="M17 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                </svg>
                                <span class="ml-2">{{ $touristDestination->category->name }}</span>
                            </p>
                        </li>
                        <li>
                            <label class="font-semibold text-gray-900" for="distance">Jarak dari Pusat Kota</label>
                            <p id="distance" class="flex items-center mt-2 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="w-5"
                                    fill="currentColor" class="bi bi-geo-fill" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M4 4a4 4 0 1 1 4.5 3.969V13.5a.5.5 0 0 1-1 0V7.97A4 4 0 0 1 4 3.999zm2.493 8.574a.5.5 0 0 1-.411.575c-.712.118-1.28.295-1.655.493a1.319 1.319 0 0 0-.37.265.301.301 0 0 0-.057.09V14l.002.008a.147.147 0 0 0 .016.033.617.617 0 0 0 .145.15c.165.13.435.27.813.395.751.25 1.82.414 3.024.414s2.273-.163 3.024-.414c.378-.126.648-.265.813-.395a.619.619 0 0 0 .146-.15.148.148 0 0 0 .015-.033L12 14v-.004a.301.301 0 0 0-.057-.09 1.318 1.318 0 0 0-.37-.264c-.376-.198-.943-.375-1.655-.493a.5.5 0 1 1 .164-.986c.77.127 1.452.328 1.957.594C12.5 13 13 13.4 13 14c0 .426-.26.752-.544.977-.29.228-.68.413-1.116.558-.878.293-2.059.465-3.34.465-1.281 0-2.462-.172-3.34-.465-.436-.145-.826-.33-1.116-.558C3.26 14.752 3 14.426 3 14c0-.599.5-1 .961-1.243.505-.266 1.187-.467 1.957-.594a.5.5 0 0 1 .575.411z" />
                                </svg>
                                <span class="ml-2">{{ $touristDestination->distance_from_city_center }}</span>
                            </p>
                        </li>
                        <li>
                            <label class="font-semibold text-gray-900" for="manager">Pengelola</label>
                            <p id="manager" class="flex items-center mt-2 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="w-5"
                                    fill="currentColor" class="bi bi-building" viewBox="0 0 16 16">
                                    <path
                                        d="M4 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1ZM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Z" />
                                    <path
                                        d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V1Zm11 0H3v14h3v-2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V15h3V1Z" />
                                </svg>
                                <span class="ml-2">{{ $touristDestination->manager }}</span>
                            </p>
                        </li>
                        <li>
                            <div class="mt-5 lg:mt-0">
                                <x-head.leaflet-init class="h-80" :latitude="$touristDestination->latitude" :longitude="$touristDestination->longitude"
                                    :zoomLevel=13 />
                                <a type="button"
                                    href="https://www.google.com/maps/search/?api=1&query={{ $touristDestination->latitude }}%2C{{ $touristDestination->longitude }}"
                                    target="_blank"
                                    class="text-white mt-3 bg-[#4285F4] hover:bg-[#4285F4]/90 focus:ring-1 focus:outline-none focus:ring-[#4285F4]/50 font-medium rounded-lg text-sm px-2.5 py-2.5 text-center inline-flex items-center mr-2 mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        class="w-5" fill="currentColor" class="mr-2 bi bi-geo-alt-fill"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                                    </svg>
                                    <span class="ml-2">Buka di Google Maps</span>
                                </a>
                            </div>
                        </li>
                        @if ($touristDestination->facebook_url || $touristDestination->instagram_url || $touristDestination->twitter_url ||$touristDestination->youtube_url)
                        <li>
                            <label class="font-semibold text-gray-900" for="socialMedia">Media Sosial Destinasi
                                Wisata</label>
                                <ul id="socialMedia" class="mt-3 space-y-2">
                                    @if ($touristDestination->facebook_url)
                                        <li class="p-1 duration-200 hover:translate-x-2 hover:text-blue-500">
                                            <a href="{{ $touristDestination->facebook_url }}" class="flex">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-brand-facebook" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path
                                                        d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3">
                                                    </path>
                                                </svg>
                                                <span class="ml-2">Facebook {{ $touristDestination->name }}</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if ($touristDestination->instagram_url)
                                        <li class="p-1 duration-200 hover:translate-x-2 hover:text-blue-500">
                                            <a href="{{ $touristDestination->instagram_url }}" class="flex">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-brand-instagram" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path
                                                        d="M4 4m0 4a4 4 0 0 1 4 -4h8a4 4 0 0 1 4 4v8a4 4 0 0 1 -4 4h-8a4 4 0 0 1 -4 -4z">
                                                    </path>
                                                    <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                                    <path d="M16.5 7.5l0 .01"></path>
                                                </svg>
                                                <span class="ml-2">Twitter {{ $touristDestination->name }}</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if ($touristDestination->twitter_url)
                                        <li class="p-1 duration-200 hover:translate-x-2 hover:text-blue-500">
                                            <a href="{{ $touristDestination->twitter_url }}" class="flex">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-brand-twitter" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path
                                                        d="M22 4.01c-1 .49 -1.98 .689 -3 .99c-1.121 -1.265 -2.783 -1.335 -4.38 -.737s-2.643 2.06 -2.62 3.737v1c-3.245 .083 -6.135 -1.395 -8 -4c0 0 -4.182 7.433 4 11c-1.872 1.247 -3.739 2.088 -6 2c3.308 1.803 6.913 2.423 10.034 1.517c3.58 -1.04 6.522 -3.723 7.651 -7.742a13.84 13.84 0 0 0 .497 -3.753c0 -.249 1.51 -2.772 1.818 -4.013z">
                                                    </path>
                                                </svg>
                                                <span class="ml-2">Twitter {{ $touristDestination->name }}</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if ($touristDestination->youtube_url)
                                        <li class="p-1 duration-200 hover:translate-x-2 hover:text-blue-500">
                                            <a href="{{ $touristDestination->youtube_url }}" class="flex">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-brand-youtube" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path
                                                        d="M3 5m0 4a4 4 0 0 1 4 -4h10a4 4 0 0 1 4 4v6a4 4 0 0 1 -4 4h-10a4 4 0 0 1 -4 -4z">
                                                    </path>
                                                    <path d="M10 9l5 3l-5 3z"></path>
                                                </svg>
                                                <span class="ml-2">Youtube {{ $touristDestination->name }}</span>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @section('script')
        <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
        <script>
            marker = L.marker([{{ $touristDestination->latitude }}, {{ $touristDestination->longitude }}]).addTo(map);

            let swiper = new Swiper(".mySwiper", {
                slidesPerView: 3,
                spaceBetween: 30,
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
        </script>
    @endsection

</x-guest-layout>
