<div class="grid grid-cols-1 gap-6 mb-6 sm:grid-cols-2 lg:grid-cols-3">
    <!-- New Files Card -->
    <div class="relative p-6 text-white rounded-lg shadow-lg bg-customBlue">
        <div class="flex items-center space-x-4">
            <!-- Icon -->
            <div class="p-3 bg-white rounded-full bg-opacity-20">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <!-- Content -->
            <div>
                <h3 class="text-sm font-medium tracking-wider uppercase opacity-80">New Files</h3>
                <p class="text-2xl font-bold">{{ $newFiles }}</p>
            </div>
        </div>
        <!-- Decorative Element -->
        {{-- <div class="absolute top-0 right-0 w-24 h-24 -mt-6 -mr-6 bg-white rounded-full bg-opacity-10"></div> --}}
    </div>

    <!-- Recent Uploads Card -->
    <div class="relative p-6 text-white rounded-lg shadow-lg bg-customBlue">
        <div class="flex items-center space-x-4">
            <!-- Icon -->
            <div class="p-3 bg-white rounded-full bg-opacity-20">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <!-- Content -->
            <div>
                <h3 class="text-sm font-medium tracking-wider uppercase opacity-80">Recent Uploads</h3>
                <p class="text-2xl font-bold">{{ $recentUploadsCount }}</p>
                <p class="mt-2 text-xs text-white-500 dark:text-gray-400">In the last 7 days</p>
            </div>
        </div>
        <!-- Decorative Element -->
        {{-- <div class="absolute top-0 right-0 w-24 h-24 -mt-6 -mr-6 bg-white rounded-full bg-opacity-10"></div> --}}
    </div>

    <!-- Total Files Card -->
    <div class="relative p-6 text-white rounded-lg shadow-lg bg-customBlue">
        <div class="flex items-center space-x-4">
            <!-- Icon -->
            <div class="p-3 bg-white rounded-full bg-opacity-20">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <!-- Content -->
            <div>
                <h3 class="text-sm font-medium tracking-wider uppercase opacity-80">Total Files</h3>
                <p class="text-2xl font-bold">{{ $totalFiles }}</p>
            </div>
        </div>
        <!-- Decorative Element -->
        {{-- <div class="absolute top-0 right-0 w-24 h-24 -mt-6 -mr-6 bg-white rounded-full bg-opacity-10"></div> --}}
    </div>
</div>

<div class="grid grid-cols-1 gap-6 mb-6 sm:grid-cols-2 lg:grid-cols-2">
    <!-- Amount Invested Card -->
    <div class="relative p-6 text-white rounded-lg shadow-lg bg-customBlue">
        <div class="flex items-center space-x-4">
            <!-- Icon -->
            <div class="p-3 bg-white rounded-full bg-opacity-20">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
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
    <div class="relative p-6 text-white rounded-lg shadow-lg bg-customBlue">
        <div class="flex items-center space-x-4">
            <!-- Icon -->
            <div class="p-3 bg-white rounded-full bg-opacity-20">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
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

<!-- Weekly Investment Graph -->
<div class="grid grid-cols-1 gap-6 mb-6 sm:grid-cols-2 lg:grid-cols-2">
    <!-- Weekly Investment Amount Chart -->
    <div class="relative p-6 text-gray-800 bg-white rounded-lg shadow-md dark:text-gray-200 dark:bg-gray-800">
        <div class="flex items-center mb-4 space-x-4">
            <!-- Icon -->
            <div class="p-2 bg-blue-500 rounded-full">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <!-- Title -->
            <div>
                <h3 class="text-sm font-semibold tracking-wide text-gray-600 uppercase dark:text-gray-400">Investment Amount</h3>
            </div>
        </div>
        <!-- Chart -->
        <canvas id="weeklyInvestmentChart" class="w-full" style="max-height: 200px;"></canvas>
    </div>

    <!-- Weekly Number of Bonds Chart -->
    <div class="relative p-6 text-gray-800 bg-white rounded-lg shadow-md bg-dark dark:text-gray-200 dark:bg-gray-800">
        <div class="flex items-center mb-4 space-x-4">
            <!-- Icon -->
            <div class="p-2 bg-teal-500 rounded-full">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <!-- Title -->
            <div>
                <h3 class="text-sm font-semibold tracking-wide text-gray-600 uppercase dark:text-gray-400">Number of Bonds</h3>
            </div>
        </div>
        <!-- Chart -->
        <canvas id="weeklyBondsChart" class="w-full" style="max-height: 200px;"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Weekly Investment Amount Chart
const weeklyInvestmentCtx = document.getElementById('weeklyInvestmentChart').getContext('2d');
new Chart(weeklyInvestmentCtx, {
    type: 'bar',
    data: {
        labels: @json($labels),
        datasets: [{
            label: 'Amount Invested ($)',
            data: @json($weeklyInvestments),
            backgroundColor: '#22518E', // Blue with transparency
            borderColor: 'rgba(59, 130, 246, 1)', // Solid blue border
            borderWidth: 1,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false,
            }
        },
        scales: {
            x: {
                ticks: {
                    color: '#22518E', // Gray-600 for light mode
                    callback: function(value, index, values) {
                        // Shorten labels for better readability
                        return @json($labels)[index].split(' - ')[0];
                    }
                },
                grid: {
                    display: false,
                }
            },
            y: {
                beginAtZero: true,
                ticks: {
                    color: '#22518E', // Gray-600 for light mode
                    callback: function(value) {
                        return '$' + value.toLocaleString();
                    }
                },
                grid: {
                    display: false, // Remove horizontal grid lines
                }
            }
        }
    }
});

// Weekly Number of Bonds Chart
const weeklyBondsCtx = document.getElementById('weeklyBondsChart').getContext('2d');
new Chart(weeklyBondsCtx, {
    type: 'bar',
    data: {
        labels: @json($labels),
        datasets: [{
            label: 'Number of Bonds',
            data: @json($weeklyBonds),
            backgroundColor: '#11CABE', // Teal with transparency
            borderColor: 'rgba(20, 184, 166, 1)', // Solid teal border
            borderWidth: 1,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false,
            }
        },
        scales: {
            x: {
                ticks: {
                    color: '#11CABE', // Gray-600 for light mode
                    callback: function(value, index, values) {
                        return @json($labels)[index].split(' - ')[0];
                    }
                },
                grid: {
                    display: false,
                }
            },
            y: {
                beginAtZero: true,
                ticks: {
                    color: '#11CABE', // Gray-600 for light mode
                },
                grid: {
                    display: false, // Remove horizontal grid lines
                }
            }
        }
    }
});

</script>
