<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/1531486bb6.js" crossorigin="anonymous"></script>
</head>

<body class="bg-[#23293a] text-white min-h-screen font-sans">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-[#23293a] flex flex-col justify-between border-r border-[#23293a] relative z-10">
            <div>
                <!-- Logo -->
                <div class="p-6 border-b border-gray-700 flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center">
                        <img src="img/man.jpg" alt="" class="rounded-full">
                    </div>
                    <span class="text-white font-semibold">Ini Logo Web</span>
                </div>
                <!-- Menu -->
                <div class="p-4">
                    <p class="text-gray-400 text-xs uppercase tracking-wider mb-4">MENU</p>
                    <nav class="space-y-2">
                        <a href="/dashboard-seller"
                            class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                            <i class="fa-solid fa-store"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="/My-product-seller"
                            class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                            <i class="fas fa-file-alt text-gray-300"></i>
                            <span>My Product</span>
                        </a>
                        <a href="/Chat-seller"
                            class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                            <i class="fa-solid fa-message"></i>
                            <span>Chat</span>
                        </a>
                        <a href="/Notifikasi-seller"
                            class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                            <i class="fa-solid fa-bell"></i>
                            <span>Notification</span>
                            <div
                                class="flex items-center w-3 h-3 bg-green-600 rounded-full right-5 justify-center py-3 px-4 ml-2">
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
            </div>
            <!-- User Profile -->
            <div class="w-full p-4 border-t border-gray-700">
                <div
                    class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 transition-colors cursor-pointer">
                    <div class="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center">
                        <img src="img/icon-soft.png" alt="" class="rounded-full">
                    </div>
                    <div class="flex-1">
                        <p class="text-white text-sm font-medium">Fuad Store</p>
                        <p class="text-gray-400 text-xs">Store settings</p>
                    </div>
                </div>
                <div class="mt-2 space-y-2">
                    <a href="/Settings-seller"
                        class="flex items-center space-x-3 p-2 text-gray-300 hover:bg-gray-700 rounded-lg font-semibold">
                        <i class="fa-solid fa-gear"></i>
                        <span class="text-sm">Settings</span>
                    </a>
                    <a href="/Log-out-seller"
                        class="flex items-center space-x-3 p-2 text-gray-300 hover:bg-gray-700 transition-colors">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span class="text-sm">Log Out</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <div class="border-b border-l border-gray-700 px-10 mt-1 py-5">
                <h1 class="text-3xl font-bold">Settings</h1>
            </div>
            <div class="flex flex-1 overflow-hidden">
                <!-- Left Menu -->
                <div class="w-69 border-l border-r border-gray-700 p-9 hidden md:block">
                    <ul class="space-y-6">
                        <li><a href="#" class="text-gray-400 hover:text-white">Apps settings</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Account</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Chat with Softably</a></li>
                    </ul>
                </div>
                <!-- Right Content -->
                <div class="flex-1 p-10">
                    <!-- Store Info Header -->
                    <div class="flex items-center justify-between border-b border-gray-600 pb-4 mb-8">
                        <div>
                            <h2 class="text-2xl font-bold">Store Info</h2>
                            <p class="text-gray-400 text-sm mt-1">Update your store details</p>
                        </div>
                        <div class="flex gap-3">
                            <button type="button"
                                class="bg-[#8B2E2E] hover:bg-red-700 text-white px-6 py-2 rounded-md font-semibold">Cancel</button>
                            <button type="submit" form="store-info-form"
                                class="bg-[#19C94A] hover:bg-green-600 text-white px-6 py-2 rounded-md font-semibold">Save</button>
                        </div>
                    </div>
                    <form id="store-info-form" class="space-y-7 max-w-2xl">
                        <div class="flex items-center gap-4 mb-4">
                            <label class="block text-gray-300 w-69">Your photo</label>
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 bg-gray-200 rounded-full"></div>
                                <button type="button"
                                    class="text-white px-4 py-2 border border-lg hover:bg-gray-700 border-slate-700 rounded-lg font-semibold">Upload
                                    image</button>
                                <span class="text-gray-400 text-xs">JPG or PNG, 1MB Max</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-300 mb-2">Store Name</label>
                            <input type="text" value="Toko Ahmad"
                                class="w-full bg-[#23293a] border border-gray-600 text-white px-4 py-2 rounded-lg focus:outline-none" />
                        </div>
                        <div>
                            <label class="block text-gray-300 mb-2">Description</label>
                            <textarea rows="3"
                                class="w-full bg-[#23293a] border border-gray-600 text-white px-4 py-2 rounded-lg focus:outline-none">Lorem ipsum dolor sit amet consectetur. Sed consequat venenatis pretium euismod urna eget purus quis. Lobortis enim facilisis sit vel consequat at nunc est montes. Tortor lacus amet suspendisse fermentum volutpat eu vel.</textarea>
                        </div>
                        <div>
                            <label class="block text-gray-300 mb-2">Email</label>
                            <input type="email" value="fuad@gmail.com"
                                class="w-full bg-[#23293a] border border-gray-600 text-white px-4 py-2 rounded-lg focus:outline-none" />
                        </div>
                        <div class="flex gap-4">
                            <div class="w-1/2">
                                <label class="block text-gray-300 mb-2">Phone number</label>
                                <div class="flex gap-2">
                                    <select class="bg-[#23293a] border border-gray-600 text-white px-2 py-2 rounded-lg">
                                        <option>+62</option>
                                        <option>+60</option>
                                        <option>+65</option>
                                    </select>
                                    <input type="text" value="8765 2324 2342"
                                        class="flex-1 bg-[#23293a] border border-gray-600 text-white px-4 py-2 rounded-lg focus:outline-none" />
                                </div>
                            </div>
                            <div class="w-1/2">
                                <label class="block text-gray-300 mb-2">Date of birth</label>
                                <input type="text" value="2001/02/21"
                                    class="w-full bg-[#23293a] border border-gray-600 text-white px-4 py-2 rounded-lg focus:outline-none" />
                            </div>
                        </div>
                        <!-- Tombol di bawah form dihapus, sudah di header -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>