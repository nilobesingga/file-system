<!-- Weekly Investment Graph -->
<div class="grid grid-cols-1 gap-6 mb-6 sm:grid-cols-2 lg:grid-cols-2">
    <!-- Weekly Investment Amount Chart -->
    <div class="relative p-8 text-gray-700 bg-white rounded-lg shadow-md">
        <div class="flex items-center mb-4 space-x-4">
            <!-- Icon -->
            <div class="p-2 rounded-full bg-customBlue">
                <svg class="text-white size-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <!-- Title -->
            <div>
                <h3 class="text-sm font-semibold tracking-wide text-gray-600 uppercase">Investment Amount</h3>
            </div>
        </div>
        <!-- Chart -->
        <canvas id="weeklyInvestmentChart" class="w-full" style="max-height: 200px;"></canvas>
    </div>

    <!-- Weekly Number of Bonds Chart -->
    <div class="relative p-8 text-gray-700 bg-white rounded-lg shadow-md">
        <div class="flex items-center mb-4 space-x-4">
            <!-- Icon -->
            <div class="p-2 rounded-full bg-customGreen">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-white size-7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v7.5m2.25-6.466a9.016 9.016 0 0 0-3.461-.203c-.536.072-.974.478-1.021 1.017a4.559 4.559 0 0 0-.018.402c0 .464.336.844.775.994l2.95 1.012c.44.15.775.53.775.994 0 .136-.006.27-.018.402-.047.539-.485.945-1.021 1.017a9.077 9.077 0 0 1-3.461-.203M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
            </div>
            <!-- Title -->
            <div>
                <h3 class="text-sm font-semibold tracking-wide text-gray-600 uppercase">Number of Bonds</h3>
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
            data: @json($monthlyInvestments),
            backgroundColor: '#22518E', // Blue with transparency
            borderColor: 'rgba(59, 130, 246, 1)', // Solid blue border
            borderWidth: 0,
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
                    color: '#555', // Gray-600 for light mode
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
                    color: '#555', // Gray-600 for light mode
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
            data: @json($monthlyBonds),
            backgroundColor: '#11CABE', // Teal with transparency
            borderColor: 'rgba(20, 184, 166, 1)', // Solid teal border
            borderWidth: 0,
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
                    color: '#555', // Gray-600 for light mode
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
                    color: '#555', // Gray-600 for light mode
                },
                grid: {
                    display: false, // Remove horizontal grid lines
                }
            }
        }
    }
});

</script>
