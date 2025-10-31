<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl p-6">
            <h3 class="text-lg font-medium mb-4 text-gray-100">Sales Overview</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Sales Over Time -->
                <div class="bg-gray-700 p-4 rounded-xl shadow hover:bg-gray-600 transition">
                    <h4 class="font-semibold mb-2 text-gray-100">Sales Over Time</h4>
                    <canvas id="salesOverTimechart"></canvas>
                </div>

                <!-- Sales by Category -->
                <div class="bg-gray-700 p-4 rounded-xl shadow hover:bg-gray-600 transition">
                    <h4 class="font-semibold mb-2 text-gray-100">Sales by Category</h4>
                    <canvas id="salesbyCategoryChart"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-12">
                <!-- Sales by Region -->
                <div class="bg-gray-700 p-4 rounded-xl shadow hover:bg-gray-600 transition">
                    <h4 class="font-semibold mb-2 text-gray-100">Sales by Region</h4>
                    <canvas id="salesbyRegionChart"></canvas>
                </div>

                <!-- Top Products -->
                <div class="bg-gray-700 p-4 rounded-xl shadow hover:bg-gray-600 transition">
                    <h4 class="font-semibold mb-2 text-gray-100">Top 5 Products</h4>
                    <canvas id="topProductsChart"></canvas>
                </div>
            </div>
        </div>
    </div>


    <div class="py-1 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mt-8 bg-gray-800 p-6 rounded-2xl shadow-lg">
            <h3 class="text-lg font-semibold mb-3 flex items-center gap-2 text-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-indigo-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                AI Insights
            </h3>

            <p id="ai-insights" class="text-gray-200 leading-relaxed">
                💡 The AI system will suggest the month with <strong>the highest sales, along with the top product and
                    top region</strong> of all time.
            </p>

            <button id="generateInsights"
                class="mt-4 bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg transition">
                Generate Insights
            </button>
        </div>
    </div>

    {{-- Add Chart.js script --}}
    @vite('resources/js/app.js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const salesOverTime = @json($salesOverTime);
        const topProducts = @json($topProducts);
        const salesByRegion = @json($salesByRegion);
        const salesByCategory = @json($salesByCategory);

        // Sales Over Time
        new Chart(document.getElementById('salesOverTimechart'), {
            type: 'line',
            data: {
                labels: salesOverTime.map(d => d.month),
                datasets: [{
                    label: 'Revenue',
                    data: salesOverTime.map(d => d.total_revenue),
                    borderWidth: 2,
                    borderColor: 'rgb(75, 192, 192)',
                    fill: false,
                    tension: 0.1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        labels: {
                            color: '#e5e7eb' // Tailwind gray-200
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#e5e7eb'
                        }
                    },
                    y: {
                        ticks: {
                            color: '#e5e7eb'
                        }
                    }
                }
            }
        });

        // Top Products
        new Chart(document.getElementById('topProductsChart'), {
            type: 'bar',
            data: {
                labels: topProducts.map(d => `${d.product.name} (${d.product.category})`),
                datasets: [{
                    label: 'Revenue',
                    data: topProducts.map(d => d.total_revenue),
                    borderWidth: 2,
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                    ],
                    tension: 0.1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        labels: {
                            color: '#e5e7eb' // Tailwind gray-200
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#e5e7eb', // make X-axis labels readable
                            maxRotation: 0,
                            minRotation: 0,
                        }
                    },
                    y: {
                        ticks: {
                            color: '#e5e7eb', // make Y-axis labels readable
                        }
                    }
                }
            }
        });


        // Sales by region
        new Chart(document.getElementById('salesbyRegionChart'), {
            type: 'pie',
            data: {
                labels: salesByRegion.map(d => d.region.name),
                datasets: [{
                    data: salesByRegion.map(d => d.total_revenue),
                    backgroundColor: [
                        '#60a5fa', // blue
                        '#34d399', // green
                        '#fbbf24', // yellow
                        '#f87171', // red
                        '#a78bfa', // purple
                        '#f472b6', // pink
                        '#facc15', // amber
                        '#22d3ee', // cyan
                        '#fb923c', // orange
                        '#e879f9' // violet
                    ]
                }]
            },
            options: {
                plugins: {
                    legend: {
                        labels: {
                            color: '#e5e7eb' // Tailwind gray-200
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#e5e7eb'
                        }
                    },
                    y: {
                        ticks: {
                            color: '#e5e7eb'
                        }
                    }
                }
            }
        });

        // Sales by category
        new Chart(document.getElementById('salesbyCategoryChart'), {
            type: 'doughnut',
            data: {
                labels: salesByCategory.map(d => d.category),
                datasets: [{
                    data: salesByCategory.map(d => d.total_revenue),
                    backgroundColor: [
                        '#60a5fa', // blue
                        '#34d399', // green
                        '#fbbf24', // yellow
                        '#f87171', // red
                        '#a78bfa', // purple
                        '#f472b6', // pink
                        '#facc15', // amber
                        '#22d3ee', // cyan
                        '#fb923c', // orange
                        '#e879f9' // violet
                    ]
                }]
            },
            options: {
                plugins: {
                    legend: {
                        labels: {
                            color: '#e5e7eb' // Tailwind gray-200
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#e5e7eb'
                        }
                    },
                    y: {
                        ticks: {
                            color: '#e5e7eb'
                        }
                    }
                }
            }
        });

        document.getElementById('generateInsights').addEventListener('click', async () => {
            const btn = document.getElementById('generateInsights');
            const output = document.getElementById('ai-insights');

            btn.disabled = true;
            btn.textContent = 'Generating...';

            try {
                const res = await fetch('/api/ai-insights');
                const data = await res.json();
                output.textContent = `📈 ${data.insight}`;
            } catch (error) {
                output.textContent = '⚠️ Failed to generate insight.';
            }

            btn.disabled = false;
            btn.textContent = 'Generate Insights';
        });
    </script>
</x-app-layout>
