<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard seller</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="https://kit.fontawesome.com/1531486bb6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'dark-bg': '#2d3748',
                        'dark-card': '#2d3748',
                        'dark-hover': '#374151'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-900 text-white">
    <div class="flex h-screen fixed">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 shadow-lg">
            <!-- Logo -->
            <div class="p-2 mt-4 border-b border-gray-700">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center">
                       <img src="" alt="" class="">
                    </div>
                </div>
            </div>

            <!-- Menu -->
            <div class="p-4">
                <p class="text-gray-400 text-xs uppercase tracking-wider mb-4">MENU</p>
                <nav class="space-y-2">
                    <a href="/dashboard-seller" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 bg-gray-700 hover:text-white font-semibold transition-colors">
                        <i class="fa-solid fa-store"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="/My-product-seller" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                        <i class="fas fa-file-alt text-gray-300"></i>
                        <span>My Product</span>
                    </a>
                    <a href="/Chat-seller" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                        <i class="fa-solid fa-message"></i>
                        <span>Chat</span>
                    </a>
                    <a href="/Notification-seller" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                        <i class="fa-solid fa-bell"></i>
                        <span>Notification</span>
                        <div class="flex items-center w-3 h-3 bg-green-600 rounded-full right-5 justify-center py-3 px-4">
                            <div class="flex">4</div>
                        </div>
                    </a>
                     <a href="/Help-Center-seller"
                            class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                            <i class="fa-solid fa-circle-question"></i>
                            <span>Help Center</span>
                        </a>
                </nav>
            </div>

            <!-- User Profile -->
            <div class="absolute bm-2 w-64 p-4 border-t border-gray-700">
                <div class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 transition-colors cursor-pointer">
                    <div class="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center">
                        <img src="/img/man.jpg" alt="" class="rounded-full 1xl">
                    </div>
                    <div class="flex-1">
                        <p class="text-white text-sm font-medium 1xl">Fuad Store</p>
                        <p class="text-gray-400 text-xs">Store settings</p>
                    </div>
                </div>
                <div class="mt-20 space-y-2">
                    <a href="/Settings-seller" class="flex items-center space-x-3 p-2 text-gray-300 hover:text-white transition-colors">
                        <i class="fa-solid fa-gear"></i>
                        <span class="text-sm">Settings</span>
                    </a>
                    <a href="/Log-Out-seller" class="flex items-center space-x-3 p-2 text-gray-300 hover:text-white transition-colors">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span class="text-sm">Log Out</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto border-lg">
            <!-- Header -->
            <div class="p-2.5 border-gray-700">
                <div class="flex justify-between items-center">
                    <div class=" p-2 text-center items-center space-x-4">
                        <h1 class="text-2xl font-bold text-white">Welcome back, Fuad Pharaoh</h1>
                        <p class="text-gray-400 mt-1">Measure everything and export website traffic.</p>
                    </div>
                    <button class="bg-white text-gray-900 px-3 py-3 rounded-lg font-medium hover:bg-green-500 transition-colors pr-4">
                        <span>Print report</span>
                        <i class="fa-solid fa-print"></i>
                    </button>
                </div>
            </div>
        
            <div class="grid grid-cols-3 gap-4 mt-4 p-4 y-1">
                <div class="bg-[#1e293b] p-4 rounded">
                    <div class="text-gray-400">Product Sold
                        <i class="fa-solid fa-eye"></i>
                    </div>
                    <div class="text-2xl font-semibold">40.7K</div>
                    <div class="flex m-1 items-center justify-center text-wite-700 border-cover bg-green-700 rounded-lg w-20 h-6">+8.1%
                        <i class="fa-solid fa-arrow-trend-up m-2"></i>
                    </div>
                </div>

                <div class="bg-[#1e293b] p-4 rounded mt5">
                    <div class="text-gray-400">Total revenue
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div class="text-2xl font-semibold">11.2K</div>
                    <div class="flex m-1 items-center justify-center text-wite-100 border-cover bg-red-900 rounded-lg w-20 h-6">-30.2%
                        <i class="fa-solid fa-arrow-trend-down m-1"></i>
                    </div>
                </div>

                <div class="bg-[#1e293b] p-4 rounded">
                    <div class="text-gray-400">Monthly transactions
                        <i class="fa-solid fa-cart-flatbed-suitcase"></i>
                    </div>
                    <div class="text-2xl font-semibold">$234.2K</div>
                    <div class="flex m-1 items-center justify-center text-wite-100 border-cover bg-green-700 rounded-lg w-20 h-6">+4.1%
                        <i class="fa-solid fa-arrow-trend-up m-2"></i> 
                    </div>
                </div>
            </div>


            <div class="grid grid-cols-3 gap-4 p-6">
                <div class="col-span-2 bg-[#1e293b] p-6 rounded">
                    <div class="mb-4">
                        <h2 class="text-lg text-gray-400 font-semibold">Total revenue</h2>
                        <div class="text-3xl font-bold mt-1">$1220.5K</div>
                        <div class="flex m-1 items-center justify-center text-wite-100 border-cover bg-green-700 rounded-lg w-20 h-5">+8.1%
                          <i class="fa-solid fa-arrow-trend-up m-2"></i>  
                        </div>
                        <canvas id="revenueChart"></canvas>
                    </div>

                </div>
                <div class="flex flex-col gap-4">
                    <div class="bg-[#1e293b] p-4 rounded">
                        <h2 class="text-sm text-gray-400 mb-1">Product Sold</h2>
                        <div class="text-xl font-bold">$234.2K</div>
                        <div class="flex m-1 items-center justify-center text-wite-100 border-cover bg-green-700 rounded-lg w-20 h-5">+8.1%
                            <i class="fa-solid fa-arrow-trend-up m-2"></i> 
                        </div>
                        <canvas id="profitChart" class="w-32 h-32"></canvas>
                        <div class="mt-3 text-gray-500">
                            <h5>Last 12 month</h5>
                        </div>
                    </div>
                    <div class="bg-[#1e293b] p-4 rounded">
                        <h2 class="text-sm text-gray-400 mb-1">Monthly Transaction</h2>
                        <div class="text-xl font-bold">283</div>
                        <div class="flex m-1 items-center justify-center text-wite-100 border-cover bg-green-700 rounded-lg w-20 h-5">-3.2 %
                          <i class="fa-solid fa-arrow-trend-down m-1"></i>   
                        </div>
                        <canvas id="usersChart"></canvas>

                    </div>
                </div>
            </div>
        </main>
    </div>
    <script>
        new Chart(document.getElementById('profitChart'), {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [
                    {
                        label: 'New Profit',
                        data: [70, 65, 60, 80, 55, 60, 75, 90, 45, 50, 100, 120],
                        backgroundColor: '#22c55e',
                    },
                    {
                        label: 'Old Profit',
                        data: [60, 60, 55, 65, 60, 55, 70, 85, 40, 40, 95, 110],
                        backgroundColor: '#3b82f6',
                    }
                ]
            },
            options: {
                scales: {
                    x: { ticks: { color: 'white' } },
                    y: { ticks: { color: 'white' } }
                },
                plugins: {
                    legend: { labels: { color: 'white' } }
                }
            }
        });

        new Chart(document.getElementById('revenueChart'), {
            type: 'line',
            data: {
                labels: ['Feb 1', 'Feb 20', 'Mar 5', 'Apr 10', 'May 1', 'May 17'],
                datasets: [{
                    label: 'Total',
                    data: [0, 55000, 50000, 100000, 150000, 120000],
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    borderColor: '#3b82f6',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                scales: {
                    x: { ticks: { color: 'white' } },
                    y: { ticks: { color: 'white' } }
                },
                plugins: {
                    legend: { labels: { color: 'white' } }
                }
            }
        });

        new Chart(document.getElementById('usersChart'), {
            type: 'line',
            data: {
                labels: ['Feb 1', 'Yesterday', 'Today'],
                datasets: [{
                    label: 'Users',
                    data: [100, 200, 150],
                    backgroundColor: 'rgba(59, 130, 246, 0.3)',
                    borderColor: '#ff1f1f',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                scales: {
                    x: { ticks: { color: 'white' } },
                    y: { ticks: { color: 'white' } }
                },
                plugins: {
                    legend: { labels: { color: 'white' } }
                }
            }
        });
    </script>
</body>
</html>