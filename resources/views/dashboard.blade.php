<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            User Dashboard
        </h2>
    </x-slot> --}}

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- User Profile Section -->
            <div class="p-4 mb-8 rounded-lg shadow bg-gray-50 dark:bg-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Welcome, {{ Auth::user()->name }}!</h3>
                <p class="mt-2 text-gray-600 dark:text-gray-300">
                    Email: {{ Auth::user()->email }}<br>
                    Member Since: {{ Auth::user()->created_at->format('F d, Y') }}
                </p>
            </div>
            <x-files-list :files="$files" :category="$category"/>
        </div>
    </div>
</x-app-layout>
