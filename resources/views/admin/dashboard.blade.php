<x-app-layout>
    <div class="py-6">
        <div class="w-full mx-auto sm:px-6 lg:px-20">
            <x-user-file-system-widget
                    :totalFiles="$totalFiles"
                    :unreadFilesCount="$unreadFilesCount"
                    :recentUploadsCount="$recentUploadsCount"
                />

            <!-- Uploaded Files Table -->
            <x-files-list :files="$files" :category="$categories"/>
        </div>
    </div>
</x-app-layout>
