<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @if(Auth::check() && Auth::user()->is_admin && Route::currentRouteName() !== 'dashboard')
            <aside class="fixed inset-y-0 left-0 w-64 bg-sky-700 dark:bg-sky-800 shadow-lg z-40">
                <div class="h-full flex flex-col">
                    <div class="p-4 border-b border-blue-500 dark:border-blue-700">
                        <h2 class="text-xl font-semibold text-white">Admin Panel</h2>
                    </div>
                    <nav class="mt-4 flex-1 px-2">
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('admin.upload.show') }}" class="text-white hover:text-blue-200 hover:bg-blue-700 dark:hover:bg-blue-900 px-4 py-2 rounded-md flex items-center transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2h6a1 1 0 011 1v8a1 1 0 01-1 1H7a1 1 0 01-1-1V5a1 1 0 011-1zm6 8V5H7v7h6z" clip-rule="evenodd" />
                                    </svg>
                                    Upload Files
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.categories') }}" class="text-white hover:text-blue-200 hover:bg-blue-700 dark:hover:bg-blue-900 px-4 py-2 rounded-md flex items-center transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm2 1h8v4H5V6zm0 6h8v2H5v-2z" clip-rule="evenodd" />
                                    </svg>
                                    Manage Categories
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.users') }}" class="text-white hover:text-blue-200 hover:bg-blue-700 dark:hover:bg-blue-900 px-4 py-2 rounded-md flex items-center transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                    Users List
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <!-- Toggle Button for Mobile -->
                <button @click="open = !open" class="md:hidden absolute top-4 right-4 text-white p-2 rounded-full hover:bg-blue-700 dark:hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </aside>
            @endif
            <!-- Main Content -->
            <div class="flex-1 transition-all duration-300">
                @include('layouts.navigation')

                @isset($header)
                    <header class="bg-white dark:bg-gray-800 shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <main class="p-6 {{ Auth::check() && Auth::user()->is_admin && Route::currentRouteName() !== 'dashboard' ? 'ml-64' : '' }}">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
