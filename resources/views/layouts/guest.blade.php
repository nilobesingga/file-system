<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Sky Hybrid</title>
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/SkyHybrid-favicon.png') }}">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Custom Styles -->
        <style>
            .card {
                /* background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); */
                border-radius: 16px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                position: relative;
                overflow: hidden;
                color: #000;
            }
        </style>
    </head>
    <body class="font-sans antialiased" style="background-image: url('{{ asset('images/bg.png') }}'); background-size: cover; background-position: center;">
        <div class="flex flex-col items-center min-h-screen pt-6 sm:justify-center sm:pt-0 ">
            <div class="w-full px-8 py-7 mt-7 overflow-hidden bg-white border border-gray-300 shadow-lg sm:max-w-md sm:rounded-lg card">
                <div class="flex justify-center my-5">
                    <a href="/">
                        <img src="{{ asset('images/SkyHybrid.png') }}" alt="{{ config('app.name', 'SkyHybrid') }}" class="w-auto h-14">
                    </a>
                </div>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
