<x-header-admin title="Dashboard" />

<body class="bg-[#0f172a] text-white font-sans">

    <div class="flex min-h-screen">

        <x-sidebar-admin />

        <main class="flex-1 p-6 space-y-6 ml-64">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold">Welcome back, {{ Auth::user()->name }}</h1>
                    <p class="text-gray-400">Measure everything and report website traffic.</p>
                </div>
                <button class="bg-white text-black px-4 py-2 rounded">Print report</button>
            </div>


            <div class="grid grid-cols-4 gap-4">
                <div class="bg-[#1e293b] p-4 rounded">
                    <div class="text-gray-400">👁 Pageviews</div>
                    <div class="text-2xl font-semibold">{{ number_format($pageviews) }}</div>
                </div>
                <div class="bg-[#1e293b] p-4 rounded">
                    <div class="text-gray-400">👥 Monthly users</div>
                    <div class="text-2xl font-semibold">{{ number_format($monthlyUsers) }}</div>
                </div>
                <div class="bg-[#1e293b] p-4 rounded">
                    <div class="text-gray-400">📝 New sign ups</div>
                    <div class="text-2xl font-semibold">{{ number_format($newSignups) }}</div>
                </div>
                <div class="bg-[#1e293b] p-4 rounded">
                    <div class="text-gray-400">🛍 Monthly transactions</div>
                    <div class="text-2xl font-semibold">{{ number_format($monthlyTransactions) }}</div>
                </div>
                <div class="bg-[#1e293b] p-4 rounded">
                    <div class="text-gray-400">Total Seller</div>
                    <div class="text-2xl font-semibold">{{ $totalSellers ?? '0' }}</div>
                </div>
                <div class="bg-[#1e293b] p-4 rounded">
                    <div class="text-gray-400">Total Customers</div>
                    <div class="text-2xl font-semibold">{{ $totalCustomers ?? '0' }}</div>
                </div>
                <div class="bg-[#1e293b] p-4 rounded">
                    <div class="text-gray-400">Total Link Dibuat</div>
                    <div class="text-2xl font-semibold">{{ $totalLinks ?? '0' }}</div>
                </div>
                <div class="bg-[#1e293b] p-4 rounded">
                    <div class="text-gray-400">Link Diblokir</div>
                    <div class="text-2xl font-semibold">{{  $blockedLinks ?? '0' }}</div>
                </div>

            </div>



            <!-- Grafik Placeholder -->
            <div class="bg-[#1e293b] p-6 rounded shadow text-white mb-8">
                <h2 class="text-lg font-semibold mb-4">Grafik Trafik Kunjungan (7 Hari Terakhir)</h2>
                <canvas id="visitChart" class="w-full h-64 bg-gray-700 rounded"></canvas>
            </div>

            <!-- Tabel Seller dan Link Terbaru -->
            

        </main>
    </div>
    <script>
    const ctx = document.getElementById('visitChart').getContext('2d');
    const visitChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($labels ?? []) !!}, // contoh: ['Mon', 'Tue', ...]
            datasets: [{
                label: 'Kunjungan',
                data: {!! json_encode($values ?? []) !!}, // contoh: [10, 20, 30, ...]
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>




</body>

</html>
