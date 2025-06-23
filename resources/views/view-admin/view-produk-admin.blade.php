<x-header-admin title="Product" />

<body class="bg-[#0f172a] text-white font-sans">

    <div class="flex min-h-screen">

        <x-sidebar-admin />


          <main class="flex-1 p-6 space-y-6 ml-64">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Product</h1>
                <div class="flex space-x-2">
                    <input type="text" placeholder="🔍 Search product"
                        class="bg-[#1e293b] text-white rounded px-4 py-2 focus:outline-none w-72" />
                    <button class="bg-[#1e293b] px-4 py-2 rounded text-white">🛒</button>
                </div>
            </div>


            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-2">
                    <span>Categories</span>
                    <button class="bg-[#334155] text-white px-3 py-1 rounded-full text-sm">Graphic design</button>
                    <button class="bg-[#334155] text-white px-3 py-1 rounded-full text-sm">Graphic design</button>
                </div>
                <div class="flex items-center gap-2">
                    <span>Sort by</span>
                    <select class="bg-[#1e293b] text-white px-3 py-1 rounded">
                        <option>Best Seller</option>
                        <option>Newest</option>
                        <option>Price (low to high)</option>
                    </select>
                </div>
                <div class="text-sm text-gray-400">Showing 8 out of 20 results.</div>
                <div class="flex gap-2">
                    <button class="bg-[#334155] p-2 rounded">🪟</button>
                    <button class="bg-[#334155] p-2 rounded">☰</button>
                </div>
            </div>


            <div class="grid grid-cols-4 gap-6 mb-8">

                <div class="bg-[#1e293b] p-4 rounded relative">
                    <div class="absolute top-2 right-2 text-white">🔖</div>
                    <div class="text-orange-400 font-bold mb-1">$30.00</div>
                    <h3 class="text-lg font-semibold">Template canva</h3>
                    <p class="text-sm text-gray-400">Description Description Description Description Description
                        Description Description</p>
                    <button
                        class="flex items-center justify-center mt-4 w-full border border-gray-500 rounded py-1 hover:bg-white hover:text-black transition">
                        🛒 Add to cart
                    </button>
                </div>

                <div class="bg-[#1e293b] p-4 rounded relative">
                    <div class="absolute top-2 right-2 text-white">🔖</div>
                    <div class="text-orange-400 font-bold mb-1">$30.00</div>
                    <h3 class="text-lg font-semibold">Template canva</h3>
                    <p class="text-sm text-gray-400">Description Description Description Description Description
                        Description Description</p>
                    <button
                        class="flex items-center justify-center mt-4 w-full border border-gray-500 rounded py-1 hover:bg-white hover:text-black transition">
                        🛒 Add to cart
                    </button>
                </div>

                <div class="bg-[#1e293b] p-4 rounded relative">
                    <div class="absolute top-2 right-2 text-white">🔖</div>
                    <div class="text-orange-400 font-bold mb-1">$30.00</div>
                    <h3 class="text-lg font-semibold">Template canva</h3>
                    <p class="text-sm text-gray-400">Description Description Description Description Description
                        Description Description</p>
                    <button
                        class="flex items-center justify-center mt-4 w-full border border-gray-500 rounded py-1 hover:bg-white hover:text-black transition">
                        🛒 Add to cart
                    </button>
                </div>

                <div class="bg-[#1e293b] p-4 rounded relative">
                    <div class="absolute top-2 right-2 text-white">🔖</div>
                    <div class="text-orange-400 font-bold mb-1">$30.00</div>
                    <h3 class="text-lg font-semibold">Template canva</h3>
                    <p class="text-sm text-gray-400">Description Description Description Description Description
                        Description Description</p>
                    <button
                        class="flex items-center justify-center mt-4 w-full border border-gray-500 rounded py-1 hover:bg-white hover:text-black transition">
                        🛒 Add to cart
                    </button>
                </div>


            </div>

            <div class="flex justify-center space-x-1 pagination">
                <button class="px-3 py-1 bg-[#1e293b] text-white rounded hover:bg-white hover:text-black">&lt;</button>
                <button class="px-3 py-1 bg-white text-black rounded">1</button>
                <button class="px-3 py-1 bg-[#1e293b] text-white rounded">2</button>
                <button class="px-3 py-1 bg-[#1e293b] text-white rounded">3</button>
                <button class="px-3 py-1 bg-[#1e293b] text-white rounded">4</button>
                <button class="px-3 py-1 bg-[#1e293b] text-white rounded">5</button>
                <button class="px-3 py-1 bg-[#1e293b] text-white rounded">6</button>
                <button class="px-3 py-1 bg-[#1e293b] text-white rounded hover:bg-white hover:text-black">&gt;</button>
            </div>
        </main>
    </div>

    <script src="js/produk.js" defer></script>


</body>

</html>