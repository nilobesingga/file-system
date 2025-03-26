<nav x-data="{ open: false }" class="border-b-4 border-yellow-900 dark:bg-yellow-800 dark:border-yellow-700">
    <div class="{{ Auth::check() && Auth::user()->is_admin ? 'w-full' : 'max-w-7xl' }} px-2 mx-auto  sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex items-center shrink-0">
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'Laravel') }}" class="w-auto h-8">
                    </a>
                </div>
            </div>

            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                <!-- Notification Bell -->
                <div class="relative ml-3" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <a href="#" class="relative flex items-center mr-2 text-white hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        @if(\App\Helpers\FileHelper::getNotication() > 0)
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-orange-100 transform translate-x-1/2 -translate-y-1/2 bg-orange-600 rounded-full">
                            {{ \App\Helpers\FileHelper::getNotication()  }}
                        </span>
                        @endif
                    </a>
                    <!-- Dropdown -->
                    <div x-show="open" class="absolute right-0 z-50 w-64 mt-2 origin-top-right bg-white border border-gray-200 rounded-md shadow-lg dark:bg-gray-800 dark:border-gray-700">
                        <div class="py-2">
                            @foreach(\App\Helpers\FileHelper::getUnreadNotifications() as $key => $notification)
                                <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <i class="w-5 mr-2 text-gray-800 fas fa-envelope dark:text-gray-300"></i>
                                    {{ $notification['message'] }}
                                </a>
                                @if (!$key == \App\Helpers\FileHelper::getNotication())
                                    <hr class="border-gray-200 dark:border-gray-700">
                                @endif
                            @endforeach
                            @if(empty(\App\Helpers\FileHelper::getUnreadNotifications()))
                                <p class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300">No unread notifications</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Profile Dropdown -->
                <div class="relative ml-3">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-white hover:text-gray-300">
                                <!-- Profile Image or Default Avatar -->
                                {{-- <img class="w-8 h-8 mr-2 rounded-full"
                                    src="{{ asset('images/SkyHybrid.png') }}"
                                    alt="{{ Auth::user()->name }}"> --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-5 h-6 mr-2 bi bi-person-circle" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                                    </svg>
                                {{ Auth::user()->name }}
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('logout')"
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
