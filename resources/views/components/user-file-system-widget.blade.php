<div class="grid grid-cols-1 gap-6 mb-4 md:grid-cols-2 lg:grid-cols-3">
    <!-- User Storage Usage -->
    <div class="relative rounded-lg shadow-lg p-7 text-white/90 bg-gradient-to-t from-customBlue to-customBlue/20 backdrop-blur-sm">
        <div class="flex items-center space-x-4">
            <!-- Icon -->
            <div class="p-3 bg-caplionGold rounded-full border-t border-white/10 pt-2.5 shadow-xl">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-7 text-sky-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                </svg>

            </div>
            <!-- Content -->
            <div class="flex items-center justify-between w-full">
                <h3 class="flex flex-col text-xl font-medium">
                    Unread Files
                    <span class="text-xs text-white/60">Current Uploaded Files</span>
                </h3>
                <p class="flex items-center text-3xl font-bold">
                    {{ $unreadFilesCount ?? 0 }}
                </p>
            </div>
        </div>
    </div>

    <!-- Recent User Uploads -->
    <div class="relative rounded-lg shadow-lg p-7 text-white/90 bg-gradient-to-t from-customBlue to-customBlue/20 backdrop-blur-sm">
        <div class="flex items-center space-x-4">
            <!-- Icon -->
            <div class="p-3 bg-caplionGold rounded-full border-t border-white/10 pt-2.5 shadow-xl">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-7 text-sky-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m6.75 12-3-3m0 0-3 3m3-3v6m-1.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
            </div>
            <!-- Content -->
            <div class="flex items-center justify-between w-full">
                <h3 class="flex flex-col text-xl font-medium">
                    Recent Uploads
                    <span class="text-xs text-white/60">In the last 7 days</span>
                </h3>
                <p class="flex items-center text-3xl font-bold">
                    {{ $recentUploadsCount ?? 0 }}
                </p>
            </div>
        </div>
    </div>

    <!-- Total User Files -->
    <div class="relative rounded-lg shadow-lg p-7 text-white/90 bg-gradient-to-t from-customBlue to-customBlue/20 backdrop-blur-sm">
        <div class="flex items-center space-x-4">
            <!-- Icon -->
            <div class="p-3 bg-caplionGold rounded-full border-t border-white/10 pt-2.5 shadow-xl">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-7 text-sky-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                </svg>
            </div>
            <!-- Content -->
            <div class="flex items-center justify-between w-full">
                <h3 class="flex flex-col text-xl font-medium">
                    Total Files
                    <span class="text-xs text-white/60">All uploaded documents</span>
                </h3>
                <p class="flex items-center text-3xl font-bold">
                    {{ $totalFiles ?? 0 }}
                </p>
            </div>
        </div>
    </div>
</div>
