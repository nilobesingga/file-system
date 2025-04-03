<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sky Hybrid</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/SkyHybrid-favicon.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased" style="background-image: url('{{ asset('images/bg.png') }}'); background-attachment: fixed; background-size: cover; background-position: center;">

    <!-- Alpine.js Global State for Theme Color -->
    <div x-data="{
            themeColor: 'bg-gray-100',
            sidebarOpen: true,
            setTheme(color) {
                this.themeColor = color;
                localStorage.setItem('themeColor', color);
            },
            toggleSidebar() {
                this.sidebarOpen = !this.sidebarOpen;
                localStorage.setItem('sidebarOpen', this.sidebarOpen);
            }
        }"
        x-init="themeColor = 'bg-gray-100'"
        class="flex flex-col min-h-screen">

        @if(Auth::check() && Auth::user()->is_admin)
            <!-- Sidebar -->
            <div class="fixed inset-y-0 left-0 z-40 w-64 text-white bg-gray-200 transition-all duration-300 transform shadow-xl border-b-8 border-capLionGold">
                <div class="flex flex-col h-full">
                    <!-- Sidebar Header -->
                    <div class="flex items-center justify-start p-4 space-x-3 bg-white">
                        <h2 class="text-xl font-semibold">
                            <img src="{{ asset('images/SkyHybrid.png') }}" class="w-auto h-8 ml-4">
                        </h2>
                    </div>

                    <!-- Sidebar Navigation -->
                    <nav class="flex-1 px-4 mt-4 space-y-2">
                        <ul class="space-y-2 text-gray-700 font-medium">
                            <li>
                                <a href="{{ route('admin.dashboard') }}"
                                   class="flex items-center pl-5 pr-2 py-4 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-tl from-customBlue to-customBlue/60 text-white' : 'hover:bg-customBlue/10' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 mr-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                    </svg>
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.upload.show') }}"
                                   class="flex items-center pl-5 pr-2 py-4 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.upload.show') ? 'bg-gradient-to-tl from-customBlue to-customBlue/60 text-white' : 'hover:bg-customBlue/10' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 mr-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m6.75 12-3-3m0 0-3 3m3-3v6m-1.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                    Upload Files
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.categories') }}"
                                   class="flex items-center pl-5 pr-2 py-4 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.categories') ? 'bg-gradient-to-tl from-customBlue to-customBlue/60 text-white' : 'hover:bg-customBlue/10' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 mr-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                                    </svg>
                                    Manage Categories
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.users') }}"
                                   class="flex items-center pl-5 pr-2 py-4 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.users') ? 'bg-gradient-to-tl from-customBlue to-customBlue/60 text-white' : 'hover:bg-customBlue/10' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 mr-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                    </svg>
                                    Users List
                                </a>
                            </li>
                        </ul>
                    </nav>

                    <!-- Color Picker (Now Syncs Sidebar & Navbar) -->
                    {{-- <div class="p-4 border-t border-opacity-30"> --}}
                    {{--     <div class="flex space-x-2"> --}}
                    {{--         <!-- Color Options --> --}}
                    {{--         <template x-for="color in [ --}}
                    {{--             { name: 'White', class: 'bg-gray-700' }, --}}
                    {{--             { name: 'Blue', class: 'bg-blue-700' }, --}}
                    {{--             { name: 'Purple', class: 'bg-purple-700' }, --}}
                    {{--             { name: 'Green', class: 'bg-green-700' }, --}}
                    {{--             { name: 'Red', class: 'bg-red-700' } --}}
                    {{--         ]"> --}}
                    {{--             <button @click="setTheme(color.class)" --}}
                    {{--                     :class="color.class" --}}
                    {{--                     class="w-8 h-8 transition border-2 border-transparent rounded-full hover:border-white"> --}}
                    {{--             </button> --}}
                    {{--         </template> --}}
                    {{--     </div> --}}
                    {{-- </div> --}}
                </div>
            </div>
        @endif

        <!-- Main Content -->
        <div class="flex flex-col flex-1">
            <!-- Navigation Bar -->
            @if(Auth::check() && Auth::user()->is_admin)
                <nav class="transition-all duration-300 bg-gray-200">
                    <div class="{{ Auth::check() && Auth::user()->is_admin ? 'w-full' : 'max-w-7xl' }} px-2 mx-auto sm:px-6 lg:px-8">
                        <div class="flex justify-end h-16">
                            {{-- <div class="flex items-center"> --}}
                            {{--     <!-- Hamburger Toggle Button --> --}}
                            {{--     <button @click="toggleSidebar" --}}
                            {{--             :class="sidebarOpen ? 'ml-60' : 'ml-0'" --}}
                            {{--             class="p-2 pl-0 mr-2 text-gray-700 rounded-md hover:text-gray-600 focus:outline-none"> --}}
                            {{--         <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"> --}}
                            {{--             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" --}}
                            {{--                   d="M4 6h16M4 12h16m-7 6h7"/> --}}
                            {{--         </svg> --}}
                            {{--     </button> --}}
                            {{-- </div> --}}

                            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                                <div class="relative ml-3">
                                    <x-dropdown align="right" width="48">
                                        <x-slot name="trigger">
                                            <button class="flex items-center text-sm font-medium hover:text-gray-700">
                                                <!-- Profile Image or Default Avatar -->
                                                {{-- <img class="w-8 h-8 mr-2 rounded-full" --}}
                                                {{--     src="{{ asset('images/SkyHybrid.png') }}"/> --}}

                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 mr-2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                                </svg>

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
                <header class="transition-all duration-300 bg-black shadow">
                    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="flex-1 py-4 p-6 transition-all duration-300 {{ Auth::check() && Auth::user()->is_admin ? 'ml-64' : '' }}">
                {{ $slot }}
            </main>
            @include('layouts.footer')
        </div>
    </div>
</body>
</html>
