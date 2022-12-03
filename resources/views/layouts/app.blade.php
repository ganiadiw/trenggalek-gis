<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Leaflet -->
        <link rel="stylesheet" href="{{ asset('assets/css/leaflet.css') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="{{ asset('assets/js/leaflet/leaflet.js') }}"></script>
        <script src="{{ asset('assets/js/alpine.js') }}"></script>
    </head>
    <body class="font-sans antialiased">
        <div x-data="openSidebar" class="flex min-h-screen">
            <div class="bg-white w-96">
                @include('layouts.sidebar')
            </div>
            <div class="w-full bg-gray-100">
                @include('layouts.navigation')
                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
