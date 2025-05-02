<div class="grid grid-cols-1 gap-6 mb-6 sm:grid-cols-3 lg:grid-cols-3">
    <!-- Amount Invested Card -->
    <div class="relative text-white rounded-lg shadow-lg p-7 bg-gradient-to-b to-customBlue from-customBlue/20 backdrop-blur-sm">
        <div class="flex items-center space-x-4">
            <!-- Icon -->
            <div class="p-3 bg-caplionGold rounded-full border-t border-white/10 pt-2.5 shadow-xl">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-7 text-sky-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.99 14.993 6-6m6 3.001c0 1.268-.63 2.39-1.593 3.069a3.746 3.746 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043 3.745 3.745 0 0 1-3.068 1.593c-1.268 0-2.39-.63-3.068-1.593a3.745 3.745 0 0 1-3.296-1.043 3.746 3.746 0 0 1-1.043-3.297 3.746 3.746 0 0 1-1.593-3.068c0-1.268.63-2.39 1.593-3.068a3.746 3.746 0 0 1 1.043-3.297 3.745 3.745 0 0 1 3.296-1.042 3.745 3.745 0 0 1 3.068-1.594c1.268 0 2.39.63 3.068 1.593a3.745 3.745 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.297 3.746 3.746 0 0 1 1.593 3.068ZM9.74 9.743h.008v.007H9.74v-.007Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm4.125 4.5h.008v.008h-.008v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
            </div>
            <!-- Content -->
            <div>
                <h3 class="text-sm font-medium tracking-wider uppercase opacity-80">NET PERFORMANCE OF INVESTED CAPITAL (YTD</h3>
                <p class="text-2xl font-bold">{{ $netPerformance }}%</p>
            </div>
        </div>
    </div>

    <!-- Amount Invested Card -->
    <div class="relative text-white rounded-lg shadow-lg p-7 bg-gradient-to-b to-customBlue from-customBlue/20 backdrop-blur-sm">
        <div class="flex items-center space-x-4">
            <!-- Icon -->
            <div class="p-3 bg-caplionGold rounded-full border-t border-white/10 pt-2.5 shadow-xl">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-7 text-sky-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.99 14.993 6-6m6 3.001c0 1.268-.63 2.39-1.593 3.069a3.746 3.746 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043 3.745 3.745 0 0 1-3.068 1.593c-1.268 0-2.39-.63-3.068-1.593a3.745 3.745 0 0 1-3.296-1.043 3.746 3.746 0 0 1-1.043-3.297 3.746 3.746 0 0 1-1.593-3.068c0-1.268.63-2.39 1.593-3.068a3.746 3.746 0 0 1 1.043-3.297 3.745 3.745 0 0 1 3.296-1.042 3.745 3.745 0 0 1 3.068-1.594c1.268 0 2.39.63 3.068 1.593a3.745 3.745 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.297 3.746 3.746 0 0 1 1.593 3.068ZM9.74 9.743h.008v.007H9.74v-.007Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm4.125 4.5h.008v.008h-.008v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
            </div>
            <!-- Content -->
            <div>
                <h3 class="text-sm font-medium tracking-wider uppercase opacity-80">Last Realized Month’s Net Yield</h3>
                <p class="text-2xl font-bold">{{ $netYield }}%</p>
            </div>
        </div>
    </div>

    <!-- Amount Invested Card -->
    <div class="relative text-white rounded-lg shadow-lg p-7 bg-gradient-to-b to-customBlue from-customBlue/20 backdrop-blur-sm">
        <div class="flex items-center space-x-4">
            <!-- Icon -->
            <div class="p-3 bg-caplionGold rounded-full border-t border-white/10 pt-2.5 shadow-xl">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-7 text-sky-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <!-- Content -->
            <div>
                <h3 class="text-sm tracking-wider uppercase font-sm opacity-80">High Watermark Level of Compounded Distribution</h3>
                <p class="text-2xl font-bold">{{ number_format($hwlcd,2) }}</p>
            </div>
        </div>
    </div>

    <!-- Amount Invested Card -->
    <div class="relative text-white rounded-lg shadow-lg p-7 bg-gradient-to-b from-customBlue to-customBlue/20 backdrop-blur-sm">
        <div class="flex items-center space-x-4">
            <!-- Icon -->
            <div class="p-3 bg-caplionGold rounded-full border-t border-white/10 pt-2.5 shadow-xl">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-7 text-sky-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <!-- Content -->
            <div>
                <h3 class="text-sm font-medium tracking-wider uppercase opacity-80">High Watermark Level of Monthly Distribution</h3>
                <p class="text-2xl font-bold">{{ number_format($hwlmd,2) }}</p>
            </div>
        </div>
        <!-- Decorative Element -->
        {{-- <div class="absolute top-0 right-0 w-24 h-24 -mt-6 -mr-6 bg-white rounded-full bg-opacity-10"></div> --}}
    </div>

    <!-- Amount Invested Card -->
    <div class="relative text-white rounded-lg shadow-lg p-7 bg-gradient-to-b from-customBlue to-customBlue/20 backdrop-blur-sm">
        <div class="flex items-center space-x-4">
            <!-- Icon -->
            <div class="p-3 bg-caplionGold rounded-full border-t border-white/10 pt-2.5 shadow-xl">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-7 text-sky-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <!-- Content -->
            <div>
                <h3 class="text-sm font-medium tracking-wider uppercase opacity-80">Amount Invested</h3>
                <p class="text-2xl font-bold">{{ number_format($amountInvested, 2) }} {{ $currency }}</p>
            </div>
        </div>
        <!-- Decorative Element -->
        {{-- <div class="absolute top-0 right-0 w-24 h-24 -mt-6 -mr-6 bg-white rounded-full bg-opacity-10"></div> --}}
    </div>

    <!-- Number of Bonds Card -->
    <div class="relative text-white rounded-lg shadow-lg p-7 bg-gradient-to-b from-customBlue to-customBlue/20 backdrop-blur-sm">
        <div class="flex items-center space-x-4">
            <!-- Icon -->
            <div class="p-3 bg-caplionGold rounded-full border-t border-white/10 pt-2.5 shadow-xl">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-7 text-sky-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v7.5m2.25-6.466a9.016 9.016 0 0 0-3.461-.203c-.536.072-.974.478-1.021 1.017a4.559 4.559 0 0 0-.018.402c0 .464.336.844.775.994l2.95 1.012c.44.15.775.53.775.994 0 .136-.006.27-.018.402-.047.539-.485.945-1.021 1.017a9.077 9.077 0 0 1-3.461-.203M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
            </div>
            <!-- Content -->
            <div>
                <h3 class="text-sm font-medium tracking-wider uppercase opacity-80">No. of Bonds</h3>
                <p class="text-2xl font-bold">{{ $numberOfBonds }}</p>
            </div>
        </div>
        <!-- Decorative Element -->
        {{-- <div class="absolute top-0 right-0 w-24 h-24 -mt-6 -mr-6 bg-white rounded-full bg-opacity-10"></div> --}}
    </div>
</div>

