<div class="grid grid-cols-1 gap-6 mb-4 md:grid-cols-2 lg:grid-cols-3">
    <!-- Total User Files -->
    <div class="relative p-5 transition-all duration-300 border border-gray-200 shadow-lg cursor-pointer bg-customBlue rounded-xl dark:bg-gray-900 bg-opacity-30 dark:bg-opacity-40 backdrop-blur-lg dark:border-gray-800 hover:border-gray-400 dark:hover:border-gray-600 group">
        <div class="absolute inset-0 transition-opacity duration-300 bg-gradient-to-br from-purple-500/20 to-blue-500/20 rounded-xl group-hover:opacity-40"></div>
        <p class="text-sm font-medium text-white transition-colors group-hover:text-white-800 dark:group-hover:text-gray-100">
            Total Files
        </p>
        <p class="mt-2 text-4xl font-bold text-white drop-shadow-lg">
            {{ $totalFiles ?? 0 }}
        </p>
        <p class="mt-2 text-xs text-white">All your uploaded documents</p>
    </div>

    <!-- User Storage Usage -->
    <div class="relative p-5 transition-all duration-300 border border-gray-200 shadow-lg cursor-pointer bg-customBlue rounded-xl dark:bg-gray-900 bg-opacity-30 dark:bg-opacity-40 backdrop-blur-lg dark:border-gray-800 hover:border-gray-400 dark:hover:border-gray-600 group">
        <div class="absolute inset-0 transition-opacity duration-300 bg-gradient-to-br from-green-500/20 to-cyan-500/20 rounded-xl group-hover:opacity-40"></div>
        <p class="text-sm font-medium text-white transition-colors group-hover:text-gray-800 dark:group-hover:text-gray-100">
            Storage Usage
        </p>
        <p class="mt-2 text-4xl font-bold text-white drop-shadow-lg">
            {{ $storageUsage }}
        </p>
        <p class="mt-2 text-xs text-white">Current space used</p>
    </div>

    <!-- Recent User Uploads -->
    <div class="relative p-5 transition-all duration-300 border border-gray-200 shadow-lg cursor-pointer bg-customBlue rounded-xl dark:bg-gray-900 bg-opacity-30 dark:bg-opacity-40 backdrop-blur-lg dark:border-gray-800 hover:border-gray-400 dark:hover:border-gray-600 group">
        <div class="absolute inset-0 transition-opacity duration-300 bg-gradient-to-br from-pink-500/20 to-red-500/20 rounded-xl group-hover:opacity-40"></div>
        <p class="text-sm font-medium text-white transition-colors group-hover:text-gray-800 dark:group-hover:text-gray-100">
            Recent Uploads
        </p>
        <p class="mt-2 text-4xl font-bold text-white drop-shadow-lg">
            {{ $recentUploadsCount ?? 0 }}
        </p>
        <p class="mt-2 text-xs text-white">In the last 7 days</p>
    </div>
</div>
