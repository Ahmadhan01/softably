<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Notification</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0f172a] text-white font-sans">

    <div class="flex min-h-screen">

        <aside class="w-64 bg-[#1e293b] flex flex-col justify-between">
            <div>
                <div class="p-4 text-xl font-bold border-b border-gray-700">Mancasan ID</div>
                <nav class="p-4 space-y-2 text-sm text-gray-300">
                    <a href="/dashboard-admin" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                        <span>🏠</span><span>Dashboard</span>
                    </a>
                    <a href="/produk-admin" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                        <span>🛒</span><span>Product</span>
                    </a>
                    <a href="/chart-admin" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                        <span>📊</span><span>Charts</span>
                    </a>
                    <a href="/tabel_user-admin" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                        <span>👤</span><span>Table User</span>
                    </a>
                    <a href="/notif-admin" class="flex items-center space-x-2 bg-white/10 text-white px-3 py-2 rounded">
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
                            <div class="text-sm text-gray-400"><a href="setting.html">Account settings</a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-4 space-y-2">
                <a href="/setting-admin" class="flex items-center space-x-2 text-gray-400 hover:text-white">
                    <span>⚙️</span><span>Settings</span>
                </a>
                <a href=/login-admin" class="flex items-center space-x-2 text-gray-400 hover:text-white">
                    <span>🚪</span><span>Log Out</span>
                </a>
            </div>
        </aside>

        <main class="flex-1 p-10">
            <h2 class="text-2xl font-semibold mb-10">Notification</h2>
            <div class="flex justify-center items-center h-[60vh]">
                <p class="text-gray-400 text-lg">No notifications</p>
            </div>
        </main>

    </div>

</body>

</html>