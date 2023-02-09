<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('assets/icon/Paomedia-Small-N-Flat-Map.svg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"rel="stylesheet" />

    <!-- Pickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/nano.min.css" />

    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

    <link rel="stylesheet" href="{{ asset('assets/css/leaflet.css') }}">

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('assets/js/jquery-3.6.1.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}"></script> --}}
    <script src="https://cdn.tiny.cloud/1/3e5fngs61v628hiv11876o7vhcv1akokhq9ybh6fihse10me/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
</head>

<body class="font-sans antialiased">
    <div class="loader">
        <div></div>
    </div>
    <div class="flex min-h-screen content">
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

    <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>
    <script src="https://unpkg.com/flowbite@1.5.5/dist/flowbite.js"></script>
    <script src="{{ asset('assets/js/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('assets/js/leaflet/leaflet.ajax.js') }}"></script>
    <script src="{{ asset('assets/js/general-function.js') }}"></script>
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
