<div class="grid grid-cols-1 gap-6 mb-4 md:grid-cols-2 lg:grid-cols-3">
    <!-- Total User Files -->
    <div class="relative p-7 text-white/90 shadow-lg rounded-lg bg-gradient-to-t from-customBlue to-customBlue/20 backdrop-blur-sm">
        <div class="flex items-center space-x-4">
            <!-- Icon -->
            <div class="p-3 bg-caplionGold rounded-full border-t border-white/10 pt-2.5 shadow-xl">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-7 text-sky-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                </svg>
            </div>
            <!-- Content -->
            <div class="flex justify-between items-center w-full">
                <h3 class="text-xl font-medium flex flex-col">
                    Total Files
                    <span class="text-xs text-white/60">All uploaded documents</span>
                </h3>
                <p class="text-3xl font-bold flex items-center">
                    {{ $totalFiles ?? 0 }}
                </p>
            </div>
        </div>
    </div>

    <!-- User Storage Usage -->
    <div class="relative p-7 text-white/90 shadow-lg rounded-lg bg-gradient-to-t from-customBlue to-customBlue/20 backdrop-blur-sm">
        <div class="flex items-center space-x-4">
            <!-- Icon -->
            <div class="p-3 bg-caplionGold rounded-full border-t border-white/10 pt-2.5 shadow-xl">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-7 text-sky-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                </svg>

            </div>
            <!-- Content -->
            <div class="flex justify-between items-center w-full">
                <h3 class="text-xl font-medium flex flex-col">
                    Storage Usage
                    <span class="text-xs text-white/60">Current space used</span>
                </h3>
                <p class="text-3xl font-bold flex items-center">
                    {{ $storageUsage }}
                </p>
            </div>
        </div>
    </div>

    <!-- Recent User Uploads -->
    <div class="relative p-7 text-white/90 shadow-lg rounded-lg bg-gradient-to-t from-customBlue to-customBlue/20 backdrop-blur-sm">
        <div class="flex items-center space-x-4">
            <!-- Icon -->
            <div class="p-3 bg-caplionGold rounded-full border-t border-white/10 pt-2.5 shadow-xl">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-7 text-sky-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m6.75 12-3-3m0 0-3 3m3-3v6m-1.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
            </div>
            <!-- Content -->
            <div class="flex justify-between items-center w-full">
                <h3 class="text-xl font-medium flex flex-col">
                    Recent Uploads
                    <span class="text-xs text-white/60">In the last 7 days</span>
                </h3>
                <p class="text-3xl font-bold flex items-center">
                    {{ $recentUploadsCount ?? 0 }}
                </p>
            </div>
        </div>
    </div>
</div>
