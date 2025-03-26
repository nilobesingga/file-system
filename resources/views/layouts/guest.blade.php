<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>CapLionPoint</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Custom Styles -->
        <style>
            .card {
                /* background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); */
                border-radius: 15px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                position: relative;
                overflow: hidden;
                transition: border 0.3s ease-in-out;
                color: #000;
            }

            .card:hover {
                border: 2px solid #3b82f6;
                animation: borderAnimation 1s linear infinite;
            }

            @keyframes borderAnimation {
                0% {
                    border-color: #1e3a8a;
                }
                50% {
                    border-color: #3b82f6;
                }
                100% {
                    border-color: #1e3a8a;
                }
            }
        </style>
    </head>
    <body class="font-sans antialiased" style="background-image: url('{{ asset('images/bg.png') }}'); background-size: cover; background-position: center;">
        <div class="flex flex-col items-center min-h-screen pt-6 sm:justify-center sm:pt-0 ">
            <div>
                <a href="/">
                    {{-- <x-application-logo class="w-20 h-20 text-gray-500" /> --}}
                    <img src="{{ asset('images/CLP-White.svg') }}" alt="{{ config('app.name', 'CapLionPoint') }}" class="w-auto h-20">

                </a>
            </div>

            <div class="w-full px-6 py-6 mt-6 overflow-hidden bg-white border border-gray-300 shadow-lg sm:max-w-md dark:bg-gray-800 sm:rounded-lg card">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
