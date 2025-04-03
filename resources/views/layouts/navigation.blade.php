<nav x-data="{ open: false }" class="bg-white">
    <div class="{{ Auth::check() && Auth::user()->is_admin ? 'w-full' : 'max-w-7xl' }} px-2 mx-auto  sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <div class="flex items-center shrink-0">
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <img src="{{ asset('images/SkyHybrid.png') }}" alt="{{ config('app.name', 'Laravel') }}" class="w-auto h-10">
                    </a>
                </div>
            </div>

            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                <!-- Notification Bell -->
                <div class="relative ml-3" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <a href="#" class="relative flex items-center mr-2 text-gray-700 hover:text-sky-700 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                        </svg>
                    @if(\App\Helpers\FileHelper::getNotication() > 0)
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-sky-400 rounded-full">
                            {{ \App\Helpers\FileHelper::getNotication()  }}
                        </span>
                        @endif
                    </a>
                    <!-- Dropdown -->
                    <div x-show="open" class="absolute right-0 z-50 w-64 mt-2 origin-top-right bg-white border border-gray-200 rounded-md shadow-xl">
                        <div class="py-3">
                            @foreach(\App\Helpers\FileHelper::getUnreadNotifications() as $key => $notification)
                                <a href="#" class="flex items-center px-5 py-2 text-gray-700 hover:bg-gray-100">
                                    <i class="w-5 mr-2 fas fa-envelope"></i>
                                    {{ $notification['message'] }}
                                </a>
                                @if (!$key == \App\Helpers\FileHelper::getNotication())
                                    <hr class="border-gray-200">
                                @endif
                            @endforeach
                            @if(empty(\App\Helpers\FileHelper::getUnreadNotifications()))
                                <p class="block px-5 py-2 text-gray-700">No unread notifications</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Profile Dropdown -->
                <div class="relative ml-3">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center font-medium text-gray-700 hover:text-sky-700 transition-all duration-200">
                                <!-- Profile Image or Default Avatar -->
                                {{-- <img class="w-8 h-8 mr-2 rounded-full"
                                    src="{{ asset('images/SkyHybrid.png') }}"
                                    alt="{{ Auth::user()->name }}"> --}}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mr-1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
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
