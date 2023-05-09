<section>
    <div class="px-6 py-2 bg-gray-100 rounded-md h-fit">
        <ul class="space-y-5">
            <li>
                <label class="font-semibold text-gray-900">Alamat Destinasi
                    Wisata</label>
                <p id="address" class="flex items-center mt-2 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="w-5 text-red-700"
                        fill="currentColor" class="mr-2 bi bi-geo-alt-fill" viewBox="0 0 16 16">
                        <path
                            d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                    </svg>
                    <span class="ml-2">{{ $touristDestination->address }}</span>
                </p>
            </li>
            <li>
                <h2 class="font-semibold text-gray-900">Wilayah Kecamatan</h2>
                <p id="address" class="flex items-center mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 icon icon-tabler icon-tabler-map" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="1" stroke="#16a34a" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <polyline points="3 7 9 4 15 7 21 4 21 17 15 20 9 17 3 20 3 7"></polyline>
                        <line x1="9" y1="4" x2="9" y2="17"></line>
                        <line x1="15" y1="7" x2="15" y2="20"></line>
                    </svg>
                    <span class="ml-2">{{ $touristDestination->subDistrict->name }}</span>
                </p>
            </li>
            <li>
                <label class="font-semibold text-gray-900">Kategori Destinasi
                    Wisata</label>
                <p id="category" class="flex items-center mt-2 text-sm">
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
                <label class="font-semibold text-gray-900">Jarak dari Pusat Kota</label>
                <p id="distance" class="flex items-center mt-2 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="w-5 text-green-700"
                        fill="currentColor" class="bi bi-geo-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M4 4a4 4 0 1 1 4.5 3.969V13.5a.5.5 0 0 1-1 0V7.97A4 4 0 0 1 4 3.999zm2.493 8.574a.5.5 0 0 1-.411.575c-.712.118-1.28.295-1.655.493a1.319 1.319 0 0 0-.37.265.301.301 0 0 0-.057.09V14l.002.008a.147.147 0 0 0 .016.033.617.617 0 0 0 .145.15c.165.13.435.27.813.395.751.25 1.82.414 3.024.414s2.273-.163 3.024-.414c.378-.126.648-.265.813-.395a.619.619 0 0 0 .146-.15.148.148 0 0 0 .015-.033L12 14v-.004a.301.301 0 0 0-.057-.09 1.318 1.318 0 0 0-.37-.264c-.376-.198-.943-.375-1.655-.493a.5.5 0 1 1 .164-.986c.77.127 1.452.328 1.957.594C12.5 13 13 13.4 13 14c0 .426-.26.752-.544.977-.29.228-.68.413-1.116.558-.878.293-2.059.465-3.34.465-1.281 0-2.462-.172-3.34-.465-.436-.145-.826-.33-1.116-.558C3.26 14.752 3 14.426 3 14c0-.599.5-1 .961-1.243.505-.266 1.187-.467 1.957-.594a.5.5 0 0 1 .575.411z" />
                    </svg>
                    <span class="ml-2">{{ $touristDestination->distance_from_city_center }}</span>
                </p>
            </li>
            <li>
                <label class="font-semibold text-gray-900">Pengelola</label>
                <p id="manager" class="flex items-center mt-2 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="w-5 text-stone-700"
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
                    <h2 class="font-semibold text-gray-900">Peta Destinasi Wisata</h2>
                    <div id="sideMap" class="mt-2 border-2 border-gray-300 rounded-md h-80"></div>
                    <a type="button"
                        href="https://www.google.com/maps/search/?api=1&query={{ $touristDestination->latitude }}%2C{{ $touristDestination->longitude }}"
                        target="_blank"
                        class="text-white h-10 mt-3 bg-[#4285F4] hover:bg-[#4285F4]/90 focus:ring-1 focus:outline-none focus:ring-[#4285F4]/50 font-medium rounded-lg text-sm px-2.5 py-2.5 text-center inline-flex items-center mr-2 mb-2">
                        <div class="p-1 bg-white rounded-full">
                            <img src="{{ asset('assets/icon/Google-Maps-Platform.svg') }}" class="w-5"
                                alt="Google Maps Icon">
                        </div>
                        <span class="ml-2">Buka di Google Maps</span>
                    </a>
                </div>
            </li>
            @if (
                $touristDestination->facebook_url ||
                    $touristDestination->instagram_url ||
                    $touristDestination->twitter_url ||
                    $touristDestination->youtube_url)
                <li>
                    <label class="font-semibold text-gray-900" for="socialMedia">Media Sosial Destinasi
                        Wisata</label>
                    <ul id="socialMedia" class="mt-3 space-y-2">
                        @if ($touristDestination->facebook_url)
                            <li class="p-1 text-facebook-brand">
                                <a href="{{ $touristDestination->facebook_url }}" class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" width="16"
                                        height="16" fill="currentColor" class="bi bi-facebook"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                                    </svg>
                                    <span class="ml-2 font-medium">
                                        {{ $touristDestination->name }}</span>
                                </a>
                            </li>
                        @endif
                        @if ($touristDestination->instagram_url)
                            <li class="p-1 text-instragram-brand">
                                <a href="{{ $touristDestination->instagram_url }}" class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" width="16"
                                        height="16" fill="currentColor" class="bi bi-instagram"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z" />
                                    </svg>
                                    <span class="ml-2">
                                        {{ $touristDestination->name }}</span>
                                </a>
                            </li>
                        @endif
                        @if ($touristDestination->twitter_url)
                            <li class="p-1 text-twitter-brand">
                                <a href="{{ $touristDestination->twitter_url }}" class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" width="16"
                                        height="16" fill="currentColor" class="bi bi-twitter"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z" />
                                    </svg>
                                    <span class="ml-2">
                                        {{ $touristDestination->name }}</span>
                                </a>
                            </li>
                        @endif
                        @if ($touristDestination->youtube_url)
                            <li class="p-1 text-youtube-brand">
                                <a href="{{ $touristDestination->youtube_url }}" class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" width="16"
                                        height="16" fill="currentColor" class="bi bi-youtube"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.007 2.007 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.007 2.007 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31.4 31.4 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.007 2.007 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A99.788 99.788 0 0 1 7.858 2h.193zM6.4 5.209v4.818l4.157-2.408L6.4 5.209z" />
                                    </svg>
                                    <span class="ml-2">
                                        {{ $touristDestination->name }}</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
        </ul>
    </div>

    @section('script2')
        <script>
            let marker;
            let sideMap = L.map('sideMap').setView([{{ $touristDestination->latitude }},
                {{ $touristDestination->longitude }}
            ], 13);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                minZoom: 10,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(sideMap);

            new L.GeoJSON.AJAX(['{{ asset('storage/geojson/' . $touristDestination->subDistrict->geojson_name) }}'], {
                style: {
                    'color': '{{ $touristDestination->subDistrict->fill_color }}',
                    'weight': 2,
                    'opacity': 0.4,
                }
            }).addTo(sideMap);

            @if ($touristDestination->category && $touristDestination->category->icon_name)
                icon = L.icon({
                    iconUrl: '{{ asset('storage/categories/icon/' . $touristDestination->category->icon_name) }}',
                    iconSize: [45, 45],
                    iconAnchor: [23.5, 47],
                    popupAnchor: [0, 0],
                });

                marker = L.marker([{{ $touristDestination->latitude }}, {{ $touristDestination->longitude }}], {
                    icon: icon
                }).addTo(sideMap);
            @else
                marker = L.marker([{{ $touristDestination->latitude }}, {{ $touristDestination->longitude }}]).addTo(sideMap)
            @endif
        </script>
    @endsection
</section>
