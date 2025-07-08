@extends('layouts.sidebar')

@section('isi')

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    //untuk font
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <style>
    body {
        background-color: #0f172a;
        color: white;
        font-family: "Poppins", sans-serif; /* <--- PERUBAHAN DI SINI */
    }

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

    .product-card.list-view .bookmark-icon {
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

    /* Efek hover scale pada kartu produk */
    .product-card:hover {
        transform: scale(1.05);
        z-index: 30;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
    }

    /* Pastikan header pencarian berada di atas kartu produk yang di-hover */
    /* Z-index 100 untuk search bar */
    .sticky-header-search {
        z-index: 100;
        /* Nilai yang lebih tinggi dari product-card:hover (z-index: 50) */
    }

    /* Styling untuk select standar (yang sekarang digunakan untuk semua filter) */
    .filter-select {
        background-color: #1E293B;
        border: 1px solid #334155;
        color: white;
        font-size: 0.875rem;
        /* text-sm */
        padding: 0.25rem 0.5rem;
        /* px-2 py-1 */
        border-radius: 0.25rem;
        /* rounded */
        /* Menyamakan lebar dengan `Urutkan berdasarkan` */
        width: 180px;
        /* Sesuaikan nilai ini jika perlu */
        appearance: none;
        /* Menyembunyikan panah default di beberapa browser */
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url('data:image/svg+xml;utf8,<svg fill="white" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/><path d="M0 0h24v24H0z" fill="none"/></svg>');
        background-repeat: no-repeat;
        background-position: right 0.5rem center;
        background-size: 1em;
        padding-right: 2rem;
        /* Ruang untuk panah custom */
    }

    /* CSS baru untuk lapisan latar belakang putih */
    .sticky-background-layer {
        position: fixed;
        /* Atau 'absolute' jika parentnya diposisikan */
        top: -25px;
        /* Mulai dari atas viewport */
        left: 100;
        /* Mulai dari kiri viewport */
        width: 100vw;
        /* Lebar penuh viewport */
        height: 100px;
        /* Tinggi yang Anda inginkan */
        background-color: #10172A;
        z-index: 40;
    }
    </style>
</head>

<main class="flex-1 p-6 space-y-6 ml-64 bg-[#10172A] text-white">
    {{-- Lapisan latar belakang putih yang sticky --}}
    <!-- <div class="sticky-background-layer"></div> -->

    <div class="fixed top-3 left-64 right-0 z-50 bg-[#10172A] p-4 flex justify-between items-center ">
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
    <div class="sticky-background-layer"></div>

    <div class="flex justify-between items-center">
        <h2 class="text-5xl font-bold text-white">Temukan produk<br>yang kamu sukai</h2>
        <p class="text-sm text-gray-300 max-w-xl text-right">
            Temukan dan miliki produk digital impianmu dengan mudah di Softably.
            Dari aplikasi inovatif hingga konten kreatif, semua kebutuhan digitalmu
            ada di sini. Mulai jelajahi sekarang dan wujudkan potensimu!
        </p>
    </div>

    <div class="grid grid-cols-4 grid-rows-2 gap-4 mt-6">
        <div class="col-span-2 row-span-2 bg-gray-300 rounded h-[343px] rounded-lg overflow-hidden">
            <img src="{{ asset('img/slogan.png') }}" alt="Promosi" class="w-full h-full object-cover rounded-lg">
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

                {{-- FILTER HARGA SIMPEL (menggunakan class filter-select) --}}
                <div class="flex items-center gap-2">
                    <label for="price-filter" class="text-sm text-white">Harga:</label>
                    <select id="price-filter" name="price_range"
                        onchange="document.getElementById('filter-sort-form').submit();" class="filter-select">
                        <option value="all" {{ request('price_range') == 'all' ? 'selected' : '' }}>Semua Harga</option>
                        <option value="0-50000" {{ request('price_range') == '0-50000' ? 'selected' : '' }}>Di Bawah Rp
                            50.000</option>
                        <option value="50000-100000" {{ request('price_range') == '50000-100000' ? 'selected' : '' }}>Rp
                            50.000 - Rp 100.000</option>
                        <option value="100000-500000" {{ request('price_range') == '100000-500000' ? 'selected' : '' }}>
                            Rp 100.000 - Rp 500.000</option>
                        <option value="500000-max" {{ request('price_range') == '500000-max' ? 'selected' : '' }}>Di
                            Atas Rp 500.000</option>
                    </select>
                </div>
                {{-- END FILTER HARGA SIMPEL --}}

                {{-- FILTER KATEGORI SIMPEL (menggunakan class filter-select) --}}
                <div class="flex items-center gap-2">
                    <label for="category-filter" class="text-sm text-white">Kategori:</label>
                    <select id="category-filter" name="category"
                        onchange="document.getElementById('filter-sort-form').submit();" class="filter-select">
                        <option value="all"
                            {{ request('category') == 'all' || !request('category') ? 'selected' : '' }}>Semua Kategori
                        </option>
                        @if(isset($categories))
                        @foreach ($categories as $category)
                        @if($category != 'all')
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                            {{ ucwords(str_replace('_', ' ', $category)) }}
                        </option>
                        @endif
                        @endforeach
                        @endif
                    </select>
                </div>
                {{-- END FILTER KATEGORI SIMPEL --}}

            </div>

            <div class="flex items-center gap-2">
                <label for="sort" class="text-sm text-white">Urutkan berdasarkan:</label>
                <select id="sort" name="sort_by" onchange="document.getElementById('filter-sort-form').submit();"
                    class="filter-select"> {{-- Tambahkan class filter-select di sini juga --}}
                    <option value="best_seller" {{ request('sort_by') == 'best_seller' ? 'selected' : '' }}>Terlaris
                    </option>
                    <option value="newest"
                        {{ request('sort_by') == 'newest' || !request('sort_by') ? 'selected' : '' }}>Terbaru</option>
                    <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Harga: Terendah
                        ke
                        Tertinggi</option>
                    <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Harga:
                        Tertinggi ke
                        Terendah</option>
                </select>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <div class="flex flex-col text-right justify-center leading-snug text-gray-300">
                    <div>Menampilkan {{ $products->firstItem() }} sampai {{ $products->lastItem() }} dari
                        {{ $products->total() }}
                        hasil.</div>
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
                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}"
                        class="absolute inset-0 w-full h-full object-cover rounded-lg mb-4">
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