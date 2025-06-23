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
        position: relative;
        /* Penting untuk posisi absolut anak di dalamnya (bookmark, cart) */
        overflow: hidden;
        /* Ini akan memotong gambar yang melebihi batas 1:1 */
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
    /* .product-card.list-view .cart-icon { Removed .cart-icon from here too */
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
    /* .product-image-container .cart-icon { /* This entire rule can be removed as well */
    /* position: absolute;
        bottom: 0.5rem;
        left: 0.5rem;
        z-index: 11;
        background-color: transparent;
        border: none;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 2rem;
        height: 2rem;
    } */

    /* .product-image-container .cart-icon i { */
    /* Target icon inside button */
    /* font-size: 1.25rem;
        color: white;
        transition: transform 0.2s ease-in-out, color 0.2s ease-in-out;
    } */

    /* .product-image-container .cart-icon:hover i { */
    /* Efek hover pada ikon */
    /* transform: scale(1.15);
        color: #F97316;
    } */


    /* Efek hover scale pada kartu produk */
    .product-card:hover {
        transform: scale(1.05);
        z-index: 50;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
    }

    /* Pastikan header pencarian berada di atas kartu produk yang di-hover */
    .sticky-header-search {
        z-index: 100;
        /* Nilai yang lebih tinggi dari product-card:hover (z-index: 50) */
    }
    </style>
</head>

