<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-medium mb-4">Sales Overview</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Sales Over Time -->
                <div>
                    <h4 class="font-semibold mb-2">Sales Over time</h4>
                    <canvas id="salesOverTimechart"></canvas>
                </div>

                <!-- Top Products -->
                <div>
                    <h4 class="font-semibold mb-2">Top 5 Products</h4>
                    <canvas id="topProductsChart"></canvas>
                </div>

                <!-- Sales by Region -->
                <div>
                    <h4 class="font-semibold mb-2">Sales by Region</h4>
                    <canvas id="salesbyRegionChart"></canvas>
                </div>

            </div>
        </div>

    </div>

    {{-- Add Chart.js script --}}
    @vite('resources/js/app.js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const salesOverTime = @json($salesOverTime);
        const topProducts = @json($topProducts);
        const salesByRegion = @json($salesByRegion);

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
            }
        });

        // Top Products
        new Chart(document.getElementById('topProductsChart'), {
            type: 'bar',
            data: {
                labels: topProducts.map(d => [d.product.name, `(${d.product.category})`]),
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
                }],
            },
            options: {
                scales: {
                    x: {
                        ticks: {
                            maxRotation: 0,
                            minRotation: 0, // keep horizontal, or set 30 for diagonal
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
                    backgroundColor: ['#60a5fa', '#34d399', '#fbbf24', '#f87171', '#a78bfa']
                }]
            }
        });
    </script>
</x-app-layout>
