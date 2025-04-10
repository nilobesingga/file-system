<div class="p-6 mb-6 bg-white rounded-lg shadow-md">
    <h3 class="mb-4 text-lg font-semibold text-gray-900">Investment Overview</h3>

    <!-- Charts Container -->
    <div class="flex flex-col gap-6 md:flex-row">
        <!-- Left Chart: Investor's Assets, Monthly Net Gain/Loss, Monthly Net Performance -->
        <div class="w-full md:w-1/2 h-[300px]">
            <canvas id="performanceChart-{{ $investorCode }}"></canvas>
        </div>

        <!-- Right Chart: Number of Bonds -->
        <div class="w-full md:w-1/2 h-[300px]">
            <canvas id="bondsChart-{{ $investorCode }}"></canvas>
        </div>
    </div>

    <!-- Chart.js and chartjs-plugin-datalabels -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Register the datalabels plugin
            Chart.register(ChartDataLabels);

            // Performance Chart (Left)
            const performanceCtx = document.getElementById('performanceChart-{{ $investorCode }}').getContext('2d');
            new Chart(performanceCtx, {
                type: 'bar',
                data: {
                    labels: @json($statistics->pluck('month')),
                    datasets: [
                        {
                            label: 'Monthly Net Performance (%)',
                            type: 'line',
                            data: @json($statistics->pluck('monthly_net_percentage')),
                            borderColor: 'rgba(6, 100, 1, 1)',
                            yAxisID: 'y1',
                        },
                        {
                            label: "Investor's Assets ($)",
                            data: @json($statistics->pluck('investor_assets')),
                            backgroundColor: 'rgba(226, 126, 25)',
                            yAxisID: 'y',
                        },
                        {
                            label: 'Monthly Net Gain/Loss ($)',
                            data: @json($statistics->pluck('monthly_net_gain_loss')),
                            backgroundColor: 'rgb(34, 81, 142)',
                            yAxisID: 'y',
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Amount ($)',
                            },
                        },
                        y1: {
                            position: 'right',
                            beginAtZero: true,
                            min: -20,
                            max: 20,
                            title: {
                                display: true,
                                text: 'Percentage (%)',
                            },
                            grid: {
                                drawOnChartArea: false, // Only show grid for the left y-axis
                            },
                        },
                        x: {
                            title: {
                                display: false,
                                text: 'Month',
                            },
                        },
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        datalabels: {
                            anchor: 'end',
                            align: 'top',
                            offset: 5, // Add some space between the bar/line and the label
                            formatter: (value, context) => {
                                if (context.dataset.label === "Investor's Assets ($)") {
                                    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(value);
                                } else if (context.dataset.label === 'Monthly Net Gain/Loss ($)') {
                                    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(value);
                                } else {
                                    return value + '%'; // Format percentage with 2 decimals
                                }
                            },
                            color: '#000',
                            font: {
                                weight: 'bold',
                                size: 12,
                            },
                        },
                    },
                },
            });

            // Bonds Chart (Right)
            const bondsCtx = document.getElementById('bondsChart-{{ $investorCode }}').getContext('2d');
            new Chart(bondsCtx, {
                type: 'bar',
                data: {
                    labels: @json($statistics->pluck('month')),
                    datasets: [{
                        label: 'Number of Bonds',
                        data: @json($statistics->pluck('number_of_bonds')),
                        backgroundColor: 'rgb(34, 81, 142)',
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Bonds',
                            },
                        },
                        x: {
                            title: {
                                display: false,
                                text: 'Month',
                            },
                        },
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        datalabels: {
                            anchor: 'end',
                            align: 'top',
                            offset: 5, // Add some space between the bar and the label
                            formatter: (value) => value, // Display the raw number
                            color: '#000',
                            font: {
                                weight: 'bold',
                                size: 12,
                            },
                        },
                    },
                },
            });
        });
    </script>
</div>
