<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details Product</title>
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
                            class="flex items-center space-x-3 p-3 rounded-lg bg-white text-[#23293a] font-semibold transition-colors">
                            <i class="fas fa-file-alt text-gray-300"></i>
                            <span>My Product</span>
                        </a>
                        <a href="/Chat-seller"
                            class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                            <i class="fa-solid fa-message"></i>
                            <span>Chat</span>
                        </a>
                        <a href="Notification-seller"
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
                    <a href="/Log-Out-seller"
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
                <h1 class="text-2xl font-bold">Details Product</h1>
            </div>
            <div class="bg-[#29314a] rounded-lg p-8 mb-8">
                <div class="flex flex-col lg:flex-row gap-8">
                    <div class="flex-shrink-0 w-full lg:w-1/3 flex flex-col items-center">
                        <div class="w-72 h-56 bg-white rounded-lg mb-4">
                            <img src="" alt="">
                        </div>
                    </div>
                    <div class="flex-1 flex flex-col gap-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gray-400 rounded-full"></div>
                                <span class="font-semibold">Toko Ahmad</span>
                            </div>
                            <a href="/Edit-Product-seller">
                             <button class="border bg-yellow-700 hover:bg-blue-700 border-slate-700 text-white px-4 py-2 rounded-lg font-semibold">Edit</button>
                            </a>
                        </div>
                        <h2 class="font-bold text-xl">Template canva</h2>
                        <p class="text-gray-300 text-sm">Lorem ipsum dolor sit amet consectetur. Pulvinar sed egestas
                            suspendisse lorem. Mauris neque amet purus commodo nulla tellus massa. Amet nisi nibh
                            fermentum cras tincidunt feugiat leo id. A odio leo gravida lectus ipsum.</p>
                        <div class="text-3xl font-bold text-yellow-400 mt-2">$30.00</div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                            <div class="bg-green-600 rounded-lg p-4 flex flex-col items-center">
                                <span class="text-white font-semibold">Product Sold</span>
                                <span class="text-2xl font-bold">40.7K</span>
                            </div>
                            <div class="bg-yellow-500 rounded-lg p-4 flex flex-col items-center">
                                <span class="text-white font-semibold">Product Wish</span>
                                <span class="text-2xl font-bold">40.7K</span>
                            </div>
                            <div class="bg-blue-600 rounded-lg p-4 flex flex-col items-center">
                                <span class="text-white font-semibold">Product Cart</span>
                                <span class="text-2xl font-bold">40.7K</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Recent Transaction (Collapsible) -->
            <div class="bg-[#29314a] rounded-lg p-8 mb-8">
                <button type="button" class="flex items-center justify-between w-full mb-4"
                    onclick="toggleSection('transactionSection', 'transactionIcon')">
                    <h2 class="font-bold text-lg">Recent Transaction</h2>
                    <i id="transactionIcon" class="fa-solid fa-chevron-down transition-transform"></i>
                </button>
                <div id="transactionSection" class="space-y-2">
                    <div class="flex items-center justify-between bg-[#23293a] rounded-lg p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center"><i
                                    class="fa-solid fa-user text-white"></i></div>
                            <span>Ahmad nudy</span>
                        </div>
                        <span class="text-gray-300">ahmadnudy@gmail.com</span>
                        <span class="text-gray-300">+62 8765 2324 2342</span>
                    </div>
                    <div class="flex items-center justify-between bg-[#23293a] rounded-lg p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center"><i
                                    class="fa-solid fa-user text-white"></i></div>
                            <span>Ahmad nudy</span>
                        </div>
                        <span class="text-gray-300">ahmadnudy@gmail.com</span>
                        <span class="text-gray-300">+62 8765 2324 2342</span>
                    </div>
                </div>
            </div>
            <!-- Comment (Collapsible) -->
            <div class="bg-[#29314a] rounded-lg p-8">
                <button type="button" class="flex items-center justify-between w-full mb-4"
                    onclick="toggleSection('commentSection', 'commentIcon')">
                    <h2 class="font-bold text-lg">Comment</h2>
                    <i id="commentIcon" class="fa-solid fa-chevron-down transition-transform"></i>
                </button>
                <div id="commentSection" class="space-y-4">
                    <div class="bg-[#23293a] rounded-lg p-4">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-gray-400 rounded-full"></div>
                            <span class="font-semibold">Fajar Baskial</span>
                        </div>
                        <p class="text-gray-300 text-sm mb-2">Lorem ipsum dolor sit amet consectetur. Pulvinar sed
                            egestas suspendisse lorem. Mauris neque amet purus commodo nulla tellus massa. Amet nisi
                            nibh fermentum cras tincidunt feugiat leo id. A odio leo gravida lectus ipsum.</p>
                        <div class="flex items-center gap-2">
                            <span class="bg-gray-700 text-white px-3 py-1 rounded-lg text-xs">Toko Ahmad</span>
                            <span class="text-gray-400 text-xs">Lorem ipsum dolor sit amet consectetur.</span>
                        </div>
                        <div class="flex gap-2 mt-2">
                            <button
                                class="border border-slate-700 hover:bg-green-900 bg-red-600 text-white px-4 py-2 rounded-lg font-semibold flex items-center gap-2"><i
                                    class="fa-solid fa-trash"></i>Delete</button>
                            <button class="bg-blue-700 border border-slate-700 hover:bg-green-900 text-white px-4 py-2 rounded-lg font-semibold">Reply</button>
                        </div>
                    </div>
                    <div class="bg-[#23293a] rounded-lg p-4">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-gray-400 rounded-full"></div>
                            <span class="font-semibold">Fajar Baskial</span>
                        </div>
                        <p class="text-gray-300 text-sm mb-2">Lorem ipsum dolor sit amet consectetur. Pulvinar sed
                            egestas suspendisse lorem. Mauris neque amet purus commodo nulla tellus massa. Amet nisi
                            nibh fermentum cras tincidunt feugiat leo id. A odio leo gravida lectus ipsum.</p>
                        <div class="flex items-center gap-2">
                            <span class="bg-gray-700 text-white px-3 py-1 rounded-lg text-xs">Toko Ahmad</span>
                            <span class="text-gray-400 text-xs">Lorem ipsum dolor sit amet consectetur.</span>
                        </div>
                        <div class="flex gap-2 mt-2">
                            <button class="border border-slate-700 hover:bg-green-900 bg-red-600 text-white px-4 py-2 rounded-lg font-semibold flex items-center gap-2"><i
                                    class="fa-solid fa-trash"></i>Delete</button>
                            <button class="bg-blue-700 border border-slate-700 hover:bg-green-900 text-white px-4 py-2 rounded-lg font-semibold">Reply</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script>
    function toggleSection(sectionId, iconId) {
        const section = document.getElementById(sectionId);
        const icon = document.getElementById(iconId);
        if (section.classList.contains('hidden')) {
            section.classList.remove('hidden');
            icon.classList.remove('rotate-180');
        } else {
            section.classList.add('hidden');
            icon.classList.add('rotate-180');
        }
    }
</script>