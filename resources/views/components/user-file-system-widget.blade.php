<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-4">
    <!-- Total User Files -->
    <div class="p-5 rounded-xl shadow-lg bg-white dark:bg-gray-900 bg-opacity-30 dark:bg-opacity-40 backdrop-blur-lg transition-all duration-300 border border-gray-200 dark:border-gray-800 hover:border-gray-400 dark:hover:border-gray-600 cursor-pointer group relative">
        <div class="absolute inset-0 bg-gradient-to-br from-purple-500/20 to-blue-500/20 rounded-xl group-hover:opacity-40 transition-opacity duration-300"></div>
        <p class="text-sm font-medium text-gray-600 dark:text-gray-300 group-hover:text-gray-800 dark:group-hover:text-gray-100 transition-colors">
            Total Files
        </p>
        <p class="text-4xl font-bold text-gray-900 dark:text-white mt-2 drop-shadow-lg">
            {{ $totalFiles ?? 0 }}
        </p>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">All your uploaded documents</p>
    </div>

    <!-- User Storage Usage -->
    <div class="p-5 rounded-xl shadow-lg bg-white dark:bg-gray-900 bg-opacity-30 dark:bg-opacity-40 backdrop-blur-lg transition-all duration-300 border border-gray-200 dark:border-gray-800 hover:border-gray-400 dark:hover:border-gray-600 cursor-pointer group relative">
        <div class="absolute inset-0 bg-gradient-to-br from-green-500/20 to-cyan-500/20 rounded-xl group-hover:opacity-40 transition-opacity duration-300"></div>
        <p class="text-sm font-medium text-gray-600 dark:text-gray-300 group-hover:text-gray-800 dark:group-hover:text-gray-100 transition-colors">
            Storage Usage
        </p>
        <p class="text-4xl font-bold text-gray-900 dark:text-white mt-2 drop-shadow-lg">
            {{ $storageUsage }}
        </p>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Current space used</p>
    </div>

    <!-- Recent User Uploads -->
    <div class="p-5 rounded-xl shadow-lg bg-white dark:bg-gray-900 bg-opacity-30 dark:bg-opacity-40 backdrop-blur-lg transition-all duration-300 border border-gray-200 dark:border-gray-800 hover:border-gray-400 dark:hover:border-gray-600 cursor-pointer group relative">
        <div class="absolute inset-0 bg-gradient-to-br from-pink-500/20 to-red-500/20 rounded-xl group-hover:opacity-40 transition-opacity duration-300"></div>
        <p class="text-sm font-medium text-gray-600 dark:text-gray-300 group-hover:text-gray-800 dark:group-hover:text-gray-100 transition-colors">
            Recent Uploads
        </p>
        <p class="text-4xl font-bold text-gray-900 dark:text-white mt-2 drop-shadow-lg">
            {{ $recentUploadsCount ?? 0 }}
        </p>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">In the last 7 days</p>
    </div>
</div>
