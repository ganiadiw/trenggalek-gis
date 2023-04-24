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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/leaflet.css') }}">
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    @yield('css')

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="{{ asset('assets/js/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('assets/js/leaflet/leaflet.ajax.js') }}"></script>
</head>

<body>
    <div class="font-sans antialiased text-gray-900">
        @if (!request()->routeIs('login'))
            @include('layouts.guest-navigation')
        @endif
        {{ $slot }}
        <footer class="flex items-center justify-between w-full h-20 mx-auto bg-gray-100 px-14">
            <div><span class="text-sm text-gray-600">© 2023 <a href="http://pariwisata.trenggalekkab.go.id/"
                        class="hover:underline">Disparbud Kabupaten Trenggalek</a>. All Rights Reserved.</span></div>
            <div>
                <ul class="flex space-x-4">
                    <li class="p-1 duration-200 hover:-translate-y-2">
                        <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-facebook"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3">
                                </path>
                            </svg>
                        </a>
                    </li>
                    <li class="p-1 duration-200 hover:-translate-y-2">
                        <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-instagram"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M4 4m0 4a4 4 0 0 1 4 -4h8a4 4 0 0 1 4 4v8a4 4 0 0 1 -4 4h-8a4 4 0 0 1 -4 -4z">
                                </path>
                                <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                <path d="M16.5 7.5l0 .01"></path>
                            </svg>
                        </a>
                    </li>
                    <li class="p-1 duration-200 hover:-translate-y-2">
                        <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-twitter"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path
                                    d="M22 4.01c-1 .49 -1.98 .689 -3 .99c-1.121 -1.265 -2.783 -1.335 -4.38 -.737s-2.643 2.06 -2.62 3.737v1c-3.245 .083 -6.135 -1.395 -8 -4c0 0 -4.182 7.433 4 11c-1.872 1.247 -3.739 2.088 -6 2c3.308 1.803 6.913 2.423 10.034 1.517c3.58 -1.04 6.522 -3.723 7.651 -7.742a13.84 13.84 0 0 0 .497 -3.753c0 -.249 1.51 -2.772 1.818 -4.013z">
                                </path>
                            </svg>
                        </a>
                    </li>
                    <li class="p-1 transition duration-200 hover:-translate-y-2">
                        <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-youtube"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path
                                    d="M3 5m0 4a4 4 0 0 1 4 -4h10a4 4 0 0 1 4 4v6a4 4 0 0 1 -4 4h-10a4 4 0 0 1 -4 -4z">
                                </path>
                                <path d="M10 9l5 3l-5 3z"></path>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </footer>
    </div>
    @yield('component-script')
    @yield('script')
</body>

</html>
