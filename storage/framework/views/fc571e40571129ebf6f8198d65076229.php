<?php $__env->startSection('isi'); ?>


<div class="bg-white text-gray-800 min-h-screen p-6 rounded-lg shadow-md"> 
    
    <div class="flex justify-between items-center mb-5">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Welcome back, <?php echo e(Auth::user()->name); ?></h1> 
            <p class="text-gray-600 mt-1">Measure everything and export website traffic.</p> 
        </div>
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-3 rounded-lg font-medium transition-colors">
            <span>Print report</span>
            <i class="fa-solid fa-print ml-2"></i>
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
        
        <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200"> 
            <div class="text-gray-600">Product Sold
                <i class="fa-solid fa-eye ml-1"></i>
            </div>
            <div class="text-2xl font-semibold text-gray-800"><?php echo e(number_format($totalProductSold, 0, ',', '.')); ?></div> 
            <div class="flex items-center text-sm mt-1 <?php echo e(str_contains($productSoldChange, '+') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'); ?> rounded-lg w-20 h-6 justify-center"> 
                <?php echo e($productSoldChange); ?>

                <i class="fa-solid <?php echo e(str_contains($productSoldChange, '+') ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down'); ?> ml-1"></i>
            </div>
        </div>

        
        <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200"> 
            <div class="text-gray-600">Total revenue
                <i class="fa-solid fa-users ml-1"></i>
            </div>
            <div class="text-2xl font-semibold text-gray-800">Rp<?php echo e(number_format($totalRevenue, 0, ',', '.')); ?></div> 
            <div class="flex items-center text-sm mt-1 <?php echo e(str_contains($totalRevenueChange, '+') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'); ?> rounded-lg w-20 h-6 justify-center"> 
                <?php echo e($totalRevenueChange); ?>

                <i class="fa-solid <?php echo e(str_contains($totalRevenueChange, '+') ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down'); ?> ml-1"></i>
            </div>
        </div>

        
        <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200"> 
            <div class="text-gray-600">Monthly transactions
                <i class="fa-solid fa-cart-flatbed-suitcase ml-1"></i>
            </div>
            <div class="text-2xl font-semibold text-gray-800"><?php echo e(number_format($monthlyTransactionsCount, 0, ',', '.')); ?></div> 
            <div class="flex items-center text-sm mt-1 <?php echo e(str_contains($monthlyTransactionsChange, '+') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'); ?> rounded-lg w-20 h-6 justify-center"> 
                <?php echo e($monthlyTransactionsChange); ?>

                <i class="fa-solid <?php echo e(str_contains($monthlyTransactionsChange, '+') ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down'); ?> ml-1"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-4">
        
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md border border-gray-200"> 
            <div class="mb-4">
                <h2 class="text-lg text-gray-600 font-semibold">Total revenue</h2> 
                <div class="text-3xl font-bold mt-1 text-gray-800">Rp<?php echo e(number_format($totalRevenue, 0, ',', '.')); ?></div> 
                <div class="flex items-center text-sm mt-1 <?php echo e(str_contains($totalRevenueChange, '+') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'); ?> rounded-lg w-20 h-5 justify-center"> 
                    <?php echo e($totalRevenueChange); ?>

                    <i class="fa-solid <?php echo e(str_contains($totalRevenueChange, '+') ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down'); ?> ml-1"></i>
                </div>
                <div class="mt-4 h-64">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-4">
            
            <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200 flex flex-col h-full"> 
                <h2 class="text-sm text-gray-600 mb-1">Product Sold</h2> 
                <div class="text-xl font-bold text-gray-800"><?php echo e(number_format($totalProductSold, 0, ',', '.')); ?></div> 
                <div class="flex items-center text-sm mt-1 <?php echo e(str_contains($productSoldChange, '+') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'); ?> rounded-lg w-20 h-5 justify-center"> 
                    <?php echo e($productSoldChange); ?>

                    <i class="fa-solid <?php echo e(str_contains($productSoldChange, '+') ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down'); ?> ml-1"></i>
                </div>
                <div class="mt-2 flex-grow">
                    <canvas id="profitChart"></canvas>
                </div>
                <div class="mt-3 text-gray-600"> 
                    <h5>Last 12 months</h5>
                </div>
            </div>

            
            <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200 flex flex-col h-full"> 
                <h2 class="text-sm text-gray-600 mb-1">Monthly Transaction</h2> 
                <div class="text-xl font-bold text-gray-800"><?php echo e(number_format($monthlyTransactionCountValue, 0, ',', '.')); ?></div> 
                <div class="flex items-center text-sm mt-1 <?php echo e(str_contains($monthlyTransactionsChange, '+') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'); ?> rounded-lg w-20 h-5 justify-center"> 
                    <?php echo e($monthlyTransactionsChange); ?>

                    <i class="fa-solid <?php echo e(str_contains($monthlyTransactionsChange, '+') ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down'); ?> ml-1"></i>
                </div>
                <div class="mt-2 flex-grow">
                    <canvas id="usersChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Data dari Controller
    const revenueLabels = <?php echo json_encode($revenueChartData['months'], 15, 512) ?>;
    const revenueValues = <?php echo json_encode($revenueChartData['revenues'], 15, 512) ?>;

    const productSoldLabels = <?php echo json_encode($productSoldChartData['months'], 15, 512) ?>;
    const productSoldNewProfit = <?php echo json_encode($productSoldChartData['newProfit'], 15, 512) ?>;
    const productSoldOldProfit = <?php echo json_encode($productSoldChartData['oldProfit'], 15, 512) ?>;

    const monthlyTransactionLabels = <?php echo json_encode($monthlyTransactionChartData['months'], 15, 512) ?>;
    const monthlyTransactionUsers = <?php echo json_encode($monthlyTransactionChartData['users'], 15, 512) ?>;

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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.sidebar-seller', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Aplikasi\laragon\www\softably\resources\views/view-seller/dashboard-seller.blade.php ENDPATH**/ ?>