<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>

<body class="bg-[#0f172a] text-white font-sans">

    <div class="flex min-h-screen">

        <aside class="w-64 bg-[#1e293b] flex flex-col justify-between fixed top-0 left-0 h-full">
            <div>
                <div class="p-4 text-xl font-bold border-b border-gray-700"><img src="img/logo-softably.png" alt="" width="120px"></div>
                <nav class="p-4 space-y-2 text-sm text-gray-300">

                    <a href="produk_customer.html"
                        class="flex items-center space-x-2 bg-white/10 text-white px-3 py-2 rounded">
                        <i class="fa-solid fa-box" style="color: #ffffff;"></i><span>Product</span>
                    </a>
                    <a href="cart_customer.html" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                        <i class="fa-solid fa-cart-shopping"></i><span>Cart</span>
                    </a>
                    <a href="order_customer.html" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                        <i class="fa-solid fa-list-ul"></i><span>My Orders</span>
                    </a>
                    <a href="notif_customer.html" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                        <i class="fa-solid fa-bell"></i><span>Notification</span>
                        <span class="ml-auto bg-green-500 text-white text-xs px-2 py-0.5 rounded-full">4</span>
                    </a>
                    <a href="chat_customer.html" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                        <i class="fa-solid fa-comments"></i><span>Chat</span>
                        <span class="ml-auto bg-green-500 text-white text-xs px-2 py-0.5 rounded-full">10</span>
                    </a>
                    <a href="faq_customer.html" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                        <i class="fa-solid fa-circle-question"></i><span>FAQ</span>
                    </a>
                </nav>
                <div class="p-4 border-t border-gray-700">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full overflow-hidden">
                            <img src="img/man.jpg" alt="" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <div class="font-medium">{{ Auth::user()->name }}</div>
                            <div class="text-sm text-gray-400"><a href="setting_customer.html">Account settings</a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-4 space-y-2">
                <a href="setting_customer.html" class="flex items-center space-x-2 text-gray-400 hover:text-white">
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


            <div class="sticky top-[25px] z-40 bg-[#1e293b] p-4 flex justify-between items-center shadow-md rounded-lg">
                <!-- Search -->
                <form class="flex items-center max-w-md">
                    <label for="simple-search" class="sr-only">Search</label>
                    <input type="text" id="simple-search"
                        class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5"
                        placeholder="Search product..." required />
                    <button type="submit"
                        class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                        <span class="sr-only">Search</span>
                    </button>
                </form>

                <!-- Spacer Tengah -->
                <div class="flex-1"></div>

                <!-- Bookmark & Cart -->
                <div class="flex gap-4 items-center">
                    <a href="wishlist_customer.html" class="text-lg hover:text-blue-400"><i class="fa-solid fa-bookmark"></i></a>
                    <a href="cart_customer.html" class="text-lg hover:text-blue-400"><i class="fa-solid fa-cart-shopping"></i></a>
                </div>
            </div>





            <div class="flex justify-between items-center">
                <h2 class="text-3xl font-bold">Temukan produk yang kamu sukai</h2>

            </div>
            <p class="text-sm text-gray-300 max-w-xl mt-2">Lorem ipsum dolor sit amet consectetur. Nunc hac viverra
                aliquam malesuada. Pulvinar facilisis aliquam urna ut hendrerit urna in. Lorem ipsum dolor sit amet,
                consectetur adipisicing elit. Voluptas repellendus repellat voluptate itaque recusandae, error earum ab
                id eos. Unde harum illum atque magni incidunt rerum adipisci sequi necessitatibus. Explicabo?</p>

            <div class="grid grid-cols-4 grid-rows-2 gap-4 mt-6">
                <!-- Kiri besar -->
                <div class="col-span-2 row-span-2 bg-gray-300 rounded h-[340px]">
                    <img src="img/digiproduct.jpg" alt="" width="2000">
                </div>

                <!-- Kanan atas 2 kotak kecil -->
                <div class="col-span-1 bg-gray-300 rounded h-[160px]">
                </div>
                <div class="col-span-1 bg-gray-300 rounded h-[160px]"></div>
                <div class="col-span-1 bg-gray-300 rounded h-[163px]"></div>
                <div class="col-span-1 bg-gray-300 rounded h-[163px]"></div>

            </div>



            <!-- Filters -->
            <div class="flex justify-between items-center mt-6">
                <div class="flex gap-2 items-center">
                    <span>Categories:</span>
                    <span class="px-2 py-1 rounded bg-[#1E293B] border border-[#334155]">Graphic design</span>
                    <span class="px-2 py-1 rounded bg-[#1E293B] border border-[#334155]">Graphic design</span>
                </div>

                <div class="flex gap-2 items-center">
                    <label for="sort" class="text-sm mb-1">Sort by:</label>
                    <select id="sort" class="bg-[#1E293B] border border-[#334155] text-white text-sm px-2 py-1 rounded">
                        <option>Best Seller</option>
                        <option>Newest</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <!-- Bungkus Sort by dan Showing agar 1 baris dan sejajar tengah -->
                    <div class="flex flex-col text-right justify-center leading-snug">

                        <div>Showing 8 out of 20 results.</div>
                    </div>

                    <!-- Ikon grid -->
                    <div class="flex gap-2">
                        <a class="w-6 h-6 bg-gray-600 rounded flex items-center justify-center">
                            <i class="fa-solid fa-border-all"></i>
                        </a>
                        <a class="w-6 h-6 bg-gray-600 rounded flex items-center justify-center">
                            <i class="fa-solid fa-grip"></i>
                        </a>
                    </div>
                </div>
            </div>


            <!-- Product grid -->
            <div class="grid grid-cols-4 gap-4 mt-6">
                <!-- Card Product -->
                <template id="product-card">
                    <a href="viewproduk_customer.html" class="block">
                        <div
                            class="bg-[#1E293B] p-4 rounded-lg relative shadow-md hover:shadow-lg transition-shadow duration-300">

                            <!-- Bookmark Ikon -->
                            <div
                                class="absolute top-3 right-3 w-8 h-8 bg-orange-400 text-white rounded-full flex items-center justify-center shadow-lg ring-2 ring-white">
                                <i class="fa-solid fa-bookmark text-sm"></i>
                            </div>

                            <!-- Gambar -->
                            <div class="overflow-hidden rounded-lg border-2 border-white mb-3">
                                <img src="img/download.jpeg" alt="Template CapCut" class="w-full object-cover" />
                            </div>

                            <!-- Harga -->
                            <p class="text-orange-400 font-bold mb-1">Rp.59.999,00</p>

                            <!-- Judul -->
                            <p class="font-semibold">Template CapCut</p>

                            <!-- Deskripsi -->
                            <p class="text-sm text-gray-400 leading-tight">
                                Description Description Description Description Description
                            </p>

                            <!-- Keranjang -->
                            <div class="absolute bottom-4 right-4 text-white">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </div>
                        </div>
                    </a>
                </template>



                <!-- Duplicate cards -->
                <script>
                    const grid = document.currentScript.parentElement;
                    const cardTemplate = document.getElementById("product-card").content;
                    for (let i = 0; i < 12; i++) {
                        grid.appendChild(cardTemplate.cloneNode(true));
                    }
                </script>
            </div>

            <!-- Pagination -->
            <div class="flex justify-center mt-6 space-x-2">
                <button class="px-2 py-1 bg-[#1E293B] rounded">&#x3c;</button>
                <button class="px-3 py-1 bg-blue-600 rounded text-white">1</button>
                <button class="px-2 py-1 bg-[#1E293B] rounded">2</button>
                <button class="px-2 py-1 bg-[#1E293B] rounded">3</button>
                <button class="px-2 py-1 bg-[#1E293B] rounded">4</button>
                <button class="px-2 py-1 bg-[#1E293B] rounded">5</button>
                <button class="px-2 py-1 bg-[#1E293B] rounded">6</button>
            </div>
        </main>
    </div>
    <script src="js/index.js" defer></script>


</body>

</html>