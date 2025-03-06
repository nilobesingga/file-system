<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            User Dashboard
        </h2>
    </x-slot> --}}

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- User Profile Section -->
            <div class="mb-8 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Welcome, {{ Auth::user()->name }}!</h3>
                <p class="text-gray-600 dark:text-gray-300 mt-2">
                    Email: {{ Auth::user()->email }}<br>
                    Member Since: {{ Auth::user()->created_at->format('F d, Y') }}
                </p>
            </div>
            <x-files-list :files="$files"/>
        </div>
    </div>
</x-app-layout>
