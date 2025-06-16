@extends('layouts.sidebar')

@section('isi')
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
