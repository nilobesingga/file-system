<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SkyHybrid</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/SkyHybrid.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased" style="background-image: url('{{ asset('images/bg.png') }}'); background-size: cover; background-position: center;">

    <!-- Alpine.js Global State for Theme Color -->
    <div x-data="{
            themeColor: localStorage.getItem('themeColor') || 'bg-gray-800',
            sidebarOpen: localStorage.getItem('sidebarOpen') === 'true' || false,
            setTheme(color) {
                this.themeColor = color;
                localStorage.setItem('themeColor', color);
            },
            toggleSidebar() {
                this.sidebarOpen = !this.sidebarOpen;
                localStorage.setItem('sidebarOpen', this.sidebarOpen);
            }
        }"
        x-init="themeColor = localStorage.getItem('themeColor') || 'bg-gray-700'"
        class="flex flex-col min-h-screen">

        @if(Auth::check() && Auth::user()->is_admin)
            <!-- Sidebar -->
            <div class="fixed inset-y-0 left-0 z-40 w-64 text-white transition-all duration-300 transform shadow-xl rounded-r-3xl"
                 :class="[themeColor, !sidebarOpen ? '-translate-x-full' : '']">

                <div class="flex flex-col h-full">
                    <!-- Sidebar Header -->
                    <div class="flex items-center justify-center p-4 space-x-3 bg-white border-b-4 border-yellow-900 dark:bg-white dark:border-yellow-700">
                        <h2 class="text-xl font-semibold">
                            <img src="{{ asset('images/SkyHybrid.png') }}" class="w-auto h-8">
                        </h2>
                    </div>

                    <!-- Sidebar Navigation -->
                    <nav class="flex-1 px-4 mt-4 space-y-2">
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('admin.dashboard') }}"
                                   class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M9 21V9h6v12" />
                                    </svg>
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.upload.show') }}"
                                   class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('admin.upload.show') ? 'bg-gray-700' : '' }}">
                                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m-7-7h14" />
                                    </svg>
                                    Upload Files
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.categories') }}"
                                   class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('admin.categories') ? 'bg-gray-700' : '' }}">
                                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7" />
                                    </svg>
                                    Manage Categories
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.users') }}"
                                   class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('admin.users') ? 'bg-gray-700' : '' }}">
                                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                                    </svg>
                                    Users List
                                </a>
                            </li>
                        </ul>
                    </nav>

                    <!-- Color Picker (Now Syncs Sidebar & Navbar) -->
                    <div class="p-4 border-t border-opacity-30">
                        <div class="flex space-x-2">
                            <!-- Color Options -->
                            <template x-for="color in [
                                { name: 'White', class: 'bg-gray-700' },
                                { name: 'Blue', class: 'bg-blue-700' },
                                { name: 'Purple', class: 'bg-purple-700' },
                                { name: 'Green', class: 'bg-green-700' },
                                { name: 'Red', class: 'bg-red-700' },
                                { name: 'Dark Mode', class: 'bg-gray-800' }
                            ]">
                                <button @click="setTheme(color.class)"
                                        :class="color.class"
                                        class="w-8 h-8 transition border-2 border-transparent rounded-full hover:border-white">
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Content -->
        <div class="flex flex-col flex-1">
            <!-- Navigation Bar -->
            @if(Auth::check() && Auth::user()->is_admin)
                <nav class="transition-all duration-300 bg-white border-b-4 border-yellow-900 dark:bg-white dark:text-dark dark:border-yellow-700"
                    :class="themeColor">
                    <div class="{{ Auth::check() && Auth::user()->is_admin ? 'w-full' : 'max-w-7xl' }} px-2 mx-auto sm:px-6 lg:px-8">
                        <div class="flex justify-between h-16">
                            <div class="flex items-center">
                                <!-- Hamburger Toggle Button -->
                                <button @click="toggleSidebar"
                                        :class="sidebarOpen ? 'ml-60' : 'ml-0'"
                                        class="p-2 mr-2 text-red-500 rounded-md hover:text-gray-600 focus:outline-none">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M4 6h16M4 12h16m-7 6h7"/>
                                    </svg>
                                </button>

                                <div class="flex items-center shrink-0">
                                    <a href="{{ route('dashboard') }}" class="flex items-center">
                                        <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'Laravel') }}" class="w-auto h-8">
                                    </a>
                                </div>
                            </div>

                            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                                <div class="relative ml-3">
                                    <x-dropdown align="right" width="48">
                                        <x-slot name="trigger">
                                            <button class="flex items-center text-sm font-medium text-dark hover:text-gray-700">
                                                <!-- Profile Image or Default Avatar -->
                                                <img class="w-8 h-8 mr-2 rounded-full"
                                                    src="{{ asset('images/SkyHybrid.png') }}"/>
                                                {{ Auth::user()->name }}
                                            </button>
                                        </x-slot>
                                        <x-slot name="content">
                                            <x-dropdown-link :href="route('profile.edit')">
                                                {{ __('Profile') }}
                                            </x-dropdown-link>
                                            <x-dropdown-link href="#"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </x-dropdown-link>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                                @csrf
                                            </form>
                                        </x-slot>
                                    </x-dropdown>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            @else
                @include('layouts.navigation')
            @endif

            @isset($header)
                <header class="transition-all duration-300 bg-black shadow dark:bg-gray-800" :class="themeColor">
                    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="flex-1 p-6 py-4 transition-all duration-300"
                  :class="sidebarOpen ? 'ml-64' : ''">
                {{ $slot }}
            </main>
            @include('layouts.footer')
        </div>
    </div>
</body>
</html>
