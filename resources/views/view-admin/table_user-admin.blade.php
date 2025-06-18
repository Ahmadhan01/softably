<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tabel User</title>
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
                    <a href="/table_user-admin"
                        class="flex items-center space-x-2 bg-white/10 text-white px-3 py-2 rounded">
                        <span>👤</span><span>Table User</span>
                    </a>
                    <a href="/notif-admin" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                        <span>🔔</span><span>Notification</span>
                        <span
                            class="ml-auto bg-green-500 text-white text-xs px-2 hover:bg-white/10 py-0.5 rounded-full">4</span>
                    </a>
                    <a href="/faq-admin" class="flex items-center space-x-2  px-3 py-2 rounded">
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
                <a href="/login-admin" class="flex items-center space-x-2 text-gray-400 hover:text-white">
                    <span>🚪</span><span>Log Out</span>
                </a>
            </div>
        </aside>

        <main class="flex-1 p-6 space-y-6 overflow-y-auto">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-semibold">Users</h1>
                <input type="text" placeholder="Search users"
                    class="bg-gray-700 rounded px-4 py-2 text-white w-1/3 placeholder-gray-400">
            </div>

            <div class="grid grid-cols-2 gap-4">

                <div class="bg-gray-800 p-4 rounded-xl flex items-center justify-between border border-blue-500">
                    <div class="flex items-center space-x-4">
                        <div
                            class="bg-blue-600 text-white rounded-full w-12 h-12 flex items-center justify-center text-2xl">
                            😎
                        </div>
                        <div>
                            <div class="text-sm text-gray-300">Total users</div>
                            <div class="text-xl font-semibold text-white">90.4K</div>
                        </div>
                    </div>
                    <div class="text-gray-400">⋮</div>
                </div>


                <div class="bg-gray-800 p-4 rounded-xl flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="bg-gray-400 rounded-full w-12 h-12"></div>
                        <div>
                            <div class="text-sm text-gray-300">New users</div>
                            <div class="text-xl font-semibold text-white">6.6k</div>
                        </div>
                    </div>
                    <div class="text-gray-400">⋮</div>
                </div>
            </div>

            <div class="bg-gray-800 rounded-lg overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-700 text-gray-300">
                        <tr>
                            <th class="p-3"><input type="checkbox"></th>
                            <th class="p-3">Name</th>
                            <th class="p-3">Phone</th>
                            <th class="p-3">Address</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">

                        <template id="user-row">
                            <tr class="hover:bg-gray-700">
                                <td class="p-3"><input type="checkbox"></td>
                                <td class="p-3 flex items-center gap-2">
                                    <div
                                        class="w-6 h-6 bg-black-500 rounded-full flex items-center justify-center text-black font-bold">
                                        ❤</div>
                                    <div>
                                        <div class="font-semibold">Ahmad rusdy</div>
                                        <div class="text-sm text-gray-400">ahmadrusdy@gmail.com</div>
                                    </div>
                                </td>
                                <td class="p-3">(+62)8765 2324 2342</td>
                                <td class="p-3">Yogyakarta</td>
                            </tr>
                        </template>
                        <script>
                            for (let i = 0; i < 8; i++) {
                                const clone = document.getElementById('user-row').content.cloneNode(true);
                                document.currentScript.parentNode.appendChild(clone);
                            }
                        </script>
                    </tbody>
                </table>
            </div>
        </main>

    </div>

</body>

</html>