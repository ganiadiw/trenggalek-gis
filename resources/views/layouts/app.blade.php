<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" href="{{ asset('assets/icon/Paomedia-Small-N-Flat-Map.svg') }}">

        <!-- Fonts -->
        {{-- <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap"> --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        {{-- <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet"> --}}
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"rel="stylesheet"/>

        <!-- Leaflet -->
        <link rel="stylesheet" href="{{ asset('assets/css/leaflet.css') }}">
        <style>
            [x-cloak] {
              display: none !important;
           }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="{{ asset('assets/js/leaflet/leaflet.js') }}"></script>
        <script src="{{ asset('assets/js/alpine.js') }}"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="flex min-h-screen">
            <div class="hidden bg-white w-85 xl:block">
                @include('layouts.sidebar')
            </div>
            <div class="w-full bg-gray-100">
                @include('layouts.navigation')
                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>

        <script src="{{ asset('assets/js/jquery-3.6.1.min.js') }}"></script>
        <script src="{{ asset('assets/js/leaflet/leaflet.ajax.js') }}"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
        @yield('script')
    </body>
</html>
