<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-[#0f172a] text-white font-sans">

    <div class="flex min-h-screen">

        <aside class="w-64 bg-[#1e293b] flex flex-col justify-between fixed top-0 left-0 h-full">
            <div>
                <div class="p-4 text-xl font-bold border-b border-gray-700">Mancasan ID</div>
                <nav class="p-4 space-y-2 text-sm text-gray-300">
                    <a href="#" class="flex items-center space-x-2 bg-white/10 text-white px-3 py-2 rounded">
                        <span>🏠</span><span>Dashboard</span>
                    </a>
                    <a href="/produk-admin" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                        <span>🛒</span><span>Product</span>
                    </a>
                    <a href="/chart-admin" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
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
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center space-x-2 text-gray-400 hover:text-white">
                        <span>🚪</span><span>Log Out</span>
                    </button>
                </form>
            </div>
        </aside>


        <main class="flex-1 p-6 space-y-6 ml-64">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold">Welcome back, {{ Auth::user()->name ?? 'Guest' }}</h1>
                    <p class="text-gray-400">Measure everything and report website traffic.</p>
                </div>
                <button class="bg-white text-black px-4 py-2 rounded">Print report</button>
            </div>


            <div class="grid grid-cols-4 gap-4">
                <div class="bg-[#1e293b] p-4 rounded">
                    <div class="text-gray-400">👁 Pageviews</div>
                    <div class="text-2xl font-semibold">40.7K</div>
                    <div class="text-green-400 text-sm">+8.1%</div>
                </div>
                <div class="bg-[#1e293b] p-4 rounded">
                    <div class="text-gray-400">👥 Monthly users</div>
                    <div class="text-2xl font-semibold">11.2K</div>
                    <div class="text-red-400 text-sm">-30.2%</div>
                </div>
                <div class="bg-[#1e293b] p-4 rounded">
                    <div class="text-gray-400">📝 New sign ups</div>
                    <div class="text-2xl font-semibold">208</div>
                    <div class="text-green-400 text-sm">+1.2%</div>
                </div>
                <div class="bg-[#1e293b] p-4 rounded">
                    <div class="text-gray-400">🛍 Monthly transactions</div>
                    <div class="text-2xl font-semibold">5.1K</div>
                    <div class="text-green-400 text-sm">+4.1%</div>
                </div>
            </div>


            <div class="grid grid-cols-3 gap-4">
                <div class="col-span-2 bg-[#1e293b] p-6 rounded">
                    <div class="mb-4">
                        <h2 class="text-lg font-semibold">Total revenue</h2>
                        <div class="text-3xl font-bold mt-1">$540.5K</div>
                        <div class="text-green-400 text-sm">+8.1%</div>
                        <canvas id="revenueChart"></canvas>
                    </div>

                </div>
                <div class="flex flex-col gap-4">
                    <div class="bg-[#1e293b] p-4 rounded">
                        <h2 class="text-sm text-gray-400 mb-1">Total profit</h2>
                        <div class="text-xl font-bold">$234.2K</div>
                        <div class="text-green-400 text-sm">+8.1%</div>
                        <canvas id="profitChart" class="w-32 h-32"></canvas>
                    </div>
                    <div class="bg-[#1e293b] p-4 rounded">
                        <h2 class="text-sm text-gray-400 mb-1">Online users</h2>
                        <div class="text-xl font-bold">283</div>
                        <div class="text-red-400 text-sm">-3.2 %</div>
                        <canvas id="usersChart"></canvas>

                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="js/index.js" defer></script>


</body>

</html>
