<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/1531486bb6.js" crossorigin="anonymous"></script>
</head>

<body class="bg-[#23293a] text-white min-h-screen font-sans">
    <div class="flex min-h-screen ">
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
                        <a href="/Notification-seller"
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
                        <img src="img/man.jpg" alt="" class="rounded-full">
                    </div>
                    <div class="flex-1">
                        <p class="text-white text-sm font-medium">Fuad Store</p>
                        <p class="text-gray-400 text-xs">Store settings</p>
                    </div>
                </div>
                <div class="mt-8 space-y-2">
                    <a href="/Settings-seller"
                        class="flex items-center space-x-3 p-2 text-gray-300 hover:text-white transition-colors">
                        <i class="fa-solid fa-gear"></i>
                        <span class="text-sm">Settings</span>
                    </a>
                    <a href="/Log-out-seller"
                        class="flex items-center space-x-3 p-2 text-gray-300 hover:text-white transition-colors">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span class="text-sm">Log Out</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- Main Content -->
        <div class="flex-1 flex flex-col px-8 py-8">
            <div class="flex items-center mb-8 gap-4">
                <a href="/My-product-seller" class="text-white hover:text-gray-300"><i
                        class="fa-solid fa-arrow-left text-xl"></i></a>
                <h1 class="text-2xl font-bold">Add Product</h1>
            </div>
            <form class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Details -->
                <div class="space-y-8">
                    <div class="bg-[#29314a] rounded-lg p-6">
                        <h2 class="font-bold text-lg mb-6">Details</h2>
                        <div class="flex gap-2 mb-6">
                            <div class="w-16 h-16 bg-white rounded-lg"></div>
                            <div class="w-16 h-16 bg-white rounded-lg"></div>
                            <div class="w-16 h-16 bg-white rounded-lg"></div>
                            <div class="w-16 h-16 bg-white rounded-lg"></div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-300 mb-2">Title</label>
                            <input type="text" placeholder="Title"
                                class="w-full bg-[#23293a] border border-gray-600 text-white px-4 py-2 rounded-lg focus:outline-none" />
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-300 mb-2">Description</label>
                            <input type="text" placeholder="Description"
                                class="w-full bg-[#23293a] border border-gray-600 text-white px-4 py-2 rounded-lg focus:outline-none" />
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-300 mb-2">Product Link</label>
                            <input type="text" placeholder="Product link"
                                class="w-full bg-[#23293a] border border-gray-600 text-white px-4 py-2 rounded-lg focus:outline-none" />
                        </div>
                    </div>
                    <div class="bg-[#29314a] rounded-lg p-6">
                        <h2 class="font-bold text-lg mb-6">Pricing</h2>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-300 mb-2">Price</label>
                                <input type="text" placeholder="Title"
                                    class="w-full bg-[#23293a] border border-gray-600 text-white px-4 py-2 rounded-lg focus:outline-none" />
                            </div>
                            <div>
                                <label class="block text-gray-300 mb-2">Currency</label>
                                <input type="text" placeholder="Title"
                                    class="w-full bg-[#23293a] border border-gray-600 text-white px-4 py-2 rounded-lg focus:outline-none" />
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-300 mb-2">Item Quantity</label>
                            <input type="text" placeholder="Title"
                                class="w-full bg-[#23293a] border border-gray-600 text-white px-4 py-2 rounded-lg focus:outline-none" />
                        </div>
                    </div>
                </div>
                <!-- Option -->
                <div class="space-y-8">
                    <div class="bg-[#29314a] rounded-lg p-6">
                        <h2 class="font-bold text-lg mb-6">Option</h2>
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-gray-300 font-medium">Release Time</p>
                                <p class="text-gray-500 text-sm">Set Release Time</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-gray-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500">
                                </div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-gray-300 font-medium">Private Or Public</p>
                                <p class="text-gray-500 text-sm">Private</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-gray-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500">
                                </div>
                            </label>
                        </div>
                        <div class="mb-4">
                            <p class="text-gray-300 font-medium mb-2">Must be filled in by the customer</p>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-300">Name</span>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer">
                                        <div
                                            class="w-11 h-6 bg-gray-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500">
                                        </div>
                                    </label>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-300">Email</span>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer">
                                        <div
                                            class="w-11 h-6 bg-gray-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500">
                                        </div>
                                    </label>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-300">Phone Number</span>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer">
                                        <div
                                            class="w-11 h-6 bg-gray-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500">
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-300 mb-2">Custom Message</label>
                            <textarea rows="3" placeholder="Description"
                                class="w-full bg-[#23293a] border border-gray-600 text-white px-4 py-2 rounded-lg focus:outline-none"></textarea>
                        </div>
                    </div>
                </div>
            </form>
            <div class="flex flex-col md:flex-row justify-end gap-4 mt-8">
                <button class="bg-red-600 text-white px-8 py-3 rounded-lg font-semibold flex items-center gap-2"><i
                        class="fa-solid fa-trash"></i>Delete
                </button>
                <button 
                 class="bg-white text-[#23293a] font-semibold px-8 py-3 rounded-lg shadow hover:bg-gray-200 transition-colors text-center">Cancel
                </button>
                <a href="/My-product-seller">
                 <button class="bg-green-500 text-white px-8 py-3 rounded-lg font-semibold">Add Product</button>
                </a>
            </div>
        </div>
    </div>
</body>

</html>