
@extends('layouts.sidebar')

@section('isi')
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Product</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Custom scrollbar for demo */
        .scrollable::-webkit-scrollbar {
            width: 6px;
        }
        .scrollable::-webkit-scrollbar-thumb {
            background-color: #4b5563;
            border-radius: 3px;
        }
        /* Styling for list view */
        .product-grid.list-view {
            grid-template-columns: 1fr; /* Single column for list view */
            gap: 16px;
        }
        .product-card.list-view {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px;
            height: auto; /* Allow height to adjust */
            max-height: 200px; /* Limit height for list item */
            overflow: hidden;
        }
        .product-card.list-view .product-image-container {
            width: 120px; /* Fixed width for image in list view */
            height: 120px;
            flex-shrink: 0; /* Prevent image from shrinking */
            border: 1px solid rgba(255,255,255,0.1); /* Slight border for clarity */
        }
        .product-card.list-view .product-image {
            object-fit: cover;
            width: 100%;
            height: 100%;
            border-radius: 0.5rem; /* Match card styling */
        }
        .product-card.list-view .product-info {
            flex-grow: 1;
        }
        .product-card.list-view .bookmark-icon,
        .product-card.list-view .cart-icon {
            position: static; /* Reset positioning */
            margin-left: auto; /* Push them to the right if needed */
            align-self: center; /* Align vertically in flex container */
        }
        .product-card.list-view .action-icons {
            display: flex;
            gap: 8px;
            margin-left: auto; /* Push actions to the right */
            align-items: center;
        }
        /* Hide description in list view to keep it compact */
        .product-card.list-view .product-description {
            display: none;
        }
    </style>
</head>

