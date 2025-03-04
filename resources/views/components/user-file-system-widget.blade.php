<div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4 mb-4 border border-gray-200 dark:border-gray-700">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3 flex items-center gap-2">
        <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm0 1h12a1 1 0 011 1v10a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1zm3 3a1 1 0 00-1 1v6a1 1 0 001 1h6a1 1 0 001-1V8a1 1 0 00-1-1H7zm1 1h4a1 1 0 011 1v4a1 1 0 01-1 1H8a1 1 0 01-1-1V9a1 1 0 011-1z" clip-rule="evenodd" />
        </svg>
        My File System
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-2">
        <!-- Total User Files -->
        <div class="p-3 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 rounded-lg shadow hover:shadow-lg transition-all duration-200 cursor-pointer group">
            <p class="text-sm font-medium text-gray-600 dark:text-gray-300 group-hover:text-gray-800 dark:group-hover:text-gray-200 transition-colors">Total Files</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $totalFiles ?? 0 }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">All your uploaded documents</p>
        </div>

        <!-- User Storage Usage -->
        <div class="p-3 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 rounded-lg shadow hover:shadow-lg transition-all duration-200 cursor-pointer group">
            <p class="text-sm font-medium text-gray-600 dark:text-gray-300 group-hover:text-gray-800 dark:group-hover:text-gray-200 transition-colors">Storage Usage</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ number_format($storageUsage / 1024 / 1024, 2) }} MB</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Current space used</p>
        </div>

        <!-- Recent User Uploads -->
        <div class="p-3 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 rounded-lg shadow hover:shadow-lg transition-all duration-200 cursor-pointer group">
            <p class="text-sm font-medium text-gray-600 dark:text-gray-300 group-hover:text-gray-800 dark:group-hover:text-gray-200 transition-colors">Recent Uploads</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $recentUploadsCount ?? 0 }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">In the last 7 days</p>
        </div>
    </div>
</div>
