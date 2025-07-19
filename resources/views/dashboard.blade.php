<x-layouts.sidebar>
    <div class="p-6 space-y-6">

        <!-- Header -->
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white p-6 rounded-xl shadow">
            <h1 class="text-3xl font-bold">Welcome back, {{ auth()->user()->name }}! 🛍️</h1>
            <p class="text-lg mt-1">Here's what's happening in your store today.</p>
        </div>

        <!-- Stat Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-5 rounded-lg shadow">
                <h3 class="text-sm font-semibold text-gray-500">Total Products</h3>
                <p class="text-2xl font-bold text-green-600 mt-2">124</p>
            </div>
            <div class="bg-white p-5 rounded-lg shadow">
                <h3 class="text-sm font-semibold text-gray-500">Orders Today</h3>
                <p class="text-2xl font-bold text-blue-600 mt-2">37</p>
            </div>
            <div class="bg-white p-5 rounded-lg shadow">
                <h3 class="text-sm font-semibold text-gray-500">New Customers</h3>
                <p class="text-2xl font-bold text-purple-600 mt-2">18</p>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">📈 Monthly Sales Overview</h2>
            <canvas id="salesChart" height="100"></canvas>
        </div>

        <!-- Customers Overview -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">📦 Latest Orders</h2>
            <ul class="divide-y divide-gray-200">
                <li class="py-3 flex justify-between">
                    <span>Order #1024</span>
                    <span class="text-sm text-green-600 font-semibold">Completed</span>
                </li>
                <li class="py-3 flex justify-between">
                    <span>Order #1023</span>
                    <span class="text-sm text-yellow-500 font-semibold">Pending</span>
                </li>
                <li class="py-3 flex justify-between">
                    <span>Order #1022</span>
                    <span class="text-sm text-red-500 font-semibold">Canceled</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Chart Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const ctx = document.getElementById('salesChart').getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Sales (BDT)',
                        data: [12000, 19000, 3000, 5000, 8000, 14000],
                        fill: true,
                        backgroundColor: 'rgba(16, 185, 129, 0.2)',
                        borderColor: 'rgba(5, 150, 105, 1)',
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' },
                        title: {
                            display: false
                        }
                    }
                }
            });
        });
    </script>
</x-layouts.sidebar>
