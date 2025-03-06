<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot> --}}

    <div class="py-6">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <x-user-file-system-widget
                    :totalFiles="$totalFiles"
                    storageUsage="{{ $storageUsage }}"
                    :recentUploadsCount="$recentUploadsCount"
                />

            <!-- Uploaded Files Table -->
            <x-files-list :files="$files"/>
        </div>
    </div>
</x-app-layout>