<main class="flex-1 p-6 space-y-6 ml-64 bg-[#10172A] text-white font-sans">
    <div
        class="sticky top-[25px] z-50 bg-[#1e293b] p-2 flex justify-between items-center shadow-md rounded-lg sticky-header-search">
        <form action="{{ route('customer.produk') }}" method="GET" class="relative max-w-md w-full">
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
            Lorem ipsum dolor sit amet consectetur. Nunc hac viverra aliquam malesuada. Pulvinar facilisis aliquam urna
            ut hendrerit urna in. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptas repellendus
            repellat voluptate itaque recusandae, error earum ab id eos. Unde harum illum atque magni incidunt rerum
            adipisci sequi necessitatibus. Explicabo?
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

    <form action="{{ route('customer.produk') }}" method="GET" id="filter-sort-form">
        <input type="hidden" name="search" value="{{ request('search') }}">
        <div class="flex justify-between items-center mt-6 flex-wrap gap-4">
            <div class="flex gap-4 sm:gap-6 flex-wrap">
                <details class="group relative">
                    <summary
                        class="flex items-center gap-2 border-b border-gray-300 pb-1 text-gray-700 transition-colors hover:border-gray-400 hover:text-gray-900 dark:border-gray-600 dark:text-gray-200 dark:hover:border-gray-700 dark:hover:text-white [&::-webkit-details-marker]:hidden">
                        <span class="text-sm"> Harga </span>
                        <span class="transition-transform group-open:-rotate-180">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </span>
                    </summary>

                    <div
                        class="z-50 w-64 divide-y divide-gray-300 rounded border border-gray-300 bg-white shadow-sm group-open:absolute group-open:start-0 group-open:top-8 dark:divide-gray-600 dark:border-gray-600 dark:bg-gray-900">
                        <div class="flex items-center justify-between px-3 py-2">
                            <span class="text-sm text-gray-700 dark:text-gray-200"> Terapkan filter di bawah </span>
                            <button type="button"
                                class="text-sm text-gray-700 underline transition-colors hover:text-gray-900 dark:text-gray-200 dark:hover:text-white"
                                onclick="document.getElementById('MinPrice').value=''; document.getElementById('MaxPrice').value=''; document.getElementById('filter-sort-form').submit();">
                                Reset
                            </button>
                        </div>

                        <div class="flex items-center gap-3 p-3">
                            <label for="MinPrice">
                                <span class="text-sm text-gray-700 dark:text-gray-200"> Min </span>
                                <input type="number" id="MinPrice" name="min_price" value="{{ request('min_price') }}"
                                    class="mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white" />
                            </label>

                            <label for="MaxPrice">
                                <span class="text-sm text-gray-700 dark:text-gray-200"> Max </span>
                                <input type="number" id="MaxPrice" name="max_price" value="{{ request('max_price') }}"
                                    class="mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white" />
                            </label>
                        </div>
                        <div class="p-3">
                            <button type="submit"
                                class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Terapkan
                                Filter</button>
                        </div>
                    </div>
                </details>

                {{-- FILTER KATEGORI BARU --}}
                <details class="group relative">
                    <summary
                        class="flex items-center gap-2 border-b border-gray-300 pb-1 text-gray-700 transition-colors hover:border-gray-400 hover:text-gray-900 dark:border-gray-600 dark:text-gray-200 dark:hover:border-gray-700 dark:hover:text-white [&::-webkit-details-marker]:hidden">
                        <span class="text-sm"> Kategori </span>
                        <span class="transition-transform group-open:-rotate-180">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </span>
                    </summary>

                    <div
                        class="z-50 w-64 divide-y divide-gray-300 rounded border border-gray-300 bg-white shadow-sm group-open:absolute group-open:start-0 group-open:top-8 dark:divide-gray-600 dark:border-gray-600 dark:bg-gray-900">
                        <div class="flex items-center justify-between px-3 py-2">
                            <span class="text-sm text-gray-700 dark:text-gray-200"> Pilih Kategori </span>
                            <button type="button"
                                class="text-sm text-gray-700 underline transition-colors hover:text-gray-900 dark:text-gray-200 dark:hover:text-white"
                                onclick="document.getElementById('category-select').value='all'; document.getElementById('filter-sort-form').submit();">
                                Reset
                            </button>
                        </div>

                        <div class="p-3">
                            <select id="category-select" name="category" onchange="document.getElementById('filter-sort-form').submit();"
                                class="mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                                <option value="all" {{ request('category') == 'all' || !request('category') ? 'selected' : '' }}>Semua Kategori</option>
                                @foreach($categories as $category)
                                    @if($category != 'all') {{-- Hindari duplikasi 'all' jika sudah ditambahkan di controller --}}
                                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                            {{ ucwords(str_replace('_', ' ', $category)) }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </details>
                {{-- END FILTER KATEGORI BARU --}}

            </div>

            <div class="flex items-center gap-2">
                <label for="sort" class="text-sm mb-1 text-white">Urutkan berdasarkan:</label>
                <select id="sort" name="sort_by" onchange="document.getElementById('filter-sort-form').submit();"
                    class="bg-[#1E293B] border border-[#334155] text-white text-sm px-2 py-1 rounded">
                    <option value="best_seller" {{ request('sort_by') == 'best_seller' ? 'selected' : '' }}>Terlaris
                    </option>
                    <option value="newest"
                        {{ request('sort_by') == 'newest' || !request('sort_by') ? 'selected' : '' }}>Terbaru</option>
                    <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Harga: Terendah ke
                        Tertinggi</option>
                    <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Harga: Tertinggi ke
                        Terendah</option>
                </select>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <div class="flex flex-col text-right justify-center leading-snug text-gray-300">
                    <div>Menampilkan {{ $products->firstItem() }} sampai {{ $products->lastItem() }} dari {{ $products->total() }}
                        hasil.</div>
                </div>

                <div class="flex gap-2">
                    <button type="button" id="grid-view-btn"
                        class="w-6 h-6 bg-gray-600 rounded flex items-center justify-center text-white">
                        <i class="fa-solid fa-border-all"></i>
                    </button>
                    <button type="button" id="list-view-btn"
                        class="w-6 h-6 bg-gray-600 rounded flex items-center justify-center text-white">
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
            <button type="button"
                class="bookmark-icon absolute w-8 h-8 rounded-full flex items-center justify-center shadow-lg ring-2 ring-white
                    {{ Auth::check() && Auth::user()->hasInWishlist($product->id) ? 'bg-orange-500' : 'bg-gray-400 hover:bg-orange-500' }}"
                data-product-id="{{ $product->id }}" data-action="toggle-wishlist">
                <i class="fa-solid fa-bookmark text-sm text-white"></i>
            </button>

            {{-- Link detail produk sekarang hanya membungkus gambar dan teks info --}}
            <a href="{{ route('view-product.show', $product->id) }}" class="product-info-link block">
                <div class="product-image-container">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-image" />

                    {{-- TOMBOL KERANJANG DIHAPUS DARI SINI --}}
                    {{--
                    <button type="button" class="cart-icon absolute" data-product-id="{{ $product->id }}"
                    data-action="add-to-cart">
                    <i class="fa-solid fa-cart-shopping"></i>
                    </button>
                    --}}
                </div>

                <p class="text-orange-400 font-bold mb-1">Rp.{{ number_format($product->price, 0, ',', '.') }},00</p>

                <p class="font-semibold text-white">{{ $product->name }}</p>

                {{-- Menampilkan Kategori --}}
                @if($product->category)
                    <p class="text-sm text-gray-500">{{ ucwords(str_replace('_', ' ', $product->category)) }}</p>
                @endif
                {{-- End Menampilkan Kategori --}}

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
{{-- JavaScript yang terkait dengan tombol keranjang juga bisa dihapus jika tidak digunakan lagi --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Function to show toast notifications (keep if used elsewhere)
    function showToast(message, type = 'success') {
        const toastContainer = document.getElementById('toast-container');
        if (!toastContainer) { // Check if container exists
            const newToastContainer = document.createElement('div');
            newToastContainer.id = 'toast-container';
            newToastContainer.classList.add('toast-container');
            document.body.appendChild(newToastContainer);
        }

        const toast = document.createElement('div');
        toast.classList.add('toast', type);
        toast.innerHTML =
            `<i class="fa-solid ${type === 'success' ? 'fa-check-circle' : 'fa-times-circle'}"></i> <span>${message}</span>`;
        document.getElementById('toast-container').appendChild(toast);

        // Animate toast in
        setTimeout(() => {
            toast.classList.add('show');
        }, 100);

        // Animate toast out and remove after a few seconds
        setTimeout(() => {
            toast.classList.remove('show');
            toast.addEventListener('transitionend', () => toast.remove());
        }, 3000); // Toast disappears after 3 seconds

        document.querySelectorAll('.wishlist-toggle').forEach(button => {
        button.addEventListener('click', () => {
            const productId = button.dataset.productId;

            fetch(`/wishlist/toggle/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'added') {
                    button.innerHTML = '❤️';
                } else if (data.status === 'removed') {
                    button.innerHTML = '🤍';
                }
            });
        });
    });
    }

    // Handle Toggle Wishlist button click (existing functionality)
    document.querySelectorAll('[data-action="toggle-wishlist"]').forEach(button => {
        button.addEventListener('click', function(event) {
            event.stopPropagation(); // Stop event propagation
            event.preventDefault(); // Prevent default button action

            const productId = this.dataset.productId;
            const isBookmarked = this.classList.contains('bg-orange-500');
            const url = '{{ route("wishlist.store") }}';

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        _method: isBookmarked ? 'DELETE' : 'POST'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (isBookmarked) {
                            this.classList.remove('bg-orange-500');
                            this.classList.add('bg-gray-400', 'hover:bg-orange-500');
                            showToast('Produk dihapus dari wishlist.', 'success');
                        } else {
                            this.classList.remove('bg-gray-400', 'hover:bg-orange-500');
                            this.classList.add('bg-orange-500');
                            showToast('Produk ditambahkan ke wishlist.', 'success');
                        }
                    } else {
                        showToast(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error toggling wishlist:', error);
                    showToast('Gagal mengubah status wishlist.', 'error');
                });
        });
    });


    // Existing grid/list view toggle logic (from your produk-customer.js, if any)
    const productListContainer = document.getElementById('product-list-container');
    const gridViewBtn = document.getElementById('grid-view-btn');
    const listViewBtn = document.getElementById('list-view-btn');

    // Initialize view based on local storage or default to grid
    const currentView = localStorage.getItem('productView') || 'grid';
    if (currentView === 'list') {
        productListContainer.classList.remove('grid-cols-5');
        productListContainer.classList.add('product-grid', 'list-view');
        document.querySelectorAll('.product-card').forEach(card => {
            card.classList.add('list-view');
        });
        document.querySelectorAll('.product-description').forEach(desc => {
            desc.style.display = 'block'; // Show description in list view
        });
    } else {
        productListContainer.classList.remove('product-grid', 'list-view');
        productListContainer.classList.add('grid-cols-5');
        document.querySelectorAll('.product-card').forEach(card => {
            card.classList.remove('list-view');
        });
        document.querySelectorAll('.product-description').forEach(desc => {
            desc.style.display = 'none'; // Hide description in grid view
        });
    }

    if (gridViewBtn) {
        gridViewBtn.addEventListener('click', function() {
            productListContainer.classList.remove('product-grid', 'list-view');
            productListContainer.classList.add('grid-cols-5');
            document.querySelectorAll('.product-card').forEach(card => {
                card.classList.remove('list-view');
            });
            document.querySelectorAll('.product-description').forEach(desc => {
                desc.style.display = 'none'; // Hide description in grid view
            });
            localStorage.setItem('productView', 'grid');
        });
    }

    if (listViewBtn) {
        listViewBtn.addEventListener('click', function() {
            productListContainer.classList.remove('grid-cols-5');
            productListContainer.classList.add('product-grid', 'list-view');
            document.querySelectorAll('.product-card').forEach(card => {
                card.classList.add('list-view');
            });
            document.querySelectorAll('.product-description').forEach(desc => {
                desc.style.display = 'block'; // Show description in list view
            });
            localStorage.setItem('productView', 'list');
        });
    }
});
</script>
{{-- You can remove the 'js/produk-customer.js' script if all JS is moved here --}}
{{-- <script src="{{ asset('js/produk-customer.js') }}" defer></script> --}}
@endsection
@endsection