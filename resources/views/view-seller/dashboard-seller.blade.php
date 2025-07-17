@extends('layouts.sidebar-seller')

@section('isi')
{{-- Hapus ml-56 dan p-5 dari div ini --}}
{{-- Padding sudah diatur oleh elemen <main> di layouts.sidebar-seller --}}
<div class="bg-white text-gray-800 min-h-screen p-6 rounded-lg shadow-md"> {{-- Ubah background menjadi putih dan teks menjadi gelap, tambahkan padding, rounded, dan shadow --}}
    {{-- Konten dashboard Anda --}}
    <div class="flex justify-between items-center mb-5">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Welcome back, {{ Auth::user()->name }}</h1> {{-- Ubah warna teks --}}
            <p class="text-gray-600 mt-1">Measure everything and export website traffic.</p> {{-- Ubah warna teks --}}
        </div>
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-3 rounded-lg font-medium transition-colors">
            <span>Print report</span>
            <i class="fa-solid fa-print ml-2"></i>
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
        {{-- Product Sold Card --}}
        <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200"> {{-- Ubah background menjadi putih, tambahkan shadow dan border --}}
            <div class="text-gray-600">Product Sold
                <i class="fa-solid fa-eye ml-1"></i>
            </div>
            <div class="text-2xl font-semibold text-gray-800">{{ number_format($totalProductSold, 0, ',', '.') }}</div> {{-- Ubah warna teks --}}
            <div class="flex items-center text-sm mt-1 {{ str_contains($productSoldChange, '+') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} rounded-lg w-20 h-6 justify-center"> {{-- Ubah warna background dan teks untuk indikator perubahan --}}
                {{ $productSoldChange }}
                <i class="fa-solid {{ str_contains($productSoldChange, '+') ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }} ml-1"></i>
            </div>
        </div>

        {{-- Total Revenue Card --}}
        <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200"> {{-- Ubah background menjadi putih, tambahkan shadow dan border --}}
            <div class="text-gray-600">Total revenue
                <i class="fa-solid fa-users ml-1"></i>
            </div>
            <div class="text-2xl font-semibold text-gray-800">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</div> {{-- Ubah warna teks --}}
            <div class="flex items-center text-sm mt-1 {{ str_contains($totalRevenueChange, '+') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} rounded-lg w-20 h-6 justify-center"> {{-- Ubah warna background dan teks untuk indikator perubahan --}}
                {{ $totalRevenueChange }}
                <i class="fa-solid {{ str_contains($totalRevenueChange, '+') ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }} ml-1"></i>
            </div>
        </div>

        {{-- Monthly Transactions Card --}}
        <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200"> {{-- Ubah background menjadi putih, tambahkan shadow dan border --}}
            <div class="text-gray-600">Monthly transactions
                <i class="fa-solid fa-cart-flatbed-suitcase ml-1"></i>
            </div>
            <div class="text-2xl font-semibold text-gray-800">{{ number_format($monthlyTransactionsCount, 0, ',', '.') }}</div> {{-- Ubah warna teks --}}
            <div class="flex items-center text-sm mt-1 {{ str_contains($monthlyTransactionsChange, '+') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} rounded-lg w-20 h-6 justify-center"> {{-- Ubah warna background dan teks untuk indikator perubahan --}}
                {{ $monthlyTransactionsChange }}
                <i class="fa-solid {{ str_contains($monthlyTransactionsChange, '+') ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }} ml-1"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-4">
        {{-- Total Revenue Chart --}}
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md border border-gray-200"> {{-- Ubah background menjadi putih, tambahkan shadow dan border --}}
            <div class="mb-4">
                <h2 class="text-lg text-gray-600 font-semibold">Total revenue</h2> {{-- Ubah warna teks --}}
                <div class="text-3xl font-bold mt-1 text-gray-800">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</div> {{-- Ubah warna teks --}}
                <div class="flex items-center text-sm mt-1 {{ str_contains($totalRevenueChange, '+') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} rounded-lg w-20 h-5 justify-center"> {{-- Ubah warna background dan teks untuk indikator perubahan --}}
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
            <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200 flex flex-col h-full"> {{-- Ubah background menjadi putih, tambahkan shadow dan border --}}
                <h2 class="text-sm text-gray-600 mb-1">Product Sold</h2> {{-- Ubah warna teks --}}
                <div class="text-xl font-bold text-gray-800">{{ number_format($totalProductSold, 0, ',', '.') }}</div> {{-- Ubah warna teks --}}
                <div class="flex items-center text-sm mt-1 {{ str_contains($productSoldChange, '+') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} rounded-lg w-20 h-5 justify-center"> {{-- Ubah warna background dan teks untuk indikator perubahan --}}
                    {{ $productSoldChange }}
                    <i class="fa-solid {{ str_contains($productSoldChange, '+') ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }} ml-1"></i>
                </div>
                <div class="mt-2 flex-grow">
                    <canvas id="profitChart"></canvas>
                </div>
                <div class="mt-3 text-gray-600"> {{-- Ubah warna teks --}}
                    <h5>Last 12 months</h5>
                </div>
            </div>

            {{-- Monthly Transaction Chart --}}
            <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200 flex flex-col h-full"> {{-- Ubah background menjadi putih, tambahkan shadow dan border --}}
                <h2 class="text-sm text-gray-600 mb-1">Monthly Transaction</h2> {{-- Ubah warna teks --}}
                <div class="text-xl font-bold text-gray-800">{{ number_format($monthlyTransactionCountValue, 0, ',', '.') }}</div> {{-- Ubah warna teks --}}
                <div class="flex items-center text-sm mt-1 {{ str_contains($monthlyTransactionsChange, '+') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} rounded-lg w-20 h-5 justify-center"> {{-- Ubah warna background dan teks untuk indikator perubahan --}}
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
    document.addEventListener('DOMContentLoaded', function() {
        // Chart: Total Revenue
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        if (revenueCtx) {
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: revenueLabels,
                    datasets: [{
                        label: 'Total Revenue',
                        data: revenueValues,
                        backgroundColor: 'rgba(59, 130, 246, 0.2)', // Biru terang
                        borderColor: '#3b82f6', // Biru
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
                            ticks: { color: '#6b7280' } // Ubah warna teks sumbu X menjadi abu-abu gelap
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: '#6b7280', // Ubah warna teks sumbu Y menjadi abu-abu gelap
                                callback: function(value) {
                                    return 'Rp' + value.toLocaleString();
                                }
                            },
                            grid: { color: 'rgba(0, 0, 0, 0.1)' } // Ubah warna grid menjadi abu-abu sangat terang
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
        if (profitCtx) {
            new Chart(profitCtx, {
                type: 'bar',
                data: {
                    labels: productSoldLabels,
                    datasets: [
                        {
                            label: 'Current Month',
                            data: productSoldNewProfit,
                            backgroundColor: '#22c55e', // Hijau
                            barThickness: 10,
                        },
                        {
                            label: 'Previous Month',
                            data: productSoldOldProfit,
                            backgroundColor: '#3b82f6', // Biru
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
                            ticks: { color: '#6b7280' } // Ubah warna teks sumbu X menjadi abu-abu gelap
                        },
                        y: {
                            beginAtZero: true,
                            ticks: { color: '#6b7280' }, // Ubah warna teks sumbu Y menjadi abu-abu gelap
                            grid: { color: 'rgba(0, 0, 0, 0.1)' } // Ubah warna grid menjadi abu-abu sangat terang
                        }
                    },
                    plugins: {
                        legend: {
                            labels: { color: '#6b7280' } // Ubah warna teks legend menjadi abu-abu gelap
                        }
                    }
                }
            });
        }

        // Chart: Monthly Transaction
        const usersCtx = document.getElementById('usersChart').getContext('2d');
        if (usersCtx) {
            new Chart(usersCtx, {
                type: 'line',
                data: {
                    labels: monthlyTransactionLabels,
                    datasets: [{
                        label: 'Unique Users',
                        data: monthlyTransactionUsers,
                        backgroundColor: 'rgba(239, 68, 68, 0.2)', // Merah terang
                        borderColor: '#ef4444', // Merah
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
                            ticks: { color: '#6b7280' } // Ubah warna teks sumbu X menjadi abu-abu gelap
                        },
                        y: {
                            beginAtZero: true,
                            ticks: { color: '#6b7280' }, // Ubah warna teks sumbu Y menjadi abu-abu gelap
                            grid: { color: 'rgba(0, 0, 0, 0.1)' } // Ubah warna grid menjadi abu-abu sangat terang
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