<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Chart</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-[#0f172a] text-white font-sans">

    <div class="flex min-h-screen">

        <aside class="w-64 bg-[#1e293b] flex flex-col justify-between fixed top-0 left-0 h-full">

            <div>
                <div class="p-4 text-xl font-bold border-b border-gray-700">Mancasan ID</div>
                <nav class="p-4 space-y-2 text-sm text-gray-300">
                    <a href="/dashboard-admin" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                        <span>🏠</span><span>Dashboard</span>
                    </a>
                    <a href="/produk-admin" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                        <span>🛒</span><span>Product</span>
                    </a>
                    <a href="/chart-admin" class="flex items-center space-x-2 bg-white/10 text-white px-3 py-2 rounded">
                        <span>📊</span><span>Charts</span>
                    </a>
                    <a href="/table_user-admin" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                        <span>👤</span><span>Table User</span>
                    </a>
                    <a href="/notif-admin" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                        <span>🔔</span><span>Notification</span>
                        <span class="ml-auto bg-green-500 text-white text-xs px-2 py-0.5 rounded-full">4</span>
                    </a>
                    <a href="/faq-admin" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                        <span>❓</span><span>FAQ</span>
                    </a>
                </nav>
                <div class="p-4 border-t border-gray-700">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full overflow-hidden">
                            <img src="img/man.jpg" alt="" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <div class="font-medium">Fuad Pharaoh</div>
                            <div class="text-sm text-gray-400"><a href="/setting-admin">Account settings</a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-4 space-y-2">
                <a href="/setting-admin" class="flex items-center space-x-2 text-gray-400 hover:text-white">
                    <span>⚙️</span><span>Settings</span>
                </a>
                <a href="/login-admin" class="flex items-center space-x-2 text-gray-400 hover:text-white">
                    <span>🚪</span><span>Log Out</span>
                </a>
            </div>
        </aside>

        <main class="flex-1 p-6 space-y-6 ml-64">

            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-semibold mb-2">Charts</h1>
                    <p class="text-gray-400 mb-6">All data is displayed here.</p>
                </div>
                <button class="bg-white text-black px-4 py-2 rounded">Print report</button>
            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">


                <div class="bg-[#1e293b] p-4 rounded">
                    <div class="flex items-start justify-between mb-2">
                        <h2 class="text-lg font-medium text-white">Pageviews</h2>
                        <div class="flex gap-4 text-xs text-white -mt-1">
                            <div class="flex items-center gap-1">
                                <span class="w-3 h-2 bg-green-500 inline-block"></span> View
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="w-3 h-2 bg-blue-500 inline-block"></span> Sign up
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="w-3 h-2 bg-yellow-400 inline-block"></span> Transaction
                            </div>
                        </div>
                    </div>
                    <div class="relative w-[300px] h-[300px] mx-auto">
                        <canvas id="pageviewsChart" class="w-full h-full"></canvas>
                    </div>
                </div>



                <div id="barContainer" class="bg-[#1e293b] p-4 rounded">
                    <h2 class="text-lg font-medium mb-2">Revenue by customer type</h2>
                    <canvas id="revenueChart" class="w-32 h-32"></canvas>
                </div>

                <div class="bg-[#1e293b] p-4 rounded">
                    <h2 class="text-lg font-medium mb-2">Monthly online users</h2>
                    <canvas id="usersChart"></canvas>
                </div>

                <div class="bg-[#1e293b] p-4 rounded">
                    <h2 class="text-lg font-medium mb-2">Monthly products sold</h2>
                    <canvas id="productsChart"></canvas>
                </div>
            </div>
        </main>

    </div>
    <script src="js/chart.js" defer></script>

</body>

</html>