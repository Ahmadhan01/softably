@extends('layouts.sidebar-seller')

@section('isi')
{{-- Hapus ml-56 dan p-5 dari div ini --}}
{{-- Padding sudah diatur oleh elemen <main> di layouts.sidebar-seller --}}
<div class="bg-gray-900 text-white min-h-screen">
    {{-- Konten dashboard Anda --}}
    <div class="flex justify-between items-center mb-5">
        <div>
            <h1 class="text-2xl font-bold text-white">Welcome back, {{ Auth::user()->name }}</h1>
            <p class="text-gray-400 mt-1">Measure everything and export website traffic.</p>
        </div>
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-3 rounded-lg font-medium transition-colors">
            <span>Print report</span>
            <i class="fa-solid fa-print ml-2"></i>
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
        {{-- Product Sold Card --}}
        <div class="bg-[#1e293b] p-4 rounded-lg">
            <div class="text-gray-400">Product Sold
                <i class="fa-solid fa-eye ml-1"></i>
            </div>
            <div class="text-2xl font-semibold">{{ number_format($totalProductSold, 0, ',', '.') }}</div>
            <div class="flex items-center text-sm mt-1 {{ str_contains($productSoldChange, '+') ? 'bg-green-700' : 'bg-red-900' }} rounded-lg w-20 h-6 justify-center">
                {{ $productSoldChange }}
                <i class="fa-solid {{ str_contains($productSoldChange, '+') ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }} ml-1"></i>
            </div>
        </div>

        {{-- Total Revenue Card --}}
        <div class="bg-[#1e293b] p-4 rounded-lg">
            <div class="text-gray-400">Total revenue
                <i class="fa-solid fa-users ml-1"></i>
            </div>
            <div class="text-2xl font-semibold">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</div>
            <div class="flex items-center text-sm mt-1 {{ str_contains($totalRevenueChange, '+') ? 'bg-green-700' : 'bg-red-900' }} rounded-lg w-20 h-6 justify-center">
                {{ $totalRevenueChange }}
                <i class="fa-solid {{ str_contains($totalRevenueChange, '+') ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }} ml-1"></i>
            </div>
        </div>

        {{-- Monthly Transactions Card --}}
        <div class="bg-[#1e293b] p-4 rounded-lg">
            <div class="text-gray-400">Monthly transactions
                <i class="fa-solid fa-cart-flatbed-suitcase ml-1"></i>
            </div>
            <div class="text-2xl font-semibold">{{ number_format($monthlyTransactionsCount, 0, ',', '.') }}</div>
            <div class="flex items-center text-sm mt-1 {{ str_contains($monthlyTransactionsChange, '+') ? 'bg-green-700' : 'bg-red-900' }} rounded-lg w-20 h-6 justify-center">
                {{ $monthlyTransactionsChange }}
                <i class="fa-solid {{ str_contains($monthlyTransactionsChange, '+') ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }} ml-1"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-4">
        {{-- Total Revenue Chart --}}
        <div class="lg:col-span-2 bg-[#1e293b] p-6 rounded-lg">
            <div class="mb-4">
                <h2 class="text-lg text-gray-400 font-semibold">Total revenue</h2>
                <div class="text-3xl font-bold mt-1">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <div class="flex items-center text-sm mt-1 {{ str_contains($totalRevenueChange, '+') ? 'bg-green-700' : 'bg-red-900' }} rounded-lg w-20 h-5 justify-center">
                    {{ $totalRevenueChange }}
                    <i class="fa-solid {{ str_contains($totalRevenueChange, '+') ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }} ml-1"></i>
                </div>
                <div class="mt-4 h-64">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-4">
            {{-- Product Sold Chart --}}
            <div class="bg-[#1e293b] p-4 rounded-lg flex flex-col h-full">
                <h2 class="text-sm text-gray-400 mb-1">Product Sold</h2>
                <div class="text-xl font-bold">{{ number_format($totalProductSold, 0, ',', '.') }}</div>
                <div class="flex items-center text-sm mt-1 {{ str_contains($productSoldChange, '+') ? 'bg-green-700' : 'bg-red-900' }} rounded-lg w-20 h-5 justify-center">
                    {{ $productSoldChange }}
                    <i class="fa-solid {{ str_contains($productSoldChange, '+') ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }} ml-1"></i>
                </div>
                <div class="mt-2 flex-grow">
                    <canvas id="profitChart"></canvas>
                </div>
                <div class="mt-3 text-gray-500">
                    <h5>Last 12 months</h5>
                </div>
            </div>

            {{-- Monthly Transaction Chart --}}
            <div class="bg-[#1e293b] p-4 rounded-lg flex flex-col h-full">
                <h2 class="text-sm text-gray-400 mb-1">Monthly Transaction</h2>
                <div class="text-xl font-bold">{{ number_format($monthlyTransactionCountValue, 0, ',', '.') }}</div>
                <div class="flex items-center text-sm mt-1 {{ str_contains($monthlyTransactionsChange, '+') ? 'bg-green-700' : 'bg-red-900' }} rounded-lg w-20 h-5 justify-center">
                    {{ $monthlyTransactionsChange }}
                    <i class="fa-solid {{ str_contains($monthlyTransactionsChange, '+') ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }} ml-1"></i>
                </div>
                <div class="mt-2 flex-grow">
                    <canvas id="usersChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Data dari Controller
    const revenueLabels = @json($revenueChartData['months']);
    const revenueValues = @json($revenueChartData['revenues']);

    const productSoldLabels = @json($productSoldChartData['months']);
    const productSoldNewProfit = @json($productSoldChartData['newProfit']);
    const productSoldOldProfit = @json($productSoldChartData['oldProfit']);

    const monthlyTransactionLabels = @json($monthlyTransactionChartData['months']);
    const monthlyTransactionUsers = @json($monthlyTransactionChartData['users']);

    // Inisialisasi chart setelah halaman selesai dimuat.
    // DOMContentLoaded sudah cukup jika Chart.js dimuat SEBELUM @stack('scripts').
    document.addEventListener('DOMContentLoaded', function() {
        // Chart: Total Revenue
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        if (revenueCtx) { // Tambahkan cek untuk memastikan elemen ditemukan
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: revenueLabels,
                    datasets: [{
                        label: 'Total Revenue',
                        data: revenueValues,
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        borderColor: '#3b82f6',
                        borderWidth: 2,
                        pointBackgroundColor: '#3b82f6',
                        pointRadius: 4,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: '#9ca3af' }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: '#9ca3af',
                                callback: function(value) {
                                    return 'Rp' + value.toLocaleString();
                                }
                            },
                            grid: { color: 'rgba(255, 255, 255, 0.1)' }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Rp' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }

        // Chart: Product Sold
        const profitCtx = document.getElementById('profitChart').getContext('2d');
        if (profitCtx) { // Tambahkan cek untuk memastikan elemen ditemukan
            new Chart(profitCtx, {
                type: 'bar',
                data: {
                    labels: productSoldLabels,
                    datasets: [
                        {
                            label: 'Current Month',
                            data: productSoldNewProfit,
                            backgroundColor: '#22c55e',
                            barThickness: 10,
                        },
                        {
                            label: 'Previous Month',
                            data: productSoldOldProfit,
                            backgroundColor: '#3b82f6',
                            barThickness: 10,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: '#9ca3af' }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: { color: '#9ca3af' },
                            grid: { color: 'rgba(255, 255, 255, 0.1)' }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: { color: '#9ca3af' }
                        }
                    }
                }
            });
        }

        // Chart: Monthly Transaction
        const usersCtx = document.getElementById('usersChart').getContext('2d');
        if (usersCtx) { // Tambahkan cek untuk memastikan elemen ditemukan
            new Chart(usersCtx, {
                type: 'line',
                data: {
                    labels: monthlyTransactionLabels,
                    datasets: [{
                        label: 'Unique Users',
                        data: monthlyTransactionUsers,
                        backgroundColor: 'rgba(239, 68, 68, 0.2)',
                        borderColor: '#ef4444',
                        borderWidth: 2,
                        pointBackgroundColor: '#ef4444',
                        pointRadius: 4,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: '#9ca3af' }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: { color: '#9ca3af' },
                            grid: { color: 'rgba(255, 255, 255, 0.1)' }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }
    });
</script>
@endpush