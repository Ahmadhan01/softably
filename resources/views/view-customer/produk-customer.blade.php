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

        /* Styling for product grid image container (1:1 aspect ratio) */
        .product-image-container {
            width: 100%;
            padding-bottom: 100%;
            position: relative; /* Penting untuk posisi absolut anak di dalamnya (bookmark, cart) */
            overflow: hidden; /* Ini akan memotong gambar yang melebihi batas 1:1 */
            border: 2px solid white;
            border-radius: 0.5rem;
            margin-bottom: 0.75rem;
        }
        .product-image {
            object-fit: cover;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }

        /* Styling for list view - keep original aspect or adjust if needed */
        .product-grid.list-view {
            grid-template-columns: 1fr;
            gap: 16px;
        }
        .product-card.list-view {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px;
            height: auto;
            max-height: 200px;
            overflow: hidden;
        }
        .product-card.list-view .product-image-container {
            width: 120px;
            height: 120px;
            padding-bottom: 0;
            flex-shrink: 0;
        }
        .product-card.list-view .product-image {
            object-fit: cover;
            width: 100%;
            height: 100%;
            border-radius: 0.5rem;
            position: static;
        }
        .product-card.list-view .product-info {
            flex-grow: 1;
        }
        .product-card.list-view .bookmark-icon,
        .product-card.list-view .cart-icon {
            position: static;
            margin-left: auto;
            align-self: center;
        }
        .product-card.list-view .action-icons {
            display: flex;
            gap: 8px;
            margin-left: auto;
            align-items: center;
        }
        .product-card.list-view .product-description {
            display: none;
        }

        /* NEW CSS for card hover scale effect */
        .product-grid {
            display: grid;
        }

        .product-card {
            position: relative;
            transform: scale(1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            z-index: 1;
        }

        /* Menggeser tombol bookmark sedikit ke bawah agar tidak terlalu mepet */
        .product-card .bookmark-icon {
            z-index: 10;
            top: 0.75rem;
            right: 0.75rem;
        }

        /* Posisi tombol keranjang baru: relatif terhadap product-image-container */
        .product-image-container .cart-icon {
            position: absolute;
            bottom: 0.5rem; /* Sesuaikan jarak dari bawah gambar */
            left: 0.5rem; /* Sesuaikan jarak dari kiri gambar */
            z-index: 11;
            background-color: transparent; /* Hapus background biru */
            border: none; /* Pastikan tidak ada border */
            padding: 0; /* Hapus padding default button */
            display: flex; /* Untuk centering icon */
            justify-content: center;
            align-items: center;
            width: 2rem; /* Sesuaikan ukuran tombol jika perlu */
            height: 2rem;
        }

        .product-image-container .cart-icon i { /* Target icon inside button */
            font-size: 1.25rem; /* Ukuran ikon */
            color: white; /* Warna ikon default */
            transition: transform 0.2s ease-in-out, color 0.2s ease-in-out;
        }

        .product-image-container .cart-icon:hover i { /* Efek hover pada ikon */
            transform: scale(1.15); /* Efek membesar sedikit */
            color: #F97316; /* Warna oranye saat hover (sesuaikan dengan warna harga) */
        }


        /* Efek hover scale pada kartu produk */
        .product-card:hover {
            transform: scale(1.05);
            z-index: 50;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
        }

        /* Pastikan header pencarian berada di atas kartu produk yang di-hover */
        .sticky-header-search {
            z-index: 100; /* Nilai yang lebih tinggi dari product-card:hover (z-index: 50) */
        }
    </style>
</head>

<main class="flex-1 p-6 space-y-6 ml-64 bg-[#10172A] text-white font-sans">
    <div class="sticky top-[25px] z-50 bg-[#1e293b] p-2 flex justify-between items-center shadow-md rounded-lg sticky-header-search">
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

    <div class="flex justify-between items-center">
        <h2 class="text-5xl font-bold text-white">Temukan produk<br>yang kamu sukai</h2>
        <p class="text-sm text-gray-300 max-w-xl text-right">
            Lorem ipsum dolor sit amet consectetur. Nunc hac viverra aliquam malesuada. Pulvinar facilisis aliquam urna ut hendrerit urna in. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptas repellendus repellat voluptate itaque recusandae, error earum ab id eos. Unde harum illum atque magni incidunt rerum adipisci sequi necessitatibus. Explicabo?
        </p>
    </div>

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

    <form action="{{ route('produk-customer.index') }}" method="GET" id="filter-sort-form">
        <input type="hidden" name="search" value="{{ request('search') }}">
        <div class="flex justify-between items-center mt-6 flex-wrap gap-4">
            <div class="flex gap-4 sm:gap-6 flex-wrap">
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
                                    name="min_price"
                                    value="{{ request('min_price') }}"
                                    class="mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                                />
                            </label>

                            <label for="MaxPrice">
                                <span class="text-sm text-gray-700 dark:text-gray-200"> Max </span>
                                <input
                                    type="number"
                                    id="MaxPrice"
                                    name="max_price"
                                    value="{{ request('max_price') }}"
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


    <div id="product-list-container" class="grid grid-cols-5 gap-4 mt-6">
        @forelse ($products as $product)
            <div class="product-card bg-[#1E293B] p-4 rounded-lg shadow-md" data-product-id="{{ $product->id }}">
                {{-- Tombol bookmark tetap di luar link detail produk --}}
                <button type="button" class="bookmark-icon absolute w-8 h-8 rounded-full flex items-center justify-center shadow-lg ring-2 ring-white
                    {{ Auth::check() && Auth::user()->hasInWishlist($product->id) ? 'bg-orange-500' : 'bg-gray-400 hover:bg-orange-500' }}"
                    data-product-id="{{ $product->id }}"
                    data-action="toggle-wishlist">
                    <i class="fa-solid fa-bookmark text-sm text-white"></i>
                </button>

                {{-- Link detail produk sekarang hanya membungkus gambar dan teks info --}}
                <a href="{{ route('view-product.show', $product->id) }}" class="product-info-link block">
                    <div class="product-image-container">
                        <img src="{{ $product->image_path }}"
                            alt="{{ $product->name }}" class="product-image" />

                        {{-- Tombol Keranjang sekarang berada DI DALAM product-image-container --}}
                        {{-- Dan tidak lagi membungkus seluruh a tag --}}
                        <button type="button" class="cart-icon absolute"
                            data-product-id="{{ $product->id }}"
                            data-action="add-to-cart">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </button>
                    </div>

                    <p class="text-orange-400 font-bold mb-1">Rp.{{ number_format($product->price, 0, ',', '.') }},00</p>

                    <p class="font-semibold text-white">{{ $product->name }}</p>

                    <p class="product-description text-sm text-gray-400 leading-tight">
                        {{ Str::limit($product->description, 50) }}
                    </p>
                </a>
            </div>
        @empty
            <p class="col-span-5 text-center text-gray-400">Tidak ada produk yang ditemukan.</p>
        @endforelse
    </div>

    <div class="flex justify-center mt-6 space-x-2">
        {{ $products->appends(request()->except('page'))->links() }}
    </div>
</main>

{{-- Pastikan ini di luar @section('isi') tapi di dalam @endsection --}}
@section('scripts')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{ asset('js/produk-customer.js') }}" defer></script>
@endsection
@endsection