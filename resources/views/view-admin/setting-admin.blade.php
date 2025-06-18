<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Setting</title>
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

        <main class="flex-1 p-10">
            <h2 class="text-2xl font-semibold mb-10">Settings</h2>

            <div class="flex bg-[#111C2E] rounded-md overflow-hidden">

                <div class="w-1/4 border-r border-gray-700 p-6 space-y-6">
                    <div><a href="#" class="text-gray-400 hover:text-white">Apps settings</a></div>
                    <div><a href="#" class="text-white font-medium">Account</a></div>
                    <div><a href="#" class="text-gray-400 hover:text-white">Language & Region</a></div>
                </div>


                <div class="w-3/4 p-6">
                    <h3 class="text-xl font-semibold mb-1">Personal Info</h3>
                    <p class="text-gray-400 text-sm mb-6">Update your personal details</p>


                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-10 h-10 rounded-full overflow-hidden bg-white">
                            <img src="img/man.jpg" alt="photo" class="w-full h-full object-cover">
                        </div>
                        <button class="px-4 py-1 bg-[#1E293B] text-white text-sm rounded border border-gray-500">Upload
                            Image</button>
                        <span class="text-xs text-gray-400">JPG or PNG. 1MB Max</span>
                    </div>


                    <form class="space-y-5">
                        <div>
                            <label class="block text-sm mb-1">Full name</label>
                            <input type="text" value="Fuad Pharaoh"
                                class="w-full bg-[#0E1A2B] border border-gray-700 rounded px-4 py-2 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm mb-1">Email</label>
                            <input type="email" value="fuad@gmail.com"
                                class="w-full bg-[#0E1A2B] border border-gray-700 rounded px-4 py-2 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm mb-1">Phone number</label>
                            <div class="flex">
                                <select class="bg-[#0E1A2B] border border-gray-700 rounded-l px-2 text-sm text-white">
                                    <option>+62</option>
                                    <option>+60</option>
                                </select>
                                <input type="text" value="8765 2324 2342"
                                    class="flex-1 bg-[#0E1A2B] border-t border-b border-r border-gray-700 rounded-r px-4 py-2 text-sm">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm mb-1">Date of birth</label>
                            <input type="date" value="2001-02-21"
                                class="w-full bg-[#0E1A2B] border border-gray-700 rounded px-4 py-2 text-sm text-white">
                        </div>
                        <div>
                            <label class="block text-sm mb-1">Country</label>
                            <input type="text" value="Indonesia"
                                class="w-full bg-[#0E1A2B] border border-gray-700 rounded px-4 py-2 text-sm">
                        </div>


                        <div class="flex justify-end gap-4 mt-6">
                            <button class="px-6 py-2 bg-red-600 text-white rounded">Cancel</button>
                            <button class="px-6 py-2 bg-green-600 text-white rounded">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>

    </div>

</body>

</html>