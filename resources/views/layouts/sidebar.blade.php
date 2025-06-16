<!DOCTYPE html>
<html lang="en">

<body class="bg-[#0f172a] text-white font-sans">
    <div class="">

        <aside class="w-64 bg-[#1e293b] flex flex-col justify-between fixed top-0 left-0 h-full">
            <div>
                <div class="flex justify-center p-4 text-xl font-bold border-b border-gray-700">
                    <img src="{{ asset('img/logo-softably.png') }}" alt="Softably Logo">
                </div>
                <nav class="p-4 space-y-2 text-sm text-gray-300">

                    <a href="/produk-customer" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded"> 
                        <i class="fa-solid fa-box"></i><span>Product</span>
                    </a>
                    <a href="/cart-customer" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                        <i class="fa-solid fa-cart-shopping"></i><span>Cart</span>
                    </a>        
                    <a href="/order-customer" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                        <i class="fa-solid fa-list-ul"></i><span>My Orders</span>
                    </a>    
                    <a href="/notif-customer" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                        <i class="fa-solid fa-bell"></i><span>Notification</span>
                        <span class="ml-auto bg-green-500 text-white text-xs px-2 py-0.5 rounded-full">4</span>
                    </a>
                    <a href="/chat-customer" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                        <i class="fa-solid fa-comments"></i><span>Chat</span>
                        <span class="ml-auto bg-green-500 text-white text-xs px-2 py-0.5 rounded-full">10</span>
                    </a>
                    <a href="/bantuan-customer" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                        <i class="fa-solid fa-circle-question"></i><span>Help Center</span>
                    </a>
                </nav>
            </div>
            <div class="p-4 space-y-2">
                <div class="p-4 py-5 border-t border-gray-700">
                    <a href="/setting-customer">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full overflow-hidden">
                                <img src="img/man.jpg" alt="" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <div class="font-medium">Fuad Pharaoh</div>
                                <div class="text-sm text-gray-400">Account settings</div>
                            </div>
                        </div>
                    </a>
                </div>
                <a href="/setting-customer" class="flex items-center space-x-2 text-gray-400 hover:text-white">
                    <i class="fa-solid fa-gear"></i><span>Settings</span>
                </a>
                <a href="login.html" class="flex items-center space-x-2 text-gray-400 hover:text-white">
                    <i class="fa-sharp fa-solid fa-right-from-bracket"></i> <span>Log Out</span>
                </a>
            </div>
        </aside>
        <div>
        @yield('isi')
        </div>
    </div>
</body>
</html>