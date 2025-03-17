<nav x-data="{ open: false }" class="border-b dark:bg-white-800 border-white-100 dark:border-white-700">
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
                {{-- @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 dark:text-gray-300">Admin</a>
                @endif --}}
                <div class="relative ml-3">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
                                <!-- Profile Image or Default Avatar -->
                                <img class="w-8 h-8 mr-2 rounded-full"
                                    src="{{ Auth::user()->profile_photo_url ?? 'https://i.pravatar.cc/150?u=' . md5(Auth::user()->email) }}"
                                    alt="{{ Auth::user()->name }}">

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