<main class="flex-1 p-6 space-y-6 ml-64 bg-[#10172A] text-white font-sans">
    <!-- Search, Wishlist, Cart Header -->
    <div class="sticky top-[25px] z-40 bg-[#1e293b] p-2 flex justify-between items-center shadow-md rounded-lg">
        <form action="{{ route('produk-customer.index') }}" method="GET" class="relative max-w-md w-full">
            <input type="text" id="simple-search" name="search"
                class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-4 py-2.5 h-10"
                placeholder="Search product..." value="{{ request('search') }}" />
            <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>

        <div class="flex-1"></div>

        <div class="flex gap-4 items-center">
            <a href="{{ route('wishlist-customer.index') }}" class="text-green-500 text-lg hover:text-green-400">
                <i class="fa-solid fa-bookmark"></i>
            </a>
            <a href="{{ route('cart-customer.index') }}" class="text-white text-lg hover:text-blue-400">
                <i class="fa-solid fa-cart-shopping"></i>
            </a>
        </div>
    </div>

    <!-- Hero Section -->
    <div class="flex justify-between items-center">
        <h2 class="text-5xl font-bold text-white">Temukan produk<br>yang kamu sukai</h2>
        <p class="text-sm text-gray-300 max-w-xl text-right">
            Lorem ipsum dolor sit amet consectetur. Nunc hac viverra aliquam malesuada. Pulvinar facilisis aliquam urna ut hendrerit urna in. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptas repellendus repellat voluptate itaque recusandae, error earum ab id eos. Unde harum illum atque magni incidunt rerum adipisci sequi necessitatibus. Explicabo?
        </p>
    </div>

    <!-- Promotional Grid -->
    <div class="grid grid-cols-4 grid-rows-2 gap-4 mt-6">
        <div class="col-span-2 row-span-2 bg-gray-300 rounded h-[343px] rounded-lg overflow-hidden">
            <img src="{{ asset('img/promosi.png') }}" alt="Promosi" class="w-full h-full object-cover rounded-lg">
        </div>
        <div class="col-span-1 bg-gray-300 rounded h-[160px] rounded-lg overflow-hidden">
            <img src="{{ asset('img/belanja.png') }}" alt="Belanja" class="w-full h-full object-cover rounded-lg">
        </div>
        <div class="col-span-1 bg-gray-300 rounded h-[160px] rounded-lg overflow-hidden">
            <img src="{{ asset('img/berjualan.png') }}" alt="Berjualan" class="w-full h-full object-cover rounded-lg">
        </div>
        <div class="col-span-1 bg-gray-300 rounded h-[163px] rounded-lg overflow-hidden">
            <img src="{{ asset('img/semua.png') }}" alt="Semua" class="w-full h-full object-cover rounded-lg">
        </div>
        <div class="col-span-1 bg-gray-300 rounded h-[163px] rounded-lg overflow-hidden">
            <img src="{{ asset('img/bisa.png') }}" alt="Bisa" class="w-full h-full object-cover rounded-lg">
        </div>
    </div>

    <!-- Filters and Sort -->
    <form action="{{ route('produk-customer.index') }}" method="GET" id="filter-sort-form">
        <input type="hidden" name="search" value="{{ request('search') }}"> {{-- Pertahankan nilai search --}}
        <div class="flex justify-between items-center mt-6 flex-wrap gap-4">
            <div class="flex gap-4 sm:gap-6 flex-wrap">
                {{-- Category Filter (Dihiraukan/Dihapus Sesuai Permintaan) --}}
                {{-- <details class="group relative">
                    <summary class="flex items-center gap-2 border-b border-gray-300 pb-1 text-gray-700 transition-colors hover:border-gray-400 hover:text-gray-900 dark:border-gray-600 dark:text-gray-200 dark:hover:border-gray-700 dark:hover:text-white [&::-webkit-details-marker]:hidden">
                        <span class="text-sm"> Category </span>
                        <span class="transition-transform group-open:-rotate-180">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </span>
                    </summary>
                    <div class="z-50 w-64 divide-y divide-gray-300 rounded border border-gray-300 bg-white shadow-sm group-open:absolute group-open:start-0 group-open:top-8 dark:divide-gray-600 dark:border-gray-600 dark:bg-gray-900">
                        <div class="flex items-center justify-between px-3 py-2">
                            <span class="text-sm text-gray-700 dark:text-gray-200"> 0 Selected </span>
                            <button type="button" class="text-sm text-gray-700 underline transition-colors hover:text-gray-900 dark:text-gray-200 dark:hover:text-white">
                                Reset
                            </button>
                        </div>
                        <fieldset class="p-3">
                            <legend class="sr-only">Checkboxes</legend>
                            <div class="flex flex-col items-start gap-3">
                                <label for="Option1" class="inline-flex items-center gap-3">
                                    <input type="checkbox" class="size-5 rounded border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-900 dark:ring-offset-gray-900 dark:checked:bg-blue-600" id="Option1" />
                                    <span class="text-sm text-gray-700 dark:text-gray-200"> Option 1 </span>
                                </label>
                            </div>
                        </fieldset>
                    </div>
                </details> --}}

                <details class="group relative">
                    <summary
                        class="flex items-center gap-2 border-b border-gray-300 pb-1 text-gray-700 transition-colors hover:border-gray-400 hover:text-gray-900 dark:border-gray-600 dark:text-gray-200 dark:hover:border-gray-700 dark:hover:text-white [&::-webkit-details-marker]:hidden"
                    >
                        <span class="text-sm"> Price </span>
                        <span class="transition-transform group-open:-rotate-180">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </span>
                    </summary>

                    <div
                        class="z-50 w-64 divide-y divide-gray-300 rounded border border-gray-300 bg-white shadow-sm group-open:absolute group-open:start-0 group-open:top-8 dark:divide-gray-600 dark:border-gray-600 dark:bg-gray-900"
                    >
                        <div class="flex items-center justify-between px-3 py-2">
                            <span class="text-sm text-gray-700 dark:text-gray-200"> Apply filter below </span>
                            <button
                                type="button"
                                class="text-sm text-gray-700 underline transition-colors hover:text-gray-900 dark:text-gray-200 dark:hover:text-white"
                                onclick="document.getElementById('MinPrice').value=''; document.getElementById('MaxPrice').value=''; document.getElementById('filter-sort-form').submit();"
                            >
                                Reset
                            </button>
                        </div>

                        <div class="flex items-center gap-3 p-3">
                            <label for="MinPrice">
                                <span class="text-sm text-gray-700 dark:text-gray-200"> Min </span>
                                <input
                                    type="number"
                                    id="MinPrice"
                                    name="min_price" {{-- Tambahkan name --}}
                                    value="{{ request('min_price') }}" {{-- Pertahankan nilai filter --}}
                                    class="mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                                />
                            </label>

                            <label for="MaxPrice">
                                <span class="text-sm text-gray-700 dark:text-gray-200"> Max </span>
                                <input
                                    type="number"
                                    id="MaxPrice"
                                    name="max_price" {{-- Tambahkan name --}}
                                    value="{{ request('max_price') }}" {{-- Pertahankan nilai filter --}}
                                    class="mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                                />
                            </label>
                        </div>
                        <div class="p-3">
                            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Apply Filter</button>
                        </div>
                    </div>
                </details>
            </div>

            <div class="flex items-center gap-2">
                <label for="sort" class="text-sm mb-1 text-white">Sort by:</label>
                <select id="sort" name="sort_by" onchange="document.getElementById('filter-sort-form').submit();"
                    class="bg-[#1E293B] border border-[#334155] text-white text-sm px-2 py-1 rounded">
                    <option value="best_seller" {{ request('sort_by') == 'best_seller' ? 'selected' : '' }}>Best Seller</option>
                    <option value="newest" {{ request('sort_by') == 'newest' || !request('sort_by') ? 'selected' : '' }}>Newest</option>
                    <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                </select>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <div class="flex flex-col text-right justify-center leading-snug text-gray-300">
                    <div>Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results.</div>
                </div>

                <!-- View Mode Toggles -->
                <div class="flex gap-2">
                    <button type="button" id="grid-view-btn" class="w-6 h-6 bg-gray-600 rounded flex items-center justify-center text-white">
                        <i class="fa-solid fa-border-all"></i>
                    </button>
                    <button type="button" id="list-view-btn" class="w-6 h-6 bg-gray-600 rounded flex items-center justify-center text-white">
                        <i class="fa-solid fa-grip"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>


    <!-- Product grid -->
    <div id="product-list-container" class="grid grid-cols-5 gap-4 mt-6">
        @forelse ($products as $product)
            <div class="product-card bg-[#1E293B] p-4 rounded-lg relative shadow-md hover:shadow-lg transition-shadow duration-300" data-product-id="{{ $product->id }}">
                <a href="{{ route('view-product.show', $product->id) }}" class="block">
                    <!-- Bookmark Icon (Add to Wishlist) -->
                    <button type="button" class="bookmark-icon absolute top-3 right-3 w-8 h-8 rounded-full flex items-center justify-center shadow-lg ring-2 ring-white
                        {{ Auth::check() && Auth::user()->hasInWishlist($product->id) ? 'bg-orange-500' : 'bg-gray-400 hover:bg-orange-500' }}"
                        data-product-id="{{ $product->id }}"
                        data-action="toggle-wishlist">
                        <i class="fa-solid fa-bookmark text-sm text-white"></i>
                    </button>

                    <!-- Gambar -->
                    <div class="product-image-container overflow-hidden rounded-lg border-2 border-white mb-3">
                        {{-- Perbaikan: Menggunakan image_path dari database --}}
                        <img src="{{ $product->image_path }}" {{-- Jika image_path menyimpan URL eksternal atau full path asset --}}
                            alt="{{ $product->name }}" class="product-image w-full object-cover" />
                        {{-- ATAU jika gambar disimpan di storage/app/public/product_images dan symlinked ke public/storage: --}}
                        {{-- <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="product-image w-full object-cover" /> --}}
                    </div>

                    <!-- Harga -->
                    <p class="text-orange-400 font-bold mb-1">Rp.{{ number_format($product->price, 0, ',', '.') }},00</p>

                    <!-- Judul -->
                    <p class="font-semibold text-white">{{ $product->name }}</p>

                    <!-- Deskripsi -->
                    <p class="product-description text-sm text-gray-400 leading-tight">
                        {{ Str::limit($product->description, 50) }} {{-- Gunakan Str::limit untuk deskripsi singkat --}}
                    </p>
                </a>    
                <!-- Keranjang (Add to Cart) -->
                <button type="button" class="cart-icon absolute bottom-4 right-4 text-white p-2 rounded-full bg-blue-600 hover:bg-blue-700"
                    data-product-id="{{ $product->id }}"
                    data-action="add-to-cart">
                    <i class="fa-solid fa-cart-shopping"></i>
                </button>
            </div>
        @empty
            <p class="col-span-5 text-center text-gray-400">Tidak ada produk yang ditemukan.</p>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="flex justify-center mt-6 space-x-2">
        {{ $products->appends(request()->except('page'))->links() }}
    </div>
</main>

{{-- Pastikan ini di luar @section('isi') tapi di dalam @endsection --}}
@section('scripts')
<meta name="csrf-token" content="{{ csrf_token() }}"> {{-- Tambahkan CSRF token di sini jika belum ada di layout utama --}}
<script src="{{ asset('js/produk-customer.js') }}" defer></script>
@endsection
@endsection
=======
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

